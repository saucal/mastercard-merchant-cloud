<?php
/**
 * Main class.
 *
 * @package  MastercardMerchantCloudForWoo
 * @version  1.0.0
 */

namespace MastercardMerchantCloudForWoo;

use GatewayPaymentCore\CorePlugin;
use MastercardMerchantCloudForWoo\Gateways\WC_Mastercard_Merchant_Cloud_Payment_Gateway_CC;

/**
 * Base Plugin class holding generic functionality.
 */
final class Main extends CorePlugin {

	const GATEWAY_ID = 'mastercard_merchant_cloud';

	const PARTNER_SOLUTION_ID = 'WC_PARTNER_SOLUTION_ID';

	/**
	 * Initialize the plugin.
	 */
	public function init() {
		$this->plugin_id                 = self::GATEWAY_ID;
		$this->text_domain               = 'mastercard-merchant-cloud-for-woo';
		$this->plugin_file               = PLUGIN_FILE;
		$this->merchant_registration_url = 'https://mastercard.com';

		$this->registered_gateways = array(
			self::GATEWAY_ID => WC_Mastercard_Merchant_Cloud_Payment_Gateway_CC::class,
		);
	}


	/**
	 * Get the plugin's title.
	 *
	 * @return string
	 */
	public function get_plugin_title() {
		return esc_html__( 'Mastercard Merchant Cloud for Woo', 'mastercard-merchant-cloud-for-woo' );
	}
}
