<?php
defined('ABSPATH') || exit;

class WPZ_Payments_PaymentModule extends DiviExtension {
	
	protected $settings;

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'wpz-payments';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = WPZ_Payments::PLUGIN_SLUG;

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = WPZ_Payments::VERSION;

	/**
	 * DICM_DiviCustomModules constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = WPZ_Payments::PLUGIN_SLUG , $args = array() ) {
		$this->plugin_dir              = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url          = plugin_dir_url( $this->plugin_dir );

		$this->settings = array_merge(WPZ_Payments::DEFAULT_SETTINGS, get_option('wpz_payments_settings', []));

		$this->_builder_js_data        = array(
			'icons_url' => $this->plugin_dir_url.'includes/media/icons'
		);
		require_once(__DIR__.'/stripe.php');
		$this->_frontend_js_data        = array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'currency_symbol' => isset($this->settings['general_currency_symbol']) ? $this->settings['general_currency_symbol'] : WPZ_Payments::DEFAULT_SETTINGS['general_currency_symbol'],
			'currency_symbol_position' => isset($this->settings['general_currency_symbol_position']) ? $this->settings['general_currency_symbol_position'] : WPZ_Payments::DEFAULT_SETTINGS['general_currency_symbol_position']
		);
		
		if (isset($this->settings['stripe_currency']) && in_array(strtoupper($this->settings['stripe_currency']), WPZ_Payments_Stripe::ZERO_DECIMAL_CURRENCIES)) {
			$this->_frontend_js_data['stripe_currency_no_decimals'] = true;
		}
		
		$this->_frontend_js_data['paypal_currency'] = isset($this->settings['paypal_currency']) ? $this->settings['paypal_currency'] : WPZ_Payments::DEFAULT_SETTINGS['paypal_currency'];
		
		add_action('wp_ajax_divi_payment_module_init', [__CLASS__, 'initAjax']);
		add_action('wp_ajax_nopriv_divi_payment_module_init', [__CLASS__, 'initAjax']);
		
		// originally from ds-advanced-pricing-table-for-divi/includes/AdvancedPricingTable.php
		add_filter('et_global_assets_list', function($assets) {
			$hasDiviIcons = isset($assets['et_icons_all']);
			if (!$hasDiviIcons) {
				global $post;
				if (
					preg_match(
						'/'.get_shortcode_regex(['wpz_payments_divi_module']).'/',
						\Feature\ContentRetriever\ET_Builder_Content_Retriever::init()->get_entire_page_content(
							get_post( is_singular() ? $post->ID : ET_Builder_Element::get_current_post_id() )
						)
					)
				) {
						unset($assets['et_icons_base']);
						unset($assets['et_icons_social']);
						$assets['et_icons_all'] = ['css' => et_get_dynamic_assets_path().'/css/icons_all.css'];
				}
			}
			return $assets;
		});

		// includes plugin files
		$this->includes();

		parent::__construct( $name, $args );
	}
	
	public static function initAjax() {
		require_once(__DIR__.'/stripe.php');
		$stripe = new WPZ_Payments_Stripe();
		wp_send_json_success([
			'stripe' => $stripe->getInitData()
		]);
	}
	
	protected function _set_bundle_dependencies() {
		parent::_set_bundle_dependencies();
		$this->_bundle_dependencies['builder'][] = 'wp-i18n';
		$this->_bundle_dependencies['frontend'][] = 'wp-i18n';
		
		if (!empty($this->settings['stripe_enable'])) {
			wp_register_script('stripe-js', 'https://js.stripe.com/v3/');
			$this->_bundle_dependencies['frontend'][] = 'stripe-js';
		}
		
		if (!empty($this->settings['paypal_enable'])) {
			require_once(__DIR__.'/paypal.php');
			$paypal = new WPZ_Payments_PayPal();
			wp_register_script('wpz-paypal-js', $paypal->getJsUrl(), null, null);
			$this->_bundle_dependencies['frontend'][] = 'wpz-paypal-js';
		}
	}
	
	/**
	 * Enqueues minified, production javascript bundles.
	 *
	 * @since 3.1
	 */
	protected function _enqueue_bundles() {
		if ( et_core_is_fb_enabled() ) {
			// Builder Bundle.
			$bundle_url = "{$this->plugin_dir_url}scripts/builder-bundle.min.js";

			wp_enqueue_script( "{$this->name}-builder-bundle", $bundle_url, $this->_bundle_dependencies['builder'], $this->version, true );
			wp_set_script_translations( "{$this->name}-builder-bundle", $this->gettext_domain, WPZ_Payments::$plugin_directory . 'languages' );
		}
		
		
		// Frontend Bundle.
		$bundle_url = "{$this->plugin_dir_url}scripts/frontend-bundle.min.js";

		wp_enqueue_script( "{$this->name}-frontend-bundle", $bundle_url, $this->_bundle_dependencies['frontend'], $this->version, true );
		wp_set_script_translations( "{$this->name}-frontend-bundle", $this->gettext_domain, WPZ_Payments::$plugin_directory . 'languages' );
	}
	
	protected function _enqueue_debug_bundles() {
		parent::_enqueue_debug_bundles();
		// Divi/includes/builder/api/DiviExtension.php
		$site_url           = wp_parse_url( get_site_url() );
		$styles_url = "{$site_url['scheme']}://{$site_url['host']}:3000/styles/style.css";
		wp_enqueue_style( "{$this->name}-styles", $styles_url, array(), $this->version );
	}

	/**
	 * includes plugin files
	 *
	 */
	public function includes(){
		include_once $this->plugin_dir . 'helpers.php';
	}
}

new WPZ_Payments_PaymentModule;