<?php
/**
 * Acme CC Payment Gateway class.
 *
 * @class       WC_Acme_Payment_Gateway_CC
 * @version     1.0.0
 * @package     WooCommerceGatewayAcmePlugin/Gateway/
 */

namespace WooCommerceGatewayAcmePlugin\Gateways;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use GatewayPaymentCore\Gateways\WC_Abstract_Payment_Gateway_CC;
use WooCommerceGatewayAcmePlugin\Main;
use function WooCommerceGatewayAcmePlugin\wc_acme_plugin;

/**
 * Show the payment form for Payment Gateway.
 */
final class WC_Acme_Payment_Gateway_CC extends WC_Abstract_Payment_Gateway_CC {

	/**
	 * Gateway ID.
	 */
	const ID = Main::GATEWAY_ID;

	/**
	 * Initialize Payment Gateway.
	 */
	public function __construct() {
		// Load the plugin instance.
		$this->core_plugin = wc_acme_plugin();

		// Set the partner solution ID.
		$this->partner_solution_id = Main::PARTNER_SOLUTION_ID;

		// Load the gateway settings.
		$this->id                 = self::ID;
		$this->method_title       = __( 'Acme Gateway', $this->core_plugin->text_domain() );
		$this->method_description = __( 'Accept secure payments on your WooCommerce store.', $this->core_plugin->text_domain() );
		$this->icon               = $this->core_plugin->payment_core()->utils()->plugin_url() . '/assets/images/logo.png';

		$this->build();
	}
}
