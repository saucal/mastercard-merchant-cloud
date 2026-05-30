# Mastercard Merchant Cloud for WooCommerce

WooCommerce payment gateway for the Mastercard Gateway (Mastercard Merchant Cloud). Accept card payments with hosted sessions / hosted checkout, 3-D Secure, tokenization, refunds, captures, and webhooks.

This is the public development repository for the plugin published on WordPress.org. The compiled JS/CSS shipped in the plugin is built from the source in this repository.

## Requirements

- WordPress 6.0+
- WooCommerce 9.0+
- PHP 8.0+
- Node.js (see `.nvmrc`) and npm
- Composer

## Clone

`packages/payment-core` is a git submodule. Clone with:

```
git clone --recursive https://github.com/saucal/mastercard-merchant-cloud.git
```

If you already cloned without `--recursive`, initialize the submodule with:

```
git submodule update --init
```

## Install dependencies

```
npm install        # installs Node deps (root + packages/payment-core) and runs composer install for both
```

The `preinstall` hook runs `cd packages/payment-core && npm install` and the `postinstall` hook runs `composer install && cd packages/payment-core && composer install`, so a single `npm install` at the root bootstraps the entire project.

## Build

```
npm run build      # compiles assets (build:core) and regenerates the translation template (build:makepot)
npm run watch      # rebuild assets on change during development
```

Compiled assets are emitted under `packages/payment-core/assets/`. Source lives in `packages/payment-core/src/`; the webpack config is `packages/payment-core/webpack.config.js`.

## Package a release

```
npm run package    # builds assets and produces mastercard-merchant-cloud.zip
```

## Repository layout

- `mastercard-merchant-cloud.php` — main plugin bootstrap.
- `includes/` — plugin-specific PHP (the Mastercard gateway implementation).
- `packages/payment-core/` — the reusable payment-core package (a git submodule): gateway abstractions, AJAX handlers, JS/CSS source and built assets.
- `scripts/package.sh` — release packaging script.

## License

GPL-2.0+
