<?php
/**
 * Mastercard Merchant Cloud CC Payment Gateway class.
 *
 * @class       WC_Mastercard_Merchant_Cloud_Payment_Gateway_CC
 * @version     1.0.0
 * @package     MastercardMerchantCloud/Gateway/
 */

namespace MastercardMerchantCloud\Gateways;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use GatewayPaymentCore\Gateways\WC_Abstract_Payment_Gateway_CC;
use MastercardMerchantCloud\Main;
use function MastercardMerchantCloud\wc_mmcfw_plugin;

/**
 * Show the payment form for Payment Gateway.
 */
final class WC_Mastercard_Merchant_Cloud_Payment_Gateway_CC extends WC_Abstract_Payment_Gateway_CC {

	/**
	 * Gateway ID.
	 */
	const ID = Main::GATEWAY_ID;

	/**
	 * Initialize Payment Gateway.
	 */
	public function __construct() {
		// Load the plugin instance.
		$this->core_plugin = wc_mmcfw_plugin();

		// Set the partner solution ID.
		$this->partner_solution_id = Main::PARTNER_SOLUTION_ID;

		// Load the gateway settings.
		$this->id                 = self::ID;
		$this->method_title       = __( 'Mastercard Merchant Cloud', '__PAYMENTS_CORE_TEXT_DOMAIN__' );
		$this->method_description = __( 'Accept secure payments on your WooCommerce store.', '__PAYMENTS_CORE_TEXT_DOMAIN__' );
		$this->icon               = $this->core_plugin->payment_core()->utils()->plugin_url() . '/assets/images/logo.png';

		$this->build();
	}
}
