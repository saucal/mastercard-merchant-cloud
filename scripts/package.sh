#!/usr/bin/env bash
set -euo pipefail

SOURCE_DIR="$(cd "$(dirname "$0")/.." && pwd)"
SLUG="$(node -p "require('$SOURCE_DIR/package.json').config.wp_org_slug")"
BUILD_DIR="$(mktemp -d)"
STAGE="$BUILD_DIR/$SLUG"

trap 'rm -rf "$BUILD_DIR"' EXIT

echo "==> Building assets in source directory..."
(cd "$SOURCE_DIR/packages/payment-core" && npx wp-scripts build)

echo "==> Copying files to staging directory..."
# Derive exclude list from .gitattributes export-ignore rules at runtime.
# Include package manager files first (needed for installs, deleted before zipping),
# then apply excludes — rsync processes filter rules in order, first match wins.
{
	echo "+ composer.json"
	echo "+ composer.lock"
	echo "+ packages/payment-core/composer.json"
	echo "+ packages/payment-core/composer.lock"
	grep 'export-ignore' "$SOURCE_DIR/.gitattributes" | awk '{print "- " $1}'
	echo "- vendor"
	echo "- /scripts"
} | rsync -a --filter="merge -" "$SOURCE_DIR/" "$STAGE/"

echo "==> Running text replacements..."
node "$SOURCE_DIR/packages/payment-core/scripts/replace-text-domain.js" \
	__PAYMENTS_CORE_TEXT_DOMAIN__ "$SLUG" --base-dir="$STAGE"
node "$SOURCE_DIR/packages/payment-core/scripts/replace-text-domain.js" \
	PAYMENTS_CORE_HOOK_PREFIX "${SLUG//-/_}" --base-dir="$STAGE"

echo "==> Installing production composer dependencies (root)..."
(cd "$STAGE" && composer install --no-dev --optimize-autoloader --no-scripts)

echo "==> Installing production composer dependencies (payment-core)..."
(cd "$STAGE/packages/payment-core" && composer install --no-dev --optimize-autoloader --no-scripts)

echo "==> Generating translation template..."
mkdir -p "$STAGE/i18n/languages"
(cd "$STAGE" && "$SOURCE_DIR/node_modules/.bin/wpi18n" makepot \
	--domain-path="i18n/languages" \
	--pot-file="$SLUG.pot" \
	--type="plugin" \
	--main-file="$SLUG.php" \
	--exclude="node_modules,tests,docs,docker,vendor")

echo "==> Cleaning up package manager files..."
rm -f "$STAGE/composer.json" "$STAGE/composer.lock"
rm -f "$STAGE/packages/payment-core/composer.json" "$STAGE/packages/payment-core/composer.lock"

echo "==> Creating archive..."
(cd "$BUILD_DIR" && zip -q -r "$SLUG.zip" "$SLUG")
mv "$BUILD_DIR/$SLUG.zip" "$SOURCE_DIR/$SLUG.zip"

echo "==> Done! Archive: $SLUG.zip"
