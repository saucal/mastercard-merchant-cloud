<?php
/**
 * Main class.
 *
 * @package  WooCommerceGatewayAcmePlugin
 * @version  1.0.0
 */

namespace WooCommerceGatewayAcmePlugin;

use GatewayPaymentCore\CorePlugin;
use WooCommerceGatewayAcmePlugin\Gateways\WC_Acme_Payment_Gateway_CC;

/**
 * Base Plugin class holding generic functionality.
 */
final class Main extends CorePlugin {

	const GATEWAY_ID = 'acme';

	const PARTNER_SOLUTION_ID = 'WC_PARTNER_SOLUTION_ID';

	/**
	 * Initialize the plugin.
	 */
	public function init() {
		$this->plugin_id                 = self::GATEWAY_ID;
		$this->text_domain               = 'woocommerce-gateway-acme-plugin';
		$this->plugin_file               = PLUGIN_FILE;
		$this->merchant_registration_url = 'https://mastercard.com';

		$this->registered_gateways = array(
			self::GATEWAY_ID => WC_Acme_Payment_Gateway_CC::class,
		);
	}


	/**
	 * Get the plugin's title.
	 *
	 * @return string
	 */
	public function get_plugin_title() {
		return esc_html__( 'WooCommerce Gateway Acme Plugin', 'woocommerce-gateway-acme-plugin' );
	}
}
