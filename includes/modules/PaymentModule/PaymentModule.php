<?php
defined('ABSPATH') || exit;

/**
 *
 * @since 1.0.0
 */
class WPZ_Payments_Divi_Module extends ET_Builder_Module {

	public  $slug       = 'wpz_payments_divi_module';
	public  $vb_support = 'on';
	private $iconSvgs   = [];


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co',
	);

	private function getIconSvg($svg, $spinner = false) {
		if ( ! isset($this->iconSvgs[ $svg ]) ) {
			global $wp_filesystem;
			if ( empty($wp_filesystem) ) {
				WP_Filesystem();
			}

			$svg = sanitize_key($svg);

			if ( $spinner ) {
				$iconPath = WPZ_Payments::$plugin_directory . 'includes/media/icons/spinners/' . $svg . '.svg';
			} else {
				$iconPath = WPZ_Payments::$plugin_directory . 'includes/media/icons/' . $svg . '.svg';
			}

			$this->iconSvgs[ $svg ] = $wp_filesystem->get_contents($iconPath);
		}

		return $this->iconSvgs[ $svg ];
	}

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		$this->name              = esc_html__('Payment Module', 'wpz-payments');
		$this->icon_path         = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->accent_color      = '#2ea3f2';
		$this->main_css_element  = '%%order_class%% .wpz-payments-container';
		$this->modal_css_element = '%%order_class%%_payments_container';

		// Toggle settings
		$this->settings_modal_toggles = apply_filters('wpz_payments_divi_module_toggles', array(
			'general'  => array(
				'toggles' => array(
					'product'     => array(
						'title' => esc_html__('Product', 'wpz-payments'),
					),
					'price'       => array(
						'title' => esc_html__('Price', 'wpz-payments'),
					),
					'quantity'    => array(
						'title' => esc_html__('Quantity', 'wpz-payments'),
					),
					'display'     => array(
						'title' => esc_html__('Display Mode', 'wpz-payments'),
					),
					'form'        => array(
						'title' => esc_html__('Form Settings', 'wpz-payments'),
					),
					'form_fields' => array(
						'title' => esc_html__('Form Fields', 'wpz-payments'),
					),
					'payment'     => array(
						'title' => esc_html__('Payment Settings', 'wpz-payments'),
					),
					'confirm'     => array(
						'title' => esc_html__('Payment Confirmation', 'wpz-payments'),
					),
					'success'     => array(
						'title' => esc_html__('Payment Success', 'wpz-payments'),
					),
					'error'       => array(
						'title' => esc_html__('Payment Error', 'wpz-payments'),
					),
					'load_error'  => array(
						'title' => esc_html__('Loading Error', 'wpz-payments'),
					),
					'reload_info'  => array(
						'title' => esc_html__('Reload Info Message', 'wpz-payments'),
					),
					'preloader'   => array(
						'title' => esc_html__('Preloader', 'wpz-payments'),
					),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'module_text'                     => esc_html__('Module Text', 'wpz-payments'),
					'title'                           => array(
						'title'             => esc_html__('Product Name', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'P',
								'icon_svg' => $this->getIconSvg('typography_text'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $this->getIconSvg('padding_margins'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $this->getIconSvg('border'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $this->getIconSvg('background_colors'),
							),
						),
					),
					'description'                     => array(
						'title'             => esc_html__('Description', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'P',
								'icon_svg' => $this->getIconSvg('typography_text'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $this->getIconSvg('padding_margins'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $this->getIconSvg('border'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $this->getIconSvg('background_colors'),
							),
						),
					),
					'form_fields_design'              => esc_html__('Form Fields', 'wpz-payments'),
					'form_fields_error'               => esc_html__('Form Fields Error', 'wpz-payments'),
					'fields_validation'               => array(
						'title'             => esc_html__('Fields Validation', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'P',
								'icon_svg' => $this->getIconSvg('typography_text'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $this->getIconSvg('padding_margins'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $this->getIconSvg('border'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $this->getIconSvg('background_colors'),
							),
						),
					),
					'labels'                          => esc_html__('Labels', 'wpz-payments'),
					'price_custom_field'              => esc_html__('Custom Price Field', 'wpz-payments'),
					'price_custom_currency'           => esc_html__('Custom Price Currency', 'wpz-payments'),
					'price_label'                     => esc_html__('Price Label', 'wpz-payments'),
					'price_fixed'                     => esc_html__('Fixed Price', 'wpz-payments'),
					'checkbox'                        => array(
						'title'             => esc_html__('Checkboxes', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'checkbox' => array(
								'name' => esc_html__('Checkbox', 'wpz-payments'),
							),
							'label'    => array(
								'name' => esc_html__('Label', 'wpz-payments'),
							),
						),
					),
					'notes_field_instructions_design' => array(
						'title'             => esc_html__('Notes Field Instructions', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'P',
								'icon_svg' => $this->getIconSvg('typography_text'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $this->getIconSvg('padding_margins'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $this->getIconSvg('border'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $this->getIconSvg('background_colors'),
							),
						),
					),
					'notification_error'              => array(
						'title'             => esc_html__('Error Message', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'P',
								'icon_svg' => $this->getIconSvg('typography_text'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $this->getIconSvg('padding_margins'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $this->getIconSvg('border'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $this->getIconSvg('background_colors'),
							),
						),
					),
					'notification_success'            => array(
						'title'             => esc_html__('Success Message', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'P',
								'icon_svg' => $this->getIconSvg('typography_text'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $this->getIconSvg('padding_margins'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $this->getIconSvg('border'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $this->getIconSvg('background_colors'),
							),
						),
					),
					'confirm'     => array(
						'title' => esc_html__('Payment Confirmation', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'P',
								'icon_svg' => $this->getIconSvg('typography_text'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $this->getIconSvg('padding_margins'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $this->getIconSvg('border'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $this->getIconSvg('background_colors'),
							),
						),
					),
					'reload_message'     => array(
						'title' => esc_html__('Reload Message', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'P',
								'icon_svg' => $this->getIconSvg('typography_text'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $this->getIconSvg('padding_margins'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $this->getIconSvg('border'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $this->getIconSvg('background_colors'),
							),
						),
					),
					'confirm_buttons'     => array(
						'title' => esc_html__('Payment Confirmation Buttons', 'wpz-payments')
					),
					'pay_button'                      => esc_html__('Stripe Pay Button', 'wpz-payments'),
					'paypal_button'                      => esc_html__('PayPal Button', 'wpz-payments'),
					'preloader'                       => array(
						'title'             => esc_html__('Preloader', 'wpz-payments'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'icon' => array(
								'name' => esc_html__('Icon', 'wpz-payments'),
							),
							'text' => array(
								'name' => esc_html__('Text', 'wpz-payments'),
							),
						),
					),
				),
			),

			'custom_css' => array(
				'toggles' => array(
					'title'                    => array(
						'label'    => __('Product Name', 'wpz-payments'),
						'selector' => "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title",
					),
					'description'              => array(
						'label'    => __('Description', 'wpz-payments'),
						'selector' => "%%order_class%% .wpz-payments-description, $this->modal_css_element .wpz-payments-description",
					),
					'price'                    => array(
						'label'    => __('Fixed Price Text', 'wpz-payments'),
						'selector' => "%%order_class%% .wpz-payments-fixed-price-amount, $this->modal_css_element .wpz-payments-fixed-price-amount",
					),
					'notes_field_instructions' => array(
						'label'    => __('Notes Field Instructions', 'wpz-payments'),
						'selector' => "%%order_class%% .wpz-payments-notes-instructions, $this->modal_css_element .wpz-payments-notes-instructions",
					),
					'notification_error'       => array(
						'label'    => __('Error Message', 'wpz-payments'),
						'selector' => "%%order_class%% .wpz-payments-error, $this->modal_css_element .wpz-payments-error",
					),
					'notification_success'     => array(
						'label'    => __('Success Message', 'wpz-payments'),
						'selector' => "%%order_class%% .wpz-payments-success, $this->modal_css_element .wpz-payments-success",
					),
					'reload_message'     => array(
						'label'    => __('Reload Payment Message', 'wpz-payments'),
						'selector' => "%%order_class%% .wpz-payments-reload-info, $this->modal_css_element .wpz-payments-reload-info",
					),
				),
			),
		)
		);

		add_filter('et_pb_set_style_selector', [__CLASS__, 'fixModalSelectors']);
	}

	static function fixModalSelectors($selector) {
		return preg_replace('/[^,]*(\.wpz_payments_divi_module[^ ,]+_payments_container)/', '$1', $selector);
	}


	/**
	 * Module's specific fields
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	function get_fields() {

		$fields = array(
			'title'                       => array(
				'label'       => __('Product Name', 'wpz-payments'),
				'description' => esc_html__('Enter the name of your product or service. The name needs to be unique to avoid payment failures, as having two payment modules with the same product name on the page can lead to issues. The validation process uses the product name to determine which form the purchase was made from.', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'product',
				'default'     => esc_html__('Product Name', 'wpz-payments')
			),
			'content'                     => array(
				'label'       => __('Product Description', 'wpz-payments'),
				'description' => esc_html__('This will display below the title', 'wpz-payments'),
				'type'        => 'tiny_mce',
				'tab_slug'    => 'general',
				'toggle_slug' => 'product',
				'default'     => esc_html__('Product Description', 'wpz-payments')
			),
			'price_type'                  => array(
				'label'       => __('Price Type', 'wpz-payments'),
				'description' => esc_html__('Choose from fixed or custom price', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'fixed'  => esc_html__('Fixed Price', 'wpz-payments'),
					'custom' => esc_html__('Custom Price', 'wpz-payments'),
				),
				'default'     => 'fixed',
				'tab_slug'    => 'general',
				'toggle_slug' => 'price',
			),
			'minimum_price'               => array(
				'label'       => __('Minimum Price', 'wpz-payments'),
				'description' => esc_html__('Set the minimum price or donation amount', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'price',
				'show_if'     => [
					'price_type' => 'custom'
				]
			),
			'maximum_price'               => array(
				'label'       => __('Maximum Price', 'wpz-payments'),
				'description' => esc_html__('Set the maximum price or donation', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'price',
				'show_if'     => [
					'price_type' => 'custom'
				]
			),
			'price_step'                  => array(
				'label'          => __('Price Step', 'wpz-payments'),
				'description'    => esc_html__('Set the increments by which the custom price will increase/decrease by. No currency amounts with more than 2 decimal places are supported.', 'wpz-payments'),
				'type'           => 'range',
				'unitless'       => true,
				'range_settings' => array(
					'min' => '0.01',
					'max' => '1000'
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'price',
				'show_if'        => [
					'price_type' => 'custom'
				]
			),
			'price_default'               => array(
				'label'       => __('Default Price', 'wpz-payments'),
				'description' => esc_html__('Set the default price that will display. No currency amounts with more than 2 decimal places are supported.', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'price',
				// translators: default price amount
				'default'     => esc_html__('100', 'wpz-payments')
			),
			'price_label'                 => array(
				'label'       => __('Price Label', 'wpz-payments'),
				'description' => esc_html__('This field will display before the price', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'price',
				'default'     => esc_html__('Price:', 'wpz-payments'),
			),
			'validation_minimum_price'    => array(
				'label'       => __('Minimum Price - Validation Error Message', 'wpz-payments'),
				'description' => esc_html__('Error message that will display if minimum price is not met', 'wpz-payments'),
				'type'        => 'text',
				'default'     => esc_html__('Please enter a valid value. Value must be minimum %f.', 'wpz-payments'),
				'tab_slug'    => 'general',
				'toggle_slug' => 'price',
				'show_if'     => [
					'price_type' => 'custom'
				]
			),
			'validation_maximum_price'    => array(
				'label'       => __('Maximum Price - Validation Error Message', 'wpz-payments'),
				'description' => esc_html__('Error message that will display if maximum price is exceeded', 'wpz-payments'),
				'type'        => 'text',
				'default'     => esc_html__('Please enter a valid value. Value must be maximum %f.', 'wpz-payments'),
				'tab_slug'    => 'general',
				'toggle_slug' => 'price',
				'show_if'     => [
					'price_type' => 'custom'
				]
			),
			'validation_step_price'       => array(
				'label'       => __('Price Step - Validation Error Message', 'wpz-payments'),
				'description' => esc_html__('Error message that will display if number entered is outside the required increments', 'wpz-payments'),
				'type'        => 'text',
				'default'     => esc_html__('Please enter a valid value. Value must be a multiple of %f.', 'wpz-payments'),
				'tab_slug'    => 'general',
				'toggle_slug' => 'price',
				'show_if'     => [
					'price_type' => 'custom'
				]
			),
			'quantity'                    => array(
				'label'       => __('Enable Quantity', 'wpz-payments'),
				'description' => esc_html__('Enable/disable the quantity field', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => __('On', 'wpz-payments'),
					'off' => __('Off', 'wpz-payments'),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'quantity',
			),
			'display_mode'                => array(
				'label'       => _x('Show Payment Form', 'display mode dropdown label', 'wpz-payments'),
				'description' => esc_html__('Choose how and when to display the payment form', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'page'        => __('In page', 'wpz-payments'),
					'page_button' => __('In page after button click', 'wpz-payments'),
					'modal'       => __('In overlay after button click', 'wpz-payments'),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'display',
				'default'     => 'page'
			),
			'payment_type'                => array(
				'label'       => __('Payment Processor', 'wpz-payments'),
				'description' => esc_html__('Choose which payment processor to use to process payments from this module', 'wpz-payments'),
				'type'        => 'multiple_checkboxes',
				'options'     => array(
					'stripe' => __('Stripe', 'wpz-payments'),
					'paypal'  => __('PayPal', 'wpz-payments'),
				),
				'default'     => 'on|paypal',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
			),
			'stripe_theme'                => array(
				'label'       => __('Stripe Form Theme', 'wpz-payments'),
				'description' => esc_html__('This sets the look and feel of the payment form', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'stripe' => esc_html__('Stripe', 'wpz-payments'),
					'night'  => esc_html__('Night', 'wpz-payments'),
					'flat'   => esc_html__('Flat', 'wpz-payments'),
					'none'   => esc_html__('Custom', 'wpz-payments'),
				),
				'default'     => 'stripe',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
				'show_if' => [
					//'payment_type' => 'stripe'
				]
			),
			'button_text'                 => array(
				'label'       => __('Stripe Button Text', 'wpz-payments'),
				'description' => esc_html__('Text that appears within the Stripe payment button such as "pay or donate now"', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
				// translators: default pay button text
				'default'     => esc_html__('Pay %s', 'wpz-payments'),
				'show_if' => [
					//'payment_type' => 'stripe'
				]
			),
			'no_reload_on_success' => array(
				'label'       => __('Stripe - don\'t reload the payment form after successful payment', 'wpz-payments'),
				'description' => esc_html__('Enabling this option can help reduce the number of incomplete payments recorded in your Stripe account, because a new incomplete payment won\'t be automatically created as part of a payment form reload after a successful payment.', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __('Off', 'wpz-payments'),
					'on'  => __('On', 'wpz-payments'),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'success',
				'default'     => 'off',
				'show_if' => [
					//'payment_type' => 'stripe'
				]
			),
			'paypal_category'                => array(
				'label'       => __('PayPal Category', 'wpz-payments'),
				'description' => esc_html__('Choose the item category to send to PayPal', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'physical' => __('Physical Goods', 'wpz-payments'),
					'digital'  => __('Digital Goods', 'wpz-payments'),
					'donation'  => __('Donation', 'wpz-payments'),
				),
				'default'     => 'physical',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
				'show_if' => [
					//'payment_type' => 'paypal',
				]
			),
			'paypal_button_text' => [
				'label'       => __('PayPal Button Text', 'wpz-payments'),
				'description' => esc_html__('Select from some predefined text options to display on the PayPal button', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'none' => _x('No text (PayPal logo only)', 'paypal button labels', 'wpz-payments'),
					'checkout'  => _x('Checkout', 'paypal button labels', 'wpz-payments'),
					'buynow'   => _x('Buy Now', 'paypal button labels', 'wpz-payments'),
					'pay'   => _x('Pay with', 'paypal button labels', 'wpz-payments'),
				),
				'default'     => 'none',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
				'show_if' => [
					//'payment_type' => 'paypal',
				]
			],
			'paypal_button_layout' => [
				'label'       => __('PayPal Buttons Layout', 'wpz-payments'),
				'description' => esc_html__('Choose a layout preference to use when rendering PayPal buttons', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'vertical' => __('Vertical', 'wpz-payments'),
					'horizontal' => __('Horizontal', 'wpz-payments')
				),
				'default'     => 'vertical',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
				'show_if' => [
					//'payment_type' => 'paypal',
				]
			],
			'paypal_show_tagline'                    => array(
				'label'       => __('Show PayPal Tagline', 'wpz-payments'),
				'description' => esc_html__('Enable/disable the PayPal tagline below the button', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => __('On', 'wpz-payments'),
					'off' => __('Off', 'wpz-payments'),
				),
				'default' => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
				'show_if' => [
					//'payment_type' => 'paypal',
					'paypal_button_layout' => 'horizontal'
				]
			),
			'paypal_button_max_width' => [
				'label'       => __('Max Width', 'wpz-payments'),
				'type'             => 'range',
				'hover'            => 'tabs',
				'mobile_options'   => true,
				'validate_unit'    => true,
				'default_unit'     => '%',
				'allow_empty'      => true,
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'paypal_button',
				'range_settings'   => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
			],
			'paypal_button_height' => [
				'label'       => __('Height', 'wpz-payments'),
				'type'             => 'range',
				'hover'            => 'tabs',
				'mobile_options'   => true,
				'validate_unit'    => true,
				'default_unit'     => 'px',
				'allowed_units' => 'px',
				'allow_empty'      => true,
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'paypal_button',
				'range_settings'   => array(
					'min'  => 25,
					'max'  => 55,
					'step' => 1,
				),
			],
			'show_credit'                    => array(
				'label'       => __('Show Module Credit', 'wpz-payments'),
				'description' => esc_html__('Enable/disable the module credit footnote', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => __('On', 'wpz-payments'),
					'off' => __('Off', 'wpz-payments'),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
				'default' => WPZ_Payments::isFree() ? 'on' : 'off'
			),
			'statement_descriptor'        => array(
				'label'       => __('Statement Descriptor', 'wpz-payments'),
				'description' => esc_html__('Statement descriptors explain charges or payments on bank statements. The descriptor you enter here may be shortened, and for card-based payments the account descriptor may be added to the beginning. If you leave this field blank, an account default statement descriptor may be used instead.', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'payment',
				'default'     => ''
			),

			/*
			'stripe_checkout_language' => array(
				'label'       => __( 'Stripe Checkout Language', 'wpz-payments' ),
				'type'        => 'select',
				'options'     => array(
					//todo Jonathan
					'lang_1' => esc_html__( 'Lang 1', 'wpz-payments' ),
					'lang_2' => esc_html__( 'Lang 2', 'wpz-payments' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form',
			),
			*/
			/*
			'phone_field'              => array(
				'label'       => __( 'Display Phone Number Field', 'wpz-payments' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __( 'Off', 'wpz-payments' ),
					'on'  => __( 'On', 'wpz-payments' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
			),
			'billing_address_field'            => array(
				'label'       => __( 'Display Billing Address Fields', 'wpz-payments' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __( 'Off', 'wpz-payments' ),
					'on'  => __( 'On', 'wpz-payments' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
			),
			*/
			'notes_field'                 => array(
				'label'       => __('Display Notes Field', 'wpz-payments'),
				'description' => esc_html__('Enable/disable the customer notes field', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __('Off', 'wpz-payments'),
					'on'  => __('On', 'wpz-payments'),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
			),
			'notes_field_label'           => array(
				'label'       => __('Notes Field Label', 'wpz-payments'),
				'description' => esc_html__('Describe the purpose of your notes field', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
				'default'     => esc_html__('Notes:', 'wpz-payments'),
				'show_if'     => [
					'notes_field' => 'on'
				]
			),
			'notes_field_instructions'    => array(
				'label'       => __('Notes Field Instructions', 'wpz-payments'),
				'type'        => 'tiny_mce',
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
				'default'     => '',
				'show_if'     => [
					'notes_field' => 'on'
				]
			),
			'notes_field_required'        => array(
				'label'       => __('Notes Field Required?', 'wpz-payments'),
				'description' => esc_html__('Enable to make the notes field required', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __('Off', 'wpz-payments'),
					'on'  => __('On', 'wpz-payments'),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
				'show_if'     => [
					'notes_field' => 'on'
				]
			),
			/*
			'store_policies_field'     => array(
				'label'       => esc_html__( 'Display Store Policies', 'wpz-payments' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'Off', 'wpz-payments' ),
					'on'  => esc_html__( 'On', 'wpz-payments' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
			),
			*/
			'agreement_checkbox'          => array(
				'label'       => __('Display Agreement To Terms Checkbox', 'wpz-payments'),
				'description' => esc_html__('Display a Terms of Agreement checkbox', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __('Off', 'wpz-payments'),
					'on'  => __('On', 'wpz-payments'),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
			),
			'agreement_text'              => array(
				'label'       => __('Agreement To Terms Text', 'wpz-payments'),
				'description' => esc_html__('Enter your Terms of Agreement here', 'wpz-payments'),
				'type'        => 'tiny_mce',
				'default'     => esc_html__('I agree to the Terms and Conditions', 'wpz-payments'),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
				'show_if'     => array(
					'agreement_checkbox' => 'on'
				)
			),
			'validation_agreement'        => array(
				'label'       => __('Agreement To Terms - Validation Error Message', 'wpz-payments'),
				'description' => esc_html__('Error message that will display if the agreement to terms checkbox is not checked', 'wpz-payments'),
				'type'        => 'text',
				'default'     => esc_html__('You must agree to the terms in order to proceed.', 'wpz-payments'),
				'tab_slug'    => 'general',
				'toggle_slug' => 'form_fields',
				'show_if'     => [
					'agreement_checkbox' => 'on'
				]
			),

			'confirm_message'                     => array(
				'label'       => __('Confirmation Message', 'wpz-payments'),
				'description' => esc_html__('Enter the message that should display if the user needs to confirm payment. %s is the payment amount.', 'wpz-payments'),
				'type'        => 'textarea',
				'tab_slug'    => 'general',
				'toggle_slug' => 'confirm',
				'default'     => esc_html__('Do you want to submit payment for %s?', 'wpz-payments')
			),
			'confirm_yes'                     => array(
				'label'       => __('Yes Button Text', 'wpz-payments'),
				'description' => esc_html__('Enter the text for the "Yes" button if the user needs to confirm payment.', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'confirm',
				'default'     => esc_html__('Yes', 'wpz-payments')
			),
			'confirm_no'                     => array(
				'label'       => __('No Button Text', 'wpz-payments'),
				'description' => esc_html__('Enter the text for the "No" button if the user needs to confirm payment.', 'wpz-payments'),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'confirm',
				'default'     => esc_html__('No', 'wpz-payments')
			),
			
			'success_action'                      => array(
				'label'       => __('Success Action', 'wpz-payments'),
				'description' => esc_html__('Choose whether to display success text or redirect to a URL', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'redirect' => esc_html__('Redirect To A Page', 'wpz-payments'),
					'message'  => esc_html__('Display Success Message', 'wpz-payments'),
				),
				'default'     => 'message',
				'tab_slug'    => 'general',
				'toggle_slug' => 'success',
			),
			'success_url'                         => array(
				'label'           => __('Success Redirect URL', 'wpz-payments'),
				'description'     => esc_html__('Enter the URL customers should be directed to after payment', 'wpz-payments'),
				'type'            => 'text',
				'dynamic_content' => 'url',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'success',
				'show_if'         => array(
					'success_action' => 'redirect'
				),
				'default'         => ''
			),
			'success_message'                     => array(
				'label'       => __('Success Message', 'wpz-payments'),
				'description' => esc_html__('Enter the message that should display after payment', 'wpz-payments'),
				'type'        => 'textarea',
				'tab_slug'    => 'general',
				'toggle_slug' => 'success',
				'show_if'     => array(
					'success_action' => 'message'
				),
				'default'     => esc_html__('Your payment has been processed. Thank you!', 'wpz-payments')
			),
			'error_message'                       => array(
				'label'       => __('Error Message', 'wpz-payments'),
				'description' => esc_html__('Enter the message that should display in the event of an unsuccesful transaction', 'wpz-payments'),
				'type'        => 'textarea',
				'tab_slug'    => 'general',
				'toggle_slug' => 'error',
				'default'     => esc_html__('Unfortunately, something went wrong while we were processing your payment, and the payment may not have completed. The reason given was: %{error_reason}. If this issue persists, please contact us.', 'wpz-payments')
			),
			'load_error_message'                  => array(
				'label'       => __('Loading Error Message', 'wpz-payments'),
				'description' => esc_html__('Enter the message that should display if the payment form could not be loaded successfully. Note: A different message will be displayed to site users with the manage_options permission.', 'wpz-payments'),
				'type'        => 'textarea',
				'tab_slug'    => 'general',
				'toggle_slug' => 'load_error',
				'default'     => esc_html__('An error occurred while loading the payment form. If this issue persists, please contact us. If you are a site administrator, you may see more error information if you are logged in using an administrator account.', 'wpz-payments')
			),
			'reload_info_message'                  => array(
				'label'       => __('Reload Info Message', 'wpz-payments'),
				'description' => esc_html__('Enter the message that should display if the Stripe payment form had to be reloaded after the user made a change.', 'wpz-payments'),
				'type'        => 'textarea',
				'tab_slug'    => 'general',
				'toggle_slug' => 'reload_info',
				'default'     => esc_html__('The payment form had to be reloaded.', 'wpz-payments')
			),
			'preloader_style'                     => array(
				'label'       => __('Preloader Icon', 'wpz-payments'),
				'type'        => 'DSLayoutMultiselect_DSDPM',
				'options'     => array(
					'audio'            => array(
						'title'   => __('Audio', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('audio', true)
					),
					'ball_triangle'    => array(
						'title'   => __('Ball Triangle', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('ball_triangle', true)
					),
					'bars'             => array(
						'title'   => __('Bars', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('bars', true)
					),
					'grid'             => array(
						'title'   => __('Grid', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('grid', true)
					),
					'circles'          => array(
						'title'   => __('Circles', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('circles', true)
					),
					'hearts'           => array(
						'title'   => __('Hearts', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('hearts', true)
					),
					'oval'             => array(
						'title'   => __('Oval', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('oval', true)
					),
					'spinning_circles' => array(
						'title'   => __('Spinning Circles', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('spinning_circles', true)
					),
					'three_dots'       => array(
						'title'   => __('Three Dots', 'wpz-payments'),
						'iconSvg' => $this->getIconSvg('three_dots', true)
					),
				),
				'default'     => 'three_dots',
				'tab_slug'    => 'general',
				'toggle_slug' => 'preloader',
				'customClass' => 'col-small preloader-icons-field'
			),
			'preloader_text_enable'               => array(
				'label'       => __('Display Preloader Text', 'wpz-payments'),
				'description' => esc_html__('Display a preloader text.', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __('Off', 'wpz-payments'),
					'on'  => __('On', 'wpz-payments'),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'preloader',
			),
			'title_background'                    => array(
				'label'        => __('Background', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'title',
				'sub_toggle'   => 'background',
			),
			'title_padding'                       => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '|||||',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'title',
				'sub_toggle'      => 'spacing',
			),
			'title_margin'                        => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '|||||',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'title',
				'sub_toggle'      => 'spacing',
			),

			// Product Description
			'description_background'              => array(
				'label'        => __('Background', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'description',
				'sub_toggle'   => 'background',
			),
			'description_padding'                 => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '|||||',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'description',
				'sub_toggle'      => 'spacing',
			),
			'description_margin'                  => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '|||||',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'description',
				'sub_toggle'      => 'spacing',
			),


			// Field Error
			'fields_error_text_color'             => array(
				'label'                  => __('Form Fields Error Text Color', 'wpz-payments'),
				'type'                   => 'color-alpha',
				'custom_color'           => true,
				'hover'                  => 'tabs',
				'tab_slug'               => 'advanced',
				'toggle_slug'            => 'form_fields_error',
				'default_value_depends'  => array('stripe_theme'),
				'default_values_mapping' => array(
					'stripe' => '',
					'night'  => '',
					'flat'   => '',
					'none'   => '#FF0000',
				),
			),
			'fields_error_background_color'       => array(
				'label'        => __('Form Fields Error Background Color', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'hover'        => 'tabs',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'form_fields_error',
			),
			'fields_error_border_color'           => array(
				'label'                  => __('Form Fields Error Border Color', 'wpz-payments'),
				'type'                   => 'color-alpha',
				'custom_color'           => true,
				'hover'                  => 'tabs',
				'tab_slug'               => 'advanced',
				'toggle_slug'            => 'form_fields_error',
				'default_value_depends'  => array('stripe_theme'),
				'default_values_mapping' => array(
					'stripe' => '',
					'night'  => '',
					'flat'   => '',
					'none'   => '#FF0000',
				),
			),

			// Fields Validation
			'fields_validation_background'        => array(
				'label'        => __('Background', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'fields_validation',
				'sub_toggle'   => 'background',
			),
			'fields_validation_padding'           => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'fields_validation',
				'sub_toggle'      => 'spacing',
			),
			'fields_validation_margin'            => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'fields_validation',
				'sub_toggle'      => 'spacing',
			),

			// Label
			'labels_text_color'                   => array(
				'label'        => __('Labels Text Color', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'hover'        => 'tabs',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'labels',
			),
			'labels_error_text_color'             => array(
				'label'        => __('Labels Error Text Color', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'hover'        => 'tabs',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'labels',
			),
			'labels_padding'                      => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '|||||',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'labels',
			),
			'labels_margin'                       => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '|||||',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'labels',
			),

			// Price Label
			'price_label_text_color'              => array(
				'label'        => __('Price Label Text Color', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'hover'        => 'tabs',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'price_label',
			),
			'price_label_error_text_color'        => array(
				'label'        => __('Price Label Error Text Color', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'hover'        => 'tabs',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'price_label',
			),
			'price_label_padding'                 => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'price_label',
			),
			'price_label_margin'                  => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'price_label',
			),

			// Price
			'price_currency_offset'               => array(
				'label'          => __('Currency Offset', 'wpz-payments'),
				'type'           => 'range',
				'allowed_units'  => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'validate_unit'  => true,
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'price_custom_currency',
			),

			// Checkbox
			'checkbox_background_color'           => array(
				'label'                  => __('Background Color', 'wpz-payments'),
				'type'                   => 'color-alpha',
				'custom_color'           => true,
				'tab_slug'               => 'advanced',
				'toggle_slug'            => 'checkbox',
				'sub_toggle'             => 'checkbox',
				'default_value_depends'  => array('stripe_theme'),
				'default_values_mapping' => array(
					'stripe' => '',
					'night'  => '',
					'flat'   => '',
					'none'   => '#EEEEEE',
				),
			),
			'checkbox_checked_color'              => array(
				'label'                  => __('Checked Color', 'wpz-payments'),
				'type'                   => 'color-alpha',
				'custom_color'           => true,
				'tab_slug'               => 'advanced',
				'toggle_slug'            => 'checkbox',
				'sub_toggle'             => 'checkbox',
				'default_value_depends'  => array('stripe_theme'),
				'default_values_mapping' => array(
					'stripe' => '',
					'night'  => '',
					'flat'   => '',
					'none'   => "$this->accent_color",
				),
			),
			'checkbox_checked_background_color'   => array(
				'label'        => __('Checked Background Color', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'checkbox',
				'sub_toggle'   => 'checkbox',
			),
			'checkbox_list_item_color'            => array(
				'label'       => __('Checkbox Label Text Color', 'wpz-payments'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'checkbox',
				'sub_toggle'  => 'label',
			),
			'checkbox_checked_list_item_color'    => array(
				'label'       => __('Checkbox Checked Label Text Color', 'wpz-payments'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'checkbox',
				'sub_toggle'  => 'label',
			),

			// Notes Field Instruction
			'notes_field_instructions_background' => array(
				'label'        => __('Background', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'notes_field_instructions_design',
				'sub_toggle'   => 'background',
			),
			'notes_field_instructions_padding'    => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'notes_field_instructions_design',
				'sub_toggle'      => 'spacing',
			),
			'notes_field_instructions_margin'     => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'notes_field_instructions_design',
				'sub_toggle'      => 'spacing',
			),

			// Error Notification
			'notification_error_background'       => array(
				'label'        => __('Background', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'notification_error',
				'sub_toggle'   => 'background',
			),
			'notification_error_padding'          => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'notification_error',
				'sub_toggle'      => 'spacing',
			),
			'notification_error_margin'           => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'notification_error',
				'sub_toggle'      => 'spacing',
			),

			// Success Notification
			'notification_success_background'     => array(
				'label'        => __('Background', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'notification_success',
				'sub_toggle'   => 'background',
			),
			'notification_success_padding'        => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'notification_success',
				'sub_toggle'      => 'spacing',
			),
			'notification_success_margin'         => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'notification_success',
				'sub_toggle'      => 'spacing',
			),

			// Confirmation
			'confirmation_background'     => array(
				'label'        => __('Background', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'confirm',
				'sub_toggle'   => 'background',
			),
			'confirmation_padding'        => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'confirm',
				'sub_toggle'      => 'spacing',
			),
			'confirmation_margin'         => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'confirm',
				'sub_toggle'      => 'spacing',
			),

			// Reload Payment Message
			'reload_message_background'     => array(
				'label'        => __('Background', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'reload_message',
				'sub_toggle'   => 'background',
			),
			'reload_message_padding'        => array(
				'label'           => __('Padding', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'reload_message',
				'sub_toggle'      => 'spacing',
			),
			'reload_message_margin'         => array(
				'label'           => __('Margin', 'wpz-payments'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'reload_message',
				'sub_toggle'      => 'spacing',
			),

			// Buttons
			'pay_button_fullwidth'                => array(
				'label'       => __('Make Button Fullwidth', 'wpz-payments'),
				'description' => esc_html__('If enabled, the button will take 100% of the width of the module.', 'wpz-payments'),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __('Off', 'wpz-payments'),
					'on'  => __('On', 'wpz-payments'),
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'pay_button',
			),
			
			// PayPal Button
			'paypal_button_color'                => array(
				'label'       => __('Color', 'wpz-payments'),
				'description' => esc_html__('Select from some predefined color options for the PayPal button', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'gold' => esc_html__('Gold', 'wpz-payments'),
					'blue'  => esc_html__('Blue', 'wpz-payments'),
					'silver'   => esc_html__('Silver', 'wpz-payments'),
					'white'   => esc_html__('White', 'wpz-payments'),
					'black'   => esc_html__('Black', 'wpz-payments'),
				),
				'default'     => 'gold',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'paypal_button',
				'show_if' => [
					//'payment_type' => 'paypal',
				],
			),
			'paypal_button_border_radius'                => array(
				'label'       => __('Border Rounding', 'wpz-payments'),
				'description' => esc_html__('Select from some predefined border radius options for the PayPal buttons', 'wpz-payments'),
				'type'        => 'select',
				'options'     => array(
					'less' => esc_html__('Less', 'wpz-payments'),
					'more'  => esc_html__('More', 'wpz-payments'),
				),
				'default'     => 'less',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'paypal_button',
				'show_if' => [
					//'payment_type' => 'paypal',
				]
			),
			'paypal_button_align' => [
				'label'       => __('Alignment', 'wpz-payments'),
				'description' => esc_html__('Choose an alignment option for the PayPal buttons', 'wpz-payments'),
				'type'        => 'text_align',
				'responsive'  => true,
				'options'     => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'     => 'center',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'paypal_button',
				'show_if' => [
					//'payment_type' => 'paypal',
				]
			],
			
			// Preloader
			'preloader_icon_color'                => array(
				'label'        => __('Preloader Icon Color', 'wpz-payments'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#2EA3F2',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'preloader',
				'sub_toggle'   => 'icon',
			),
			'preloader_icon_size'                 => array(
				'label'          => __('Preloader Icon Size', 'wpz-payments'),
				'type'           => 'range',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '50px',
				'validate_unit'  => true,
				'allowed_units'  => array('em', 'rem', 'px', 'cm', 'mm', 'in'),
				'responsive'     => true,
				'mobile_options' => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'preloader',
				'sub_toggle'     => 'icon',
			),
			'preloader_text_offset'               => array(
				'label'          => __('Preloader Text Offset', 'wpz-payments'),
				'type'           => 'range',
				'allowed_units'  => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in'),
				'default'        => '20px',
				'validate_unit'  => true,
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'preloader',
				'sub_toggle'     => 'text',
			),
		);
		
		
		if (WPZ_Payments::isFree()) {
			
			$proSettings = [
				'display_mode' => ['page_button', 'modal'],
				'stripe_theme' => ['night', 'flat'],
				'quantity' => 'on',
				'show_credit' => 'off',
				'preloader_style' => [
					'audio',
					'ball_triangle',
					'bars',
					'grid',
					'circles',
					'hearts',
					'oval',
					'spinning_circles'
				],
				'preloader_text_enable' => 'on',
				'paypal_button_color' => ['blue', 'silver', 'white', 'black'],
				'paypal_button_border_radius' => 'more'
			];
			
			$proSettingsByToggle = [];
			foreach ($proSettings as $field => $values) {
				if (isset($fields[$field])) {
					if ($fields[$field]['options'] && $fields[$field]['type'] != 'yes_no_button') {
						array_walk(
							$fields[$field]['options'],
							function(&$optionLabel, $optionId) use ($values) {
								if (is_array($values) ? in_array($optionId, $values) : $optionId == $values) {
									if (is_array($optionLabel)) {
										$optionLabel['isPro'] = true;
									} else {
										$optionLabel = sprintf(
											// translators: add pro label to setting option
											__('%s [pro]', 'wpz-payments'),
											$optionLabel
										);
									}
								}
							}
						);
					}
					$toggleKey = $fields[$field]['tab_slug'].':'.$fields[$field]['toggle_slug'];
					if (!isset($proSettingsByToggle[ $toggleKey ])) {
						$proSettingsByToggle[ $toggleKey ] = [];
					}
					$proSettingsByToggle[ $toggleKey ][$field] = $values;
				}
			}
			
			$upgradeFields = [];
			foreach ($proSettingsByToggle as $key => $conditions) {
				list($tab, $toggle) = explode(':', $key);
				$upgradeFields['wpzupgrade_'.$toggle] = [
					'label' => '',
					'type' => 'WPZUpgradeNotice_DSDPM',
					'message' => __('This option is only available in Simple Payments Module for Divi Pro. Use promo code SIMPLEPAY10 at checkout when you upgrade for a 10% discount!', 'wpz-payments'),
					'conditions' => $conditions,
					'module_slug' => $this->slug,
					'toggle_slug' => $toggle,
					'tab_slug' => $tab,
					'upgrade_url' => WPZ_Payments::PRODUCT_URI.'?utm_source=plugin&utm_medium=referral&utm_campaign=upgrade_modal'
				];
			}
			
			$upgradeFields['wpzupgrade__multipaymentypes'] = [
					'label' => '',
					'type' => 'WPZUpgradeNotice_DSDPM',
					'message' => __('The free version of Simple Payments Module for Divi only supports one payment processor per module. If you would like to offer users a choice of payment processor within the same payment module, please upgrade to Simple Payments Module for Divi Pro. Use promo code SIMPLEPAY10 at checkout when you upgrade for a 10% discount!', 'wpz-payments'),
					'conditions' => ['payment_type' => 'on|on'],
					'module_slug' => $this->slug,
					'toggle_slug' => 'form',
					'upgrade_url' => WPZ_Payments::PRODUCT_URI.'?utm_source=plugin&utm_medium=referral&utm_campaign=upgrade_modal'
				];
			
			$fields = array_merge($upgradeFields, $fields);
			
		}
		
		

		return apply_filters('wpz_payments_divi_module_fields', $fields);
	}

	/**
	 * Module's advanced fields configuration
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	function get_advanced_fields_config() {
		return apply_filters('wpz_payments_divi_module_fields_advanced', array(
			'fonts'          => array(
				'text'                     => array(
					'label'               => __('Module Text', 'wpz-payments'),
					'css'                 => array(
						'main' => "$this->main_css_element, $this->modal_css_element",
						'font' => "$this->main_css_element, $this->modal_css_element, %%order_class%% #STRIPE .Label, %%order_class%% #STRIPE .Input, %%order_class%% #STRIPE .Error",
					),
					'hide_font_size'      => true,
					'hide_letter_spacing' => true,
					'hide_line_height'    => true,
					'hide_text_shadow'    => true,
					'toggle_slug'         => 'module_text'
				),
				'title'                    => array(
					'label'       => __('Product Name', 'wpz-payments'),
					'css'         => array(
						'main'       => "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title",
						'hover'      => "%%order_class%% .wpz-payments-title:hover, $this->modal_css_element .wpz-payments-title:hover",
						'text_align' => "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title",
					),
					'toggle_slug' => 'title',
					'sub_toggle'  => 'p',
				),
				'description'              => array(
					'label'       => __('Description', 'wpz-payments'),
					'css'         => array(
						'main' => "%%order_class%% .wpz-payments-description, $this->modal_css_element .wpz-payments-description",
					),
					'font_size'   => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'line_height' => array(
						'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
					),
					'toggle_slug' => 'description',
					'sub_toggle'  => 'p',
				),
				'labels'                   => array(
					'label'           => __('Label', 'wpz-payments'),
					'css'             => array(
						'main' => "%%order_class%% #STRIPE .Label, %%order_class%% .wpz-payments-label, $this->modal_css_element .wpz-payments-label",
					),
					'font_size'       => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'hide_text_color' => true,
					'toggle_slug'     => 'labels',
				),
				'price_custom_currency'    => array(
					'label'           => __('Currency Sign', 'wpz-payments'),
					'css'             => array(
						'main' => "%%order_class%% .wpz-payments-price .wpz-payments-price-currency, $this->modal_css_element .wpz-payments-price .wpz-payments-price-currency",
					),
					'hide_text_align' => true,
					'toggle_slug'     => 'price_custom_currency',
				),
				'price_label'              => array(
					'label'           => __('Price Label', 'wpz-payments'),
					'css'             => array(
						'main' => "%%order_class%% .wpz-payments-price .wpz-payments-label, $this->modal_css_element .wpz-payments-price .wpz-payments-label",
					),
					'hide_text_color' => true,
					'toggle_slug'     => 'price_label',
				),
				'price_fixed'              => array(
					'label'           => __('Price', 'wpz-payments'),
					'css'             => array(
						'main' => "%%order_class%% .wpz-payments-fixed-price-amount, $this->modal_css_element .wpz-payments-fixed-price-amount",
					),
					'font_size'       => array(
						'default' => '30px',
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'hide_text_align' => true,
					'toggle_slug'     => 'price_fixed',
				),
				'notes_field_instructions' => array(
					'label'       => __('Notes Field Instructions', 'wpz-payments'),
					'css'         => array(
						'main' => "%%order_class%% .wpz-payments-notes-instructions, $this->modal_css_element .wpz-payments-notes-instructions",
					),
					'font_size'   => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'line_height' => array(
						'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
					),
					'toggle_slug' => 'notes_field_instructions_design',
					'sub_toggle'  => 'p',
				),
				'notification_error'       => array(
					'label'       => __('Error Notification', 'wpz-payments'),
					'css'         => array(
						'main'      => "%%order_class%% .wpz-payments-error, $this->modal_css_element .wpz-payments-error",
						'important' => 'all'
					),
					'font_size'   => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'line_height' => array(
						'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
					),
					'toggle_slug' => 'notification_error',
					'sub_toggle'  => 'p',
				),
				'notification_success'     => array(
					'label'       => __('Confirmation Message', 'wpz-payments'),
					'css'         => array(
						'main'      => "%%order_class%% .wpz-payments-success, $this->modal_css_element .wpz-payments-success",
						'important' => 'all'
					),
					'font_size'   => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'line_height' => array(
						'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
					),
					'toggle_slug' => 'notification_success',
					'sub_toggle'  => 'p',
				),
				'confirm'     => array(
					'label'       => __('Payment Confirmation', 'wpz-payments'),
					'css'         => array(
						'main'      => "%%order_class%% .wpz-payments-confirm, $this->modal_css_element .wpz-payments-confirm",
//						'important' => 'all'
					),
					'font_size'   => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'line_height' => array(
						'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
					),
					'toggle_slug' => 'confirm',
					'sub_toggle'  => 'p',
				),
				'reload_message'     => array(
					'label'       => __('Reload Payment Message', 'wpz-payments'),
					'css'         => array(
						'main'      => "%%order_class%% .wpz-payments-reload-info, $this->modal_css_element .wpz-payments-reload-info",
//						'important' => 'all'
					),
					'font_size'   => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'line_height' => array(
						'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
					),
					'toggle_slug' => 'reload_message',
					'sub_toggle'  => 'p',
				),
				'checkbox'                 => array(
					'label'           => __('Checkbox', 'wpz-payments'),
					'hide_text_color' => true,
					'css'             => array(
						'main' => "%%order_class%% .wpz-payments-agreement label, $this->modal_css_element .wpz-payments-agreement label",
					),
					'hide_text_align' => true,
					'font_size'       => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'line_height'     => array(
						'default' => floatval(et_get_option('body_font_height', '1.7')) . 'em',
					),
					'toggle_slug'     => 'checkbox',
					'sub_toggle'      => 'label',
				),
				'fields_validation'        => array(
					'label'       => __('Fields Validation', 'wpz-payments'),
					'css'         => array(
						'main'      => "%%order_class%% .wpz-payments-validation-error, $this->modal_css_element .wpz-payments-validation-error",
						'important' => 'all'
					),
					'toggle_slug' => 'fields_validation',
					'sub_toggle'  => 'p',
				),
				'preloader_text'           => array(
					'label'           => __('Preloader Text', 'wpz-payments'),
					'css'             => array(
						'main'      => "$this->modal_css_element .wpz-payments-preloader .wpz-payments-preloader-text",
						'important' => 'all'
					),
					'hide_text_align' => true,
					'toggle_slug'     => 'preloader',
					'sub_toggle'      => 'text',
				),
			),
			'box_shadow'     => array(
				'default'                  => array(
					'css' => array(
						'main' => "$this->main_css_element, $this->modal_css_element .wpz-payment-modal-content",
					)
				),
				'title'                    => array(
					'label'       => __('Title Box Shadow', 'wpz-payments'),
					'css'         => array(
						'main'  => "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title",
						'hover' => "%%order_class%% .wpz-payments-title:hover, $this->modal_css_element .wpz-payments-title:hover",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'title',
					'sub_toggle'  => 'background',
				),
				'description'              => array(
					'label'       => __('Description', 'wpz-payments'),
					'css'         => array(
						'main'  => "%%order_class%% .wpz-payments-description, $this->modal_css_element .wpz-payments-description",
						'hover' => "%%order_class%% .wpz-payments-description:hover, $this->modal_css_element .wpz-payments-description:hover",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'description',
					'sub_toggle'  => 'background',
				),
				'notes_field_instructions' => array(
					'css'         => array(
						'main' => "%%order_class%% .wpz-payments-notes-instructions, $this->modal_css_element .wpz-payments-notes-instructions",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'notes_field_instructions_design',
					'sub_toggle'  => 'background',
				),
				'notification_error'       => array(
					'css'         => array(
						'main' => "%%order_class%% .wpz-payments-error, $this->modal_css_element .wpz-payments-error",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'notification_error',
					'sub_toggle'  => 'background',
				),
				'notification_success'     => array(
					'css'         => array(
						'main' => "%%order_class%% .wpz-payments-success, $this->modal_css_element .wpz-payments-success",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'notification_success',
					'sub_toggle'  => 'background',
				),
				'confirmation'     => array(
					'css'         => array(
						'main' => "%%order_class%% .wpz-payments-confirm, $this->modal_css_element .wpz-payments-confirm",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'confirm',
					'sub_toggle'  => 'background',
				),
				'reload_message'     => array(
					'css'         => array(
						'main' => "%%order_class%% .wpz-payments-reload-info, $this->modal_css_element .wpz-payments-reload-info",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'reload_message',
					'sub_toggle'  => 'background',
				),
				'fields_validation'        => array(
					'css'         => array(
						'main' => "%%order_class%% .wpz-payments-validation-error, $this->modal_css_element .wpz-payments-validation-error",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'fields_validation',
					'sub_toggle'  => 'background',
				),
			),
			'borders'        => array(
				'default'                  => array(
					'css'      => array(
						'main' => [
							'border_radii'  => "%%order_class%% .wpz-payments-container, $this->modal_css_element .wpz-payment-modal-content",
							'border_styles' => "%%order_class%% .wpz-payments-container, $this->modal_css_element .wpz-payment-modal-content"
						],
					),
					'defaults' => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
						'border_radii'  => 'on||||',
					),
				),
				'title'                    => array(
					'label'       => __('Title', 'wpz-payments'),
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title",
							'border_styles' => "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title",
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
						'border_radii'  => 'on||||',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'title',
					'sub_toggle'  => 'border',
				),
				'description'              => array(
					'label'       => __('Description', 'wpz-payments'),
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .wpz-payments-description, $this->modal_css_element .wpz-payments-description",
							'border_styles' => "%%order_class%% .wpz-payments-description, $this->modal_css_element .wpz-payments-description",
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
						'border_radii'  => 'on||||',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'description',
					'sub_toggle'  => 'border',
				),
				'notes_field_instructions' => array(
					'label'       => __('Notes Field Instructions', 'wpz-payments'),
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .wpz-payments-notes-instructions, $this->modal_css_element .wpz-payments-notes-instructions",
							'border_styles' => "%%order_class%% .wpz-payments-notes-instructions, $this->modal_css_element .wpz-payments-notes-instructions",
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#EE0000',
						),
						'border_radii'  => 'on||||',
					),
					'toggle_slug' => 'notes_field_instructions_design',
					'sub_toggle'  => 'border',
				),
				'notification_error'       => array(
					'label'       => __('Error Notification', 'wpz-payments'),
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .wpz-payments-error, $this->modal_css_element .wpz-payments-error",
							'border_styles' => "%%order_class%% .wpz-payments-error, $this->modal_css_element .wpz-payments-error",
							'important'     => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#EE0000',
						),
						'border_radii'  => 'on||||',
					),
					'toggle_slug' => 'notification_error',
					'sub_toggle'  => 'border',
				),
				'notification_success'     => array(
					'label'       => __('Success Notification', 'wpz-payments'),
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .wpz-payments-success, $this->modal_css_element .wpz-payments-success",
							'border_styles' => "%%order_class%% .wpz-payments-success, $this->modal_css_element .wpz-payments-success",
							'important'     => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#EE0000',
						),
						'border_radii'  => 'on||||',
					),
					'toggle_slug' => 'notification_success',
					'sub_toggle'  => 'border',
				),
				'confirm'     => array(
					'label'       => __('Payment Confirmation', 'wpz-payments'),
					'css'         => array(
						'main' => array(
							'border_radii'  => "$this->modal_css_element .wpz-payments-confirm",
							'border_styles' => "$this->modal_css_element .wpz-payments-confirm",
//							'important'     => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#EE0000',
						),
						'border_radii'  => 'on||||',
					),
					'toggle_slug' => 'confirm',
					'sub_toggle'  => 'border'
				),
				'reload_message'     => array(
					'label'       => __('Payment Confirmation', 'wpz-payments'),
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .wpz-payments-reload-info, $this->modal_css_element .wpz-payments-reload-info",
							'border_styles' => "%%order_class%% .wpz-payments-reload-info, $this->modal_css_element .wpz-payments-reload-info",
//							'important'     => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#EE0000',
						),
						'border_radii'  => 'on||||',
					),
					'toggle_slug' => 'reload_message',
					'sub_toggle'  => 'border'
				),
				'fields_validation'        => array(
					'label'       => __('Fields Validation', 'wpz-payments'),
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .wpz-payments-validation-error, $this->modal_css_element .wpz-payments-validation-error",
							'border_styles' => "%%order_class%% .wpz-payments-validation-error, $this->modal_css_element .wpz-payments-validation-error",
							'important'     => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#EE0000',
						),
						'border_radii'  => 'on||||',
					),
					'toggle_slug' => 'fields_validation',
					'sub_toggle'  => 'border',
				),
			),
			'background'     => array(
				'css' => array(
					'main'      => "$this->main_css_element, $this->modal_css_element .wpz-payment-modal-content",
					'important' => 'all',
				),
			),
			'button'         => array(
				'pay_button'          => array(
					'label'          => __('Pay Button', 'wpz-payments'),
					'css'            => array(
						'main'      => "%%order_class%%  .wpz-payments-button-wrapper button.wpz-payments-pay-button, {$this->modal_css_element}.wpz-payments-container  .wpz-payments-button-wrapper button.wpz-payments-pay-button",
						'alignment' => "%%order_class%% .wpz-payments-button-wrapper, $this->modal_css_element .wpz-payments-button-wrapper",
					),
					'box_shadow'     => array(
						'css' => array(
							'main' => "%%order_class%% .wpz-payments-button-wrapper button.wpz-payments-pay-button, $this->modal_css_element .wpz-payments-button-wrapper button.wpz-payments-pay-button",
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
					'use_alignment'  => true,
					'no_rel_attr'    => true,
					'toggle_slug'    => 'pay_button'
				),
				'confirm_yes'         => array(
					'label'          => __('Confirm Message - Yes Button', 'wpz-payments'),
					'css'            => array(
						'main'      => "%%order_class%% button.wpz-payments-pay-button.wpz-payments-confirm-yes, {$this->modal_css_element}.wpz-payments-container button.wpz-payments-pay-button.wpz-payments-confirm-yes",
						'alignment' => "%%order_class%% .wpz-payments-button-confirm-wrapper, $this->modal_css_element .wpz-payments-button-confirm-wrapper",
					),
					'box_shadow'     => array(
						'css' => array(
							'main' => "%%order_class%% button.wpz-payments-pay-button.wpz-payments-confirm-yes, $this->modal_css_element button.wpz-payments-pay-button.wpz-payments-confirm-yes",
						),
					),
					'margin_padding' => array(
						'css' => array(
//							'important' => 'all',
						),
					),
					'use_alignment'  => true,
					'no_rel_attr'    => true,
					'toggle_slug'    => 'confirm_buttons'
				),
				'confirm_no'          => array(
					'label'          => __('Confirm Message - No Button', 'wpz-payments'),
					'css'            => array(
						'main'      => "%%order_class%% button.wpz-payments-confirm-no, {$this->modal_css_element}.wpz-payments-container button.wpz-payments-confirm-no"
					),
					'box_shadow'     => array(
						'css' => array(
							'main' => "%%order_class%% button.wpz-payments-confirm-no, $this->modal_css_element button.wpz-payments-confirm-no",
						),
					),
					'margin_padding' => array(
						'css' => array(
//							'important' => 'all',
						),
					),
					'use_alignment'  => false,
					'no_rel_attr'    => true,
					'toggle_slug'    => 'confirm_buttons'
				),
			),
			'margin_padding' => array(
				'css' => array(
					'padding'   => "$this->main_css_element, $this->modal_css_element .wpz-payment-modal-content",
					'margin'    => "%%order_class%%, $this->modal_css_element .wpz-payment-modal-content",
					'important' => 'all',
				),
			),
			'form_field'     => array(
				'form_fields'  => array(
					'label'         => esc_html__('Fields', 'wpz-payments'),
					'css'           => array(
						'main'              => "%%order_class%% #STRIPE .Input, %%order_class%% .wpz-payments-container .wpz-payments-form-field, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field",
						'hover'             => "%%order_class%% #STRIPE .Input:hover, %%order_class%% .wpz-payments-container .wpz-payments-form-field:hover, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:hover",
						'focus'             => "%%order_class%% #STRIPE .Input:focus, %%order_class%% .wpz-payments-container .wpz-payments-form-field:focus, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:focus",
						'focus_hover'       => "%%order_class%% #STRIPE .Input:focus:hover, %%order_class%% .wpz-payments-container .wpz-payments-form-field:focus:hover, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:focus:hover",
						'placeholder'       => "%%order_class%% #STRIPE .Input::placeholder, %%order_class%% #STRIPE .Input::-webkit-input-placeholder, %%order_class%% #STRIPE .Input::-moz-placeholder, %%order_class%% #STRIPE .Input:-ms-input-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field::placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field::-webkit-input-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field::-moz-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field:-ms-input-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field::placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field::-webkit-input-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field::-moz-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:-ms-input-placeholder",
						'placeholder_focus' => "%%order_class%% #STRIPE .Input:focus::placeholder, %%order_class%% #STRIPE .Input:focus::-webkit-input-placeholder, %%order_class%% #STRIPE .Input:focus::-moz-placeholder, %%order_class%% #STRIPE .Input:focus:-ms-input-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field:focus::placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field:focus::-webkit-input-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field:focus::-moz-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field:focus:-ms-input-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:focus::-webkit-input-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:focus::-moz-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:focus:-ms-input-placeholder",
						'margin'            => "%%order_class%% #STRIPE .Input, %%order_class%% .wpz-payments-container .wpz-payments-form-field, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field",
						'padding'           => "%%order_class%% #STRIPE .Input, %%order_class%% .wpz-payments-container .wpz-payments-form-field, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field",
						'important'         => array(
							'background_color',
							'background_color_hover',
							'focus_background_color',
							'form_text_color',
							'form_text_color_hover',
							'text_color',
							'focus_text_color',
							'padding',
							'margin',
							'font_size',
						),
					),
					'font_field'    => array(
						'css'            => array(
							'main' => "%%order_class%% #STRIPE .Input, %%order_class%% #STRIPE .Input::placeholder, %%order_class%% .wpz-payments-container .wpz-payments-form-field, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field",
						),
						'line_height'    => array(
							'default' => '1em',
						),
						'font_size'      => array(
							'default' => '14px',
						),
						'letter_spacing' => array(
							'default' => '0px',
						),
					),
					'border_styles' => array(
						'form_fields'       => array(
							'label_prefix' => esc_html__('Fields', 'wpz-payments'),
							'css'          => array(
								'main' => array(
									'border_radii'  => "%%order_class%% #STRIPE .Input, %%order_class%% .wpz-payments-container .wpz-payments-form-field, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field",
									'border_styles' => "%%order_class%% #STRIPE .Input, %%order_class%% .wpz-payments-container .wpz-payments-form-field, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field",
								),
							),
							'defaults'     => array(
								'border_radii'  => 'on|0px|0px|0px|0px',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => '#EEE',
								),
							),
						),
						'form_fields_focus' => array(
							'label_prefix' => esc_html__('Fields Focus', 'wpz-payments'),
							'css'          => array(
								'main' => array(
									'border_radii'  => "%%order_class%% #STRIPE .Input:focus, %%order_class%% .wpz-payments-container .wpz-payments-form-field:focus, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:focus",
									'border_styles' => "%%order_class%% #STRIPE .Input:focus, %%order_class%% .wpz-payments-container .wpz-payments-form-field:focus, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field:focus"
								),
							),
							'defaults'     => array(
								'border_radii'  => 'on|0px|0px|0px|0px',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => '#EEE',
								),
							),
						),
					),
					'box_shadow'    => array(
						'css' => array(
							'main' => "%%order_class%% #STRIPE .Input, %%order_class%% .wpz-payments-container .wpz-payments-form-field, {$this->modal_css_element}.wpz-payments-container .wpz-payments-form-field",
						),
					),
					'toggle_slug'   => 'form_fields_design',
				),
				'price_custom' => array(
					'label'         => esc_html__('Custom Price Field', 'wpz-payments'),
					'css'           => array(
						'main'              => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount",
						'hover'             => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:hover, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:hover",
						'focus'             => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus",
						'focus_hover'       => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus:hover, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus:hover",
						'placeholder'       => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount::placeholder, %%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount::-webkit-input-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount::-moz-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:-ms-input-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount::placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount::-webkit-input-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount::-moz-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:-ms-input-placeholder",
						'placeholder_focus' => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus::placeholder, %%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus::-webkit-input-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus::-moz-placeholder, %%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus:-ms-input-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus::-webkit-input-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus::-moz-placeholder, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus:-ms-input-placeholder",
						'margin'            => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount",
						'padding'           => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount",
						'important'         => array(
							'background_color',
							'background_color_hover',
							'focus_background_color',
							'form_text_color',
							'form_text_color_hover',
							'text_color',
							'focus_text_color',
							'padding',
							'margin',
							'font_size',
						),
					),
					'font_field'    => array(
						'css' => array(
							'main' => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount",
						),
					),
					'border_styles' => array(
						'price_custom'       => array(
							'label_prefix' => esc_html__('Custom Price Field', 'wpz-payments'),
							'css'          => array(
								'main' => array(
									'border_radii'  => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount",
									'border_styles' => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount",
								),
							),
							'defaults'     => array(
								'border_radii'  => 'on|0px|0px|0px|0px',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => '#EEE',
								),
							),
						),
						'price_custom_focus' => array(
							'label_prefix' => esc_html__('Custom Price Field Focus', 'wpz-payments'),
							'css'          => array(
								'main' => array(
									'border_radii'  => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus",
									'border_styles' => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount:focus",
								),
							),
							'defaults'     => array(
								'border_radii'  => 'on|0px|0px|0px|0px',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => '#EEE',
								),
							),
						),
					),
					'box_shadow'    => array(
						'css' => array(
							'main' => "%%order_class%% .wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount, {$this->modal_css_element}.wpz-payments-container .wpz-payments-price-wrapper .wpz-payments-price-amount",
						),
					),
					'toggle_slug'   => 'price_custom_field',
				),
			),
			'max_width'      => array(
				'css' => array(
					'main'             => "$this->main_css_element, $this->modal_css_element .wpz-payment-modal-content",
					'module_alignment' => "$this->main_css_element, $this->modal_css_element .wpz-payment-modal-content",
				),
			),
			'height'         => array(
				'css' => array(
					'main' => "$this->main_css_element, $this->modal_css_element .wpz-payment-modal-content",
				),
			),
			'text_shadow'    => false,
			'link_options'   => false,
			'text'           => false,
			'sticky'         => false,
			'filters'        => false,
		), $this->main_css_element, $this->modal_css_element);
	}


	/**
	 *  Used to generate responsive module CSS
	 *  Custom margin is based on update_styles() function.
	 *  Divi/includes/builder/module/field/MarginPadding.php
	 *
	 */
	public function apply_responsive($value, $selector, $css, $render_slug, $type, $default = null, $important = false) {

		$dstc_last_edited       = $this->props[ $value . '_last_edited' ];
		$dstc_responsive_active = et_pb_get_responsive_status($dstc_last_edited);

		switch ( $type ) {
			case 'custom_margin':

				$all_values = $this->props;
				$responsive = ET_Builder_Module_Helper_ResponsiveOptions::instance();

				// Responsive.
				$is_responsive = $responsive->is_responsive_enabled($all_values, $value);

				$margin_desktop = $responsive->get_any_value($all_values, $value);
				$margin_tablet  = $is_responsive ? $responsive->get_any_value($all_values, "{$value}_tablet") : '';
				$margin_phone   = $is_responsive ? $responsive->get_any_value($all_values, "{$value}_phone") : '';

				$styles = array(
					'desktop' => '' !== $margin_desktop ? rtrim(et_builder_get_element_style_css($margin_desktop, $css, $important)) : '',
					'tablet'  => '' !== $margin_tablet ? rtrim(et_builder_get_element_style_css($margin_tablet, $css, $important)) : '',
					'phone'   => '' !== $margin_phone ? rtrim(et_builder_get_element_style_css($margin_phone, $css, $important)) : '',
				);

				$responsive->declare_responsive_css($styles, $selector, $render_slug, $important);

				break;
			case 'alignment':
				$align        = esc_html($this->get_alignment());
				$align_tablet = esc_html($this->get_alignment('tablet'));
				$align_phone  = esc_html($this->get_alignment('phone'));

				// Responsive Image Alignment.
				// Set CSS properties and values for the image alignment.
				// 1. Text Align is necessary, just set it from current image alignment value.
				// 2. Margin {Side} is optional. Used to pull the image to right/left side.
				// 3. Margin Left and Right are optional. Used by Center to reset custom margin of point 2.
				$dstc_array = array(
					'desktop' => array(
						'text-align'    => $align,
						'margin-left'   => 'left' !== $align ? 'auto' : '',
						'margin-right'  => 'left' !== $align ? 'auto' : '',
						"margin-$align" => ! empty($align) && 'center' !== $align ? '0' : '',
					),
				);

				if ( ! empty($align_tablet) ) {
					$dstc_array['tablet'] = array(
						'text-align'           => $align_tablet,
						'margin-left'          => 'left' !== $align_tablet ? 'auto' : '',
						'margin-right'         => 'left' !== $align_tablet ? 'auto' : '',
						"margin-$align_tablet" => ! empty($align_tablet) && 'center' !== $align_tablet ? '0' : '',
					);
				}

				if ( ! empty($align_phone) ) {
					$dstc_array['phone'] = array(
						'text-align'          => $align_phone,
						'margin-left'         => 'left' !== $align_phone ? 'auto' : '',
						'margin-right'        => 'left' !== $align_phone ? 'auto' : '',
						"margin-$align_phone" => ! empty($align_phone) && 'center' !== $align_phone ? '0' : '',
					);
				}
				et_pb_responsive_options()->generate_responsive_css($dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type);
				break;

			default:
				$re          = array('|', 'true', 'false');
				$dstc        = trim(str_replace($re, ' ', $this->props[ $value ]));
				$dstc_tablet = trim(str_replace($re, ' ', $this->props[ $value . '_tablet' ]));
				$dstc_phone  = trim(str_replace($re, ' ', $this->props[ $value . '_phone' ]));

				$dstc_array = array(
					'desktop' => esc_html($dstc),
					'tablet'  => $dstc_responsive_active ? esc_html($dstc_tablet) : '',
					'phone'   => $dstc_responsive_active ? esc_html($dstc_phone) : '',
				);
				et_pb_responsive_options()->generate_responsive_css($dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type);
		}

	}


	/**
	 * @since
	 */
	private function css($render_slug) {

		$props     = $this->props;
		$css_props = [];

		// -----------------------------------------------------
		// Responsive CSS
		// -----------------------------------------------------

		// Title
		$this->apply_responsive('title_padding', "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('title_margin', "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title", 'margin', $render_slug, 'custom_margin');

		// Description
		$this->apply_responsive('description_padding', "%%order_class%% .wpz-payments-description, $this->modal_css_element .wpz-payments-description", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('description_margin', "%%order_class%% .wpz-payments-description, $this->modal_css_element .wpz-payments-description", 'margin', $render_slug, 'custom_margin');

		// Label
		$this->apply_responsive('labels_padding', "%%order_class%% .wpz-payments-label, $this->modal_css_element .wpz-payments-label, %%order_class%% #STRIPE .Label", 'padding', $render_slug, 'custom_margin', '', true);
		$this->apply_responsive('labels_margin', "%%order_class%% .wpz-payments-label, $this->modal_css_element .wpz-payments-label, %%order_class%% #STRIPE .Label", 'margin', $render_slug, 'custom_margin', '', true);

		// Price Label
		$this->apply_responsive('price_label_padding', "%%order_class%% .wpz-payments-price .wpz-payments-label, $this->modal_css_element .wpz-payments-price .wpz-payments-label", 'padding', $render_slug, 'custom_margin', '', true);
		$this->apply_responsive('price_label_margin', "%%order_class%% .wpz-payments-price .wpz-payments-label, $this->modal_css_element .wpz-payments-price .wpz-payments-label", 'margin', $render_slug, 'custom_margin', '', true);

		// Price
		$this->apply_responsive('price_currency_offset', "%%order_class%% .wpz-payments-price-wrapper .wpz-payments-price-currency-before, %%order_class%% .wpz-payments-price-wrapper .wpz-payments-price-currency-before_space, $this->modal_css_element .wpz-payments-price-wrapper .wpz-payments-price-currency-before, $this->modal_css_element .wpz-payments-price-wrapper .wpz-payments-price-currency-before_space", 'margin-right', $render_slug, 'default', '', true);
		$this->apply_responsive('price_currency_offset', "%%order_class%% .wpz-payments-price-wrapper .wpz-payments-price-currency-after, %%order_class%% .wpz-payments-price-wrapper .wpz-payments-price-currency-after_space, $this->modal_css_element .wpz-payments-price-wrapper .wpz-payments-price-currency-after, $this->modal_css_element .wpz-payments-price-wrapper .wpz-payments-price-currency-after_space", 'margin-left', $render_slug, 'default', '', true);

		// Notes Field Instruction
		$this->apply_responsive('notes_field_instructions_padding', "%%order_class%% .wpz-payments-notes-instructions, $this->modal_css_element .wpz-payments-notes-instructions", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('notes_field_instructions_margin', "%%order_class%% .wpz-payments-notes-instructions, $this->modal_css_element .wpz-payments-notes-instructions", 'margin', $render_slug, 'custom_margin');

		// Error Notification
		$this->apply_responsive('notification_error_padding', "%%order_class%% .wpz-payments-error, $this->modal_css_element .wpz-payments-error", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('notification_error_margin', "%%order_class%% .wpz-payments-error, $this->modal_css_element .wpz-payments-error", 'margin', $render_slug, 'custom_margin');

		// Success Notification
		$this->apply_responsive('notification_success_padding', "%%order_class%% .wpz-payments-success, $this->modal_css_element .wpz-payments-success", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('notification_success_margin', "%%order_class%% .wpz-payments-success, $this->modal_css_element .wpz-payments-success", 'margin', $render_slug, 'custom_margin');

		// Confirmation
		$this->apply_responsive('confirmation_padding', "%%order_class%% .wpz-payments-confirm, $this->modal_css_element .wpz-payments-success", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('confirmation_margin', "%%order_class%% .wpz-payments-confirm, $this->modal_css_element .wpz-payments-success", 'margin', $render_slug, 'custom_margin');

		// Reload
		$this->apply_responsive('reload_message_padding', "%%order_class%% .wpz-payments-reload-info, $this->modal_css_element .wpz-payments-reload-info", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('reload_message_margin', "%%order_class%% .wpz-payments-reload-info, $this->modal_css_element .wpz-payments-reload-info", 'margin', $render_slug, 'custom_margin');

		// Fields Validation
		$this->apply_responsive('fields_validation_padding', "%%order_class%% .wpz-payments-validation-error, $this->modal_css_element .wpz-payments-validation-error", 'padding', $render_slug, 'custom_margin', '', true);
		$this->apply_responsive('fields_validation_margin', "%%order_class%% .wpz-payments-validation-error, $this->modal_css_element .wpz-payments-validation-error", 'margin', $render_slug, 'custom_margin', '', true);

		// Preloader Icon
		$this->apply_responsive('preloader_icon_size', "$this->modal_css_element .wpz-payments-preloader .wpz-payments-preloader-icon .wpz_payments_spinner", 'width', $render_slug, 'default');
		$this->apply_responsive('preloader_text_offset', "$this->modal_css_element .wpz-payments-preloader .wpz-payments-preloader-icon + .wpz-payments-preloader-text", 'margin-top', $render_slug, 'default');
		
		
        $this->apply_responsive('paypal_button_max_width', '%%order_class%% .wpz-payments-paypal-button', 'max-width', $render_slug, 'default');
        $this->apply_responsive('paypal_button_align', '%%order_class%% .wpz-payments-paypal .wpz-payments-button-wrapper', 'text-align', $render_slug, 'default');
		

		// -----------------------------------------------------
		// CSS
		// -----------------------------------------------------

		// Title
		if ( '' !== $props['title_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-title, $this->modal_css_element .wpz-payments-title",
					'declaration' => sprintf('background:%s;', esc_attr($props['title_background'])),
				)
			);
		}

		// Description
		if ( '' !== $props['description_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-description, $this->modal_css_element .wpz-payments-description",
					'declaration' => sprintf('background:%s;', esc_attr($props['description_background'])),
				)
			);
		}

		// Notes Field Instruction
		if ( '' !== $props['notes_field_instructions_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-notes-instructions, $this->modal_css_element .wpz-payments-notes-instructions",
					'declaration' => sprintf('background:%s;', esc_attr($props['notes_field_instructions_background'])),
				)
			);
		}

		// Error Notification
		if ( '' !== $props['notification_error_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-error, $this->modal_css_element .wpz-payments-error",
					'declaration' => sprintf('background:%s;', esc_attr($props['notification_error_background'])),
				)
			);
		}

		// Success Notification
		if ( '' !== $props['notification_success_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-success, $this->modal_css_element .wpz-payments-success",
					'declaration' => sprintf('background:%s;', esc_attr($props['notification_success_background'])),
				)
			);
		}

		// Confirmation
		if ( '' !== $props['confirmation_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-confirm, $this->modal_css_element .wpz-payments-confirm",
					'declaration' => sprintf('background:%s;', esc_attr($props['confirmation_background'])),
				)
			);
		}
		// Confirmation
		if ( '' !== $props['reload_message_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-reload-info, $this->modal_css_element .wpz-payments-reload-info",
					'declaration' => sprintf('background:%s;', esc_attr($props['reload_message_background'])),
				)
			);
		}

		if ( 'on' === $props['pay_button_fullwidth'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-button-wrapper button.wpz-payments-pay-button, $this->modal_css_element .wpz-payments-button-wrapper button.wpz-payments-pay-button",
					'declaration' => 'width: 100%;',
				)
			);
		}

		// Fields Error
		if ( '' !== $props['fields_error_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% label.wpz-field-invalid .wpz-payments-form-field, $this->modal_css_element label.wpz-field-invalid .wpz-payments-form-field",
					'declaration' => sprintf('color:%s !important;', esc_attr($props['fields_error_text_color'])),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% #STRIPE .Input--invalid',
					'declaration' => sprintf('color:%s !important;', esc_attr($props['fields_error_text_color'])),
				)
			);
		}
		if ( '' !== $props['fields_error_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% label.wpz-field-invalid .wpz-payments-form-field, $this->modal_css_element label.wpz-field-invalid .wpz-payments-form-field",
					'declaration' => sprintf('background:%s !important;', esc_attr($props['fields_error_background_color'])),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% #STRIPE .Input--invalid',
					'declaration' => sprintf('background:%s !important;', esc_attr($props['fields_error_background_color'])),
				)
			);
		}
		if ( '' !== $props['fields_error_border_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% label.wpz-field-invalid .wpz-payments-form-field, $this->modal_css_element label.wpz-field-invalid .wpz-payments-form-field",
					'declaration' => sprintf('border-color:%s !important;', esc_attr($props['fields_error_border_color'])),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% #STRIPE .Input--invalid',
					'declaration' => sprintf('border-color:%s !important;', esc_attr($props['fields_error_border_color'])),
				)
			);
		}

		// Fields Validation
		if ( '' !== $props['fields_validation_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-validation-error, $this->modal_css_element .wpz-payments-validation-error",
					'declaration' => sprintf('background:%s;', esc_attr($props['fields_validation_background'])),
				)
			);
		}

		// Label
		if ( '' !== $props['labels_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-label, $this->modal_css_element .wpz-payments-label",
					'declaration' => sprintf('color:%s;', esc_attr($props['labels_text_color'])),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% #STRIPE .Label',
					'declaration' => sprintf('color:%s;', esc_attr($props['labels_text_color'])),
				)
			);
		}
		if ( '' !== $props['labels_error_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% label.wpz-field-invalid .wpz-payments-label, $this->modal_css_element label.wpz-field-invalid .wpz-payments-label",
					'declaration' => sprintf('color:%s;', esc_attr($props['labels_error_text_color'])),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% #STRIPE .Label--invalid',
					'declaration' => sprintf('color:%s;', esc_attr($props['labels_error_text_color'])),
				)
			);
		}

		// Price Label
		if ( '' !== $props['price_label_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-price .wpz-payments-label, $this->modal_css_element .wpz-payments-price .wpz-payments-label",
					'declaration' => sprintf('color:%s;', esc_attr($props['price_label_text_color'])),
				)
			);
		}
		if ( '' !== $props['price_label_error_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-price label.wpz-field-invalid .wpz-payments-label, $this->modal_css_element .wpz-payments-price  label.wpz-field-invalid .wpz-payments-label",
					'declaration' => sprintf('color:%s;', esc_attr($props['price_label_error_text_color'])),
				)
			);
		}

		// Checkboxes
		if ( '' !== $props['checkbox_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-agreement .checkbox-StyledInput, $this->modal_css_element .wpz-payments-agreement .checkbox-StyledInput",
					'declaration' => sprintf('background-color:%s !important;', esc_attr($props['checkbox_background_color'])),
				)
			);
		}

		if ( '' !== $props['checkbox_checked_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput, $this->modal_css_element .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput",
					'declaration' => sprintf('background-color:%s !important;', esc_attr($props['checkbox_checked_background_color'])),
				)
			);
		}

		$checkedColor = $props['checkbox_checked_color'];
		if ( '' !== $checkedColor ) {
			if ( 'none' === $props['stripe_theme'] ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => "%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before, $this->modal_css_element .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before",
						'declaration' => sprintf('color :%s !important;', esc_attr($checkedColor)),
					)
				);
			} else {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => "%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before, $this->modal_css_element .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before",
						'declaration' => sprintf('border-bottom-color :%s; border-right-color :%s;', esc_attr($checkedColor), esc_attr($checkedColor)),
					)
				);
			}
		}

		// Checkbox label text color
		$this->generate_styles(
			array(
				'base_attr_name' => 'checkbox_list_item_color',
				'selector'       => "%%order_class%% .wpz-payments-agreement label, $this->modal_css_element .wpz-payments-agreement label",
				'hover_selector' => "%%order_class%% .wpz-payments-agreement label:hover, $this->modal_css_element .wpz-payments-agreement label:hover",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);
		$this->generate_styles(
			array(
				'base_attr_name' => 'checkbox_checked_list_item_color',
				'selector'       => "%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ label, $this->modal_css_element .wpz-payments-agreement input[type=checkbox]:checked ~ label",
				'hover_selector' => "%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ label:hover, $this->modal_css_element .wpz-payments-agreement input[type=checkbox]:checked ~ label:hover",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Preloader Icon
		$preloaderIconColor = '#2EA3F2';

		if ( '' !== $props['preloader_icon_color'] ) {
			$preloaderIconColor = $props['preloader_icon_color'];
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => "$this->modal_css_element .wpz_payments_spinner.spinner_stroke",
				'declaration' => sprintf('stroke:%s;', esc_attr($preloaderIconColor)),
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => "$this->modal_css_element .wpz_payments_spinner.spinner_fill",
				'declaration' => sprintf('fill:%s;', esc_attr($preloaderIconColor)),
			)
		);

		if ( 'spinning_circles' !== $props['preloader_style'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$this->modal_css_element .wpz_payments_spinner.spinner_spinning_circles",
					'declaration' => sprintf('stroke:%s;', esc_attr($preloaderIconColor)),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$this->modal_css_element .wpz_payments_spinner.spinner_spinning_circles circle",
					'declaration' => sprintf('fill:%s;', esc_attr($preloaderIconColor)),
				)
			);
		}

		// Fix overriden fields radius
		if ( (empty($this->props['border_radii_form_fields']) || substr($this->props['border_radii_form_fields'], - 15) == '0px|0px|0px|0px') && ('stripe' === $props['stripe_theme'] || 'night' === $props['stripe_theme']) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% #STRIPE .Input, %%order_class%% .wpz-payments-container .wpz-payments-form-field, $this->modal_css_element .wpz-payments-form-field",
					'declaration' => 'border-radius: 5px;',
				)
			);
		}

		// Pay Button Icon
		$pay_button_use_icon = ! empty($this->props['pay_button_use_icon']) ? $this->props['pay_button_use_icon'] : 'off';

		if ( $pay_button_use_icon === 'on' && ! empty($this->props['pay_button_icon']) ) {
			$icon     = DS_Divi_Payment_decoded_et_icon(et_pb_process_font_icon($this->props['pay_button_icon']));
			$position = $this->props['pay_button_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style($this->slug, array(
				'selector'    => "%%order_class%% .wpz-payments-button-wrapper button.wpz-payments-pay-button:not(.ds-dpm-loading)::{$position}, $this->modal_css_element .wpz-payments-button-wrapper button.wpz-payments-pay-button:not(.ds-dpm-loading)::{$position}",
				'declaration' => "content: '{$icon}'!important; font-family: 'ETmodules';"
			));
		}

		// Confirmation No Button Icon
		$confirm_no_use_icon = ! empty($this->props['confirm_no_use_icon']) && ! empty($this->props['custom_confirm_no']) && $this->props['custom_confirm_no'] === 'on' ? $this->props['confirm_no_use_icon'] : 'off';

		if ( $confirm_no_use_icon === 'on' && ! empty($this->props['confirm_no_icon']) ) {
			$icon     = DS_Divi_Payment_decoded_et_icon(et_pb_process_font_icon($this->props['confirm_no_icon']));
			$position = $this->props['confirm_no_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style($this->slug, array(
				'selector'    => "%%order_class%% button.wpz-payments-confirm-no::{$position}, $this->modal_css_element button.wpz-payments-confirm-no::{$position}",
				'declaration' => "content: '{$icon}'!important; font-family: 'ETmodules';"
			));
		}

		// Confirmation Yes Button Icon
		$confirm_yes_use_icon = ! empty($this->props['confirm_yes_use_icon']) && ! empty($this->props['custom_confirm_yes']) && $this->props['custom_confirm_yes'] === 'on' ? $this->props['confirm_yes_use_icon'] : 'off';


		if ( $confirm_yes_use_icon === 'on' && ! empty($this->props['confirm_yes_icon']) ) {
			$icon     = DS_Divi_Payment_decoded_et_icon(et_pb_process_font_icon($this->props['confirm_yes_icon']));
			$position = $this->props['confirm_yes_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style($this->slug, array(
				'selector'    => "%%order_class%% button.wpz-payments-pay-button.wpz-payments-confirm-yes::{$position}, $this->modal_css_element button.wpz-payments-pay-button.wpz-payments-confirm-yes::{$position}",
				'declaration' => "content: '{$icon}'!important; font-family: 'ETmodules';"
			));
		}

		foreach ( $css_props as $css_prop ) {
			ET_Builder_Element::set_style($render_slug, $css_prop);
		}
		
		do_action('wpz_payments_divi_module_css', $this, $render_slug, $this->main_css_element, $this->modal_css_element, $props);
	}


	/**
	 * Intended to be overridden as needed.
	 *
	 * @param array $fields Module fields.
	 *
	 * @return mixed|void
	 */
	public function process_fields($fields) {
		return $fields;
	}


	/**
	 * Render module output
	 *
	 * @param array $attrs List of unprocessed attributes
	 * @param string $content Content being processed
	 * @param string $render_slug Slug of module that is used for rendering output
	 *
	 * @return string module's rendered output
	 * @since 1.0.0
	 *
	 */
	function render($attrs, $content = null, $render_slug = null) {
		if ( is_array(WPZ_Payments::$modulePaymentParams) ) {
			$isFixedPrice                                                               = ($this->props['price_type'] != 'custom');
			WPZ_Payments::$modulePaymentParams[ trim($this->props['title']) ] = apply_filters('wpz_payments_divi_module_payment_params', [
				'priceMin'     => (float) $this->props[ $isFixedPrice ? 'price_default' : 'minimum_price' ],
				'priceMax'     => (float) $this->props[ $isFixedPrice ? 'price_default' : 'maximum_price' ],
				'priceStep'    => $isFixedPrice ? 0 : (float) $this->props['price_step'],
				'quantityMin'  => 1,
				'quantityMax'  => 1,
				'quantityStep' => 1
			], $this->props);

			return '';
		}


		$this->css($render_slug);
		
		$isFree = WPZ_Payments::isFree();
		$paymentTypes = explode('|', $this->props['payment_type']);
		
		$stripeEnabled = isset($paymentTypes[0]) && $paymentTypes[0] == 'on';
		$paypalEnabled = isset($paymentTypes[1]) && $paymentTypes[1] == 'on' && (!$isFree || !$stripeEnabled);
		
		if (!$paypalEnabled && !$stripeEnabled) {
			ob_start();
			echo('<p class="wpz-payments-none-enabled">'.esc_html__('Error: No payment methods have been enabled', 'wpz-payments').'</p>');
			return ob_get_clean();
		}


		$dataAttrs = [
			['data-payment-nonce', wp_create_nonce('wpz_payments_payment')]
		];
		
		
		if ($paypalEnabled) {
			$dataAttrs[] = ['data-paypal-category', $this->props['paypal_category'] ? $this->props['paypal_category'] : 'physical'];
			
			if ($this->props['paypal_button_text'] && $this->props['paypal_button_text'] !== 'none') {
				$dataAttrs[] = ['data-paypal-button-text', $this->props['paypal_button_text']];
			}
			
			if ($this->props['paypal_button_layout'] == 'horizontal') {
				$dataAttrs[] = ['data-paypal-buttons-horizontal', 1];
				if ($this->props['paypal_show_tagline'] == 'on') {
					$dataAttrs[] = ['data-paypal-show-tagline', 1];
				}
			}
			
			if ($this->props['paypal_button_height']) {
				$dataAttrs[] = ['data-paypal-button-height', (int) $this->props['paypal_button_height']];
			}
		}
		
		if ($stripeEnabled) {

			if ( $this->props['stripe_theme'] ) {
				$dataAttrs[] = ['data-stripe-theme', $this->props['stripe_theme']];
			}
			
		}


		if ( $this->props['statement_descriptor'] ) {
			$dataAttrs[] = ['data-statement-descriptor', $this->props['statement_descriptor']];
		}
		
		
		if ( $this->props['no_reload_on_success'] == 'on' ) {
			$dataAttrs[] = ['data-no-reload-on-success', 1];
		}


		/*
		if ($this->props['phone_field'] == 'on') {
			$dataAttrs[] = ['data-phone-field', 1];
		}
		
		if ($this->props['billing_address_field'] == 'on') {
			$dataAttrs[] = ['data-billing-address-field', 1];
		}
		*/

		$moduleOrderClass = $this->get_module_order_class($this->slug);

		$settings = array_merge(WPZ_Payments::DEFAULT_SETTINGS, get_option('wpz_payments_settings', []));

		$styleStr = '';
		$stylePre = '.' . $moduleOrderClass . ' #STRIPE';
		foreach ( [ET_Builder_Element::get_style_array(false), ET_Builder_Element::get_style_array(true)] as $styleArray ) {
			foreach ( $styleArray as $mq => $mqStyles ) {
				$mqStylesFiltered = [];
				foreach ( $mqStyles as $selector => $styleSpec ) {
					if ( strpos($selector, $stylePre) !== false ) {
						$mqStylesFiltered[ $selector ] = $styleSpec;
					}
				}

				if ( $mqStylesFiltered ) {
					uasort($mqStylesFiltered, ['ET_Builder_Element', 'compare_by_priority']);
					if ( $mq != 'general' ) {
						$styleStr .= $mq . '{';
					}
					foreach ( $mqStylesFiltered as $selector => $styleSpec ) {
						$styleStr .= $selector . '{' . $styleSpec['declaration'] . '}';
					}
					if ( $mq != 'general' ) {
						$styleStr .= '}';
					}
				}
			}
		}

		if ( $styleStr ) {
			$dataAttrs[] = ['data-stripe-styles', $styleStr];
		}

		if ( $this->props['success_action'] == 'redirect' ) {
			$dataAttrs[] = ['data-success-url', $this->props['success_url']];
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not a CSRF risk because there are no persistent changes
			if ( isset($_GET['wpz_payments_success']) && (int) $_GET['wpz_payments_success'] == self::_get_index(array(self::INDEX_MODULE_ORDER, $this->slug)) + 1 ) {
				$dataAttrs[] = ['data-success', 1];
			}
		} else {
			$dataAttrs[] = ['data-success-message', $this->props['success_message']];
		}

		$dataAttrs[] = ['data-error-message', $this->props['error_message']];
		$dataAttrs[] = ['data-load-error-message', $this->props['load_error_message']];
		
		if ($stripeEnabled) {
			$dataAttrs[] = ['data-reload-info-message', $this->props['reload_info_message']];
		}
		
		$dataAttrs[] = ['data-confirm-message', $this->props['confirm_message']];
		$dataAttrs[] = ['data-confirm-yes', $this->props['confirm_yes']];
		$dataAttrs[] = ['data-confirm-no', $this->props['confirm_no']];

		ob_start();
		
		do_action('wpz_payments_before_container', $this->props);
		?>
        <div class="wpz-payments-container wpz-payments-loading wpz-payments-<?php echo($stripeEnabled ? 'stripe' : 'paypal'); ?> wpz-payments-display-<?php echo(esc_attr($this->props['display_mode'])); ?> <?php echo(esc_attr($moduleOrderClass)); ?>_payments_container" <?php echo(et_core_esc_previously(implode(' ', array_map(function($attr) { return et_core_intentionally_unescaped($attr[0], 'fixed_string') . '="' . esc_attr($attr[1]) . '"'; }, $dataAttrs)))); ?><?php do_action('wpz_payments_containter_attrs', $this->props); ?>>
			<?php do_action('wpz_payments_start', $this->props); ?>
                <h4 class="wpz-payments-title"><?php echo(esc_html($this->props['title'])); ?></h4>
                <div class="wpz-payments-description">
					<?php echo(et_core_intentionally_unescaped($this->props['content'], 'html')); ?>
                </div>
                <div class="wpz-payments-price">
                    <label>
						<span class="wpz-payments-label wpz-payments-price-label">
							<?php echo(esc_html($this->props['price_label'])); ?>
						</span>
						<?php if ( $this->props['price_type'] == 'custom' ) { ?>
                            <span class="wpz-payments-price-wrapper">
							<?php if ( $settings['general_currency_symbol_position'] == 'before' || $settings['general_currency_symbol_position'] == 'before_space' ) { ?>
                                <span class="wpz-payments-price-currency wpz-payments-price-currency-<?php echo(esc_attr($settings['general_currency_symbol_position'])); ?>">
                                    <?php echo(esc_html($settings['general_currency_symbol'])); ?>
                                </span>
							<?php } ?>
							<input
                                    type="number"
                                    class="wpz-payments-price-amount wpz-payments-form-field"
                                    value="<?php echo((float) $this->props['price_default']); ?>"
                                    min="<?php echo((float) max(0, $this->props['minimum_price'])); ?>"
									<?php if ($this->props['maximum_price']) { ?>max="<?php echo((float) $this->props['maximum_price']); ?>"<?php } ?>
                                    <?php if ($this->props['price_step']) { ?>step="<?php echo((float) $this->props['price_step']); ?>"<?php } ?>
                                    data-validation-message-minimum="<?php echo(esc_attr($this->props['validation_minimum_price'])); ?>"
									<?php if ($this->props['maximum_price']) { ?>data-validation-message-maximum="<?php echo(esc_attr($this->props['validation_maximum_price'])); ?>"<?php } ?>
                                    <?php if ($this->props['price_step']) { ?>data-validation-message-step="<?php echo(esc_attr($this->props['validation_step_price'])); ?>"<?php } ?>
                            >
							<?php if ( $settings['general_currency_symbol_position'] == 'after' || $settings['general_currency_symbol_position'] == 'after_space' ) { ?>
                                <span class="wpz-payments-price-currency wpz-payments-price-currency-<?php echo(esc_attr($settings['general_currency_symbol_position'])); ?>">
                                    <?php echo(esc_html($settings['general_currency_symbol'])); ?>
                                </span>
							<?php } ?>
                        </span>
						<?php } else { ?>
                            <span class="wpz-payments-price-amount wpz-payments-fixed-price-amount" data-value="<?php echo((float) $this->props['price_default']); ?>">
								<?php
								if ( $settings['general_currency_symbol_position'] == 'before' || $settings['general_currency_symbol_position'] == 'before_space' ) {
									echo(esc_html($settings['general_currency_symbol']));
									if ( $settings['general_currency_symbol_position'] == 'before_space' ) {
										echo(' ');
									}
								}
								echo(number_format($this->props['price_default'], 2));
								if ( $settings['general_currency_symbol_position'] == 'after' || $settings['general_currency_symbol_position'] == 'after_space' ) {
									if ( $settings['general_currency_symbol_position'] == 'after_space' ) {
										echo(' ');
									}
									echo(esc_html($settings['general_currency_symbol']));
								}
								?>
							</span>
						<?php } ?>
                    </label>
                </div>
				<?php do_action('wpz_payments_before_form', $this->props); ?>
                <?php if ($stripeEnabled) { ?><div class="wpz-payments-form"></div><?php } ?>
				<?php do_action('wpz_payments_after_form', $this->props); ?>
				<?php if ( $this->props['notes_field'] == 'on' ) { ?>
                    <div class="wpz-payments-notes">
                        <label for="<?php echo(esc_attr($moduleOrderClass)); ?>_notes_field" class="wpz-payments-label wpz-payments-notes-label">
							<?php echo(esc_html($this->props['notes_field_label'])); ?>
                        </label>
                        <div class="wpz-payments-notes-instructions">
							<?php echo(et_core_intentionally_unescaped(self::fixHtmlProp($this->props['notes_field_instructions']), 'html')); ?>
                        </div>
                        <textarea
                                id="<?php echo(esc_attr($moduleOrderClass)); ?>_notes_field"
                                class="wpz-payments-notes-field wpz-payments-form-field"
							<?php if ( $this->props['notes_field_required'] === 'on' ) {
								echo('required');
							} ?>
						></textarea>
                    </div>
				<?php } ?>
				<?php if ( $this->props['agreement_checkbox'] == 'on' ) { ?>
                    <div class="wpz-payments-agreement">
                        <div class="wpz-payments-agreement-checkbox-wrapper">
                            <input type="checkbox" id="<?php echo(esc_attr($moduleOrderClass)); ?>_payment_module_agreement_checkbox" class="wpz-payments-agreement-checkbox" data-validation-message="<?php echo(esc_attr($this->props['validation_agreement'])); ?>"/>
                            <span class="checkbox-StyledInput"></span>
                        </div>

                        <label for="<?php echo(esc_attr($moduleOrderClass)); ?>_payment_module_agreement_checkbox">
                            <span class="wpz-payments-agreement-text">
								<?php echo(et_core_intentionally_unescaped(self::fixHtmlProp($this->props['agreement_text']), 'html')); ?>
                            </span>
                        </label>
                    </div>
				<?php } ?>

                <div class="wpz-payments-button-wrapper">
					<?php if ($paypalEnabled) { ?><div class="wpz-payments-paypal-button"></div><?php } ?>
                    <?php if ($stripeEnabled) { ?><button type="button" class="wpz-payments-pay-button wpz-payments-disabled et_pb_button" data-text-template="<?php echo(esc_attr($this->props['button_text'])); ?>" disabled></button><?php } ?>
                </div>

				<?php
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not a CSRF risk because there are no persistent changes
				if ( isset($_GET['wpz_payments_error']) && $_GET['wpz_payments_error'] == self::_get_index(array(self::INDEX_MODULE_ORDER, $this->slug)) + 1 ) {
					?>
                    <div class="wpz-payments-error">
						<?php
						// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not a CSRF risk because there are no persistent changes
						echo(et_core_intentionally_unescaped(wpautop(esc_html(str_replace('%{error_reason}', empty($_GET['wpz_payments_reason']) ? __('Unknown', 'wpz-payments') : sanitize_text_field($_GET['wpz_payments_reason']), $this->props['error_message']))), 'html'));
						?>
                    </div>
					<?php
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not a CSRF risk because there are no persistent changes
				} else if ( isset($_GET['wpz_payments_success']) && $this->props['success_action'] != 'redirect' && $_GET['wpz_payments_success'] == self::_get_index(array(self::INDEX_MODULE_ORDER, $this->slug)) + 1 ) {
					?>
                    <div class="wpz-payments-success">
						<?php
						// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not a CSRF risk because there are no persistent changes
						echo(et_core_intentionally_unescaped(wpautop(esc_html(str_replace('%{error_reason}', empty($_GET['wpz_payments_reason']) ? __('Unknown', 'wpz-payments') : sanitize_text_field($_GET['wpz_payments_reason']), $this->props['success_message']))), 'html'));
						?>
                    </div>
				<?php } ?>
				
				<?php if ($isFree || $this->props['show_credit'] == 'on') { ?>
					<?php if ($stripeEnabled) { ?>
					<small class="wpz-payments-credit wpz-payments-credit-stripe">
						<?php
						printf(
							// translators: %s are <a> tags, except for second %s which is payment processor name
							esc_html__('Payment form powered by %s%s%s and %sSimple Payment Module for Divi%s', 'wpz-payments'),
							'<a href="https://stripe.com/" target="_blank">',
							esc_html__('Stripe', 'wpz-payments'),
							'</a>',
							'<a href="https://wpzone.co/product/simple-payment-module-for-divi/" target="_blank">',
							'</a>'
						);
						?>
					</small>
					<?php } ?>
					<?php if ($paypalEnabled) { ?>
					<small class="wpz-payments-credit wpz-payments-credit-paypal"<?php if ($stripeEnabled) { ?> aria-hidden="true"<?php } ?>>
						<?php
						printf(
							// translators: %s are <a> tags, except for second %s which is payment processor name
							esc_html__('Payment form powered by %s%s%s and %sSimple Payment Module for Divi%s', 'wpz-payments'),
							'<a href="https://paypal.com/" target="_blank">',
							esc_html__('PayPal', 'wpz-payments'),
							'</a>',
							'<a href="https://wpzone.co/product/simple-payment-module-for-divi/" target="_blank">',
							'</a>'
						);
						?>
					</small>
					<?php } ?>
				<?php } ?>

                <div class="wpz-payments-preloader">
                   <span class="wpz-payments-preloader-icon">
                       <?php echo et_core_intentionally_unescaped($this->getIconSvg($this->props['preloader_style'], true), 'html'); ?>
                   </span>
					<?php if ( $this->props['preloader_text_enable'] == 'on' ) { ?>
                        <span class="wpz-payments-preloader-text"><?php echo(esc_attr($this->props['preloader_text'])); ?></span>
					<?php } ?>
                </div>
			<?php do_action('wpz_payments_end', $this->props); ?>
        </div>
		<?php do_action('wpz_payments_after_container', $this->props); ?>

        <script>jQuery(function () {
                window.wpz_payments_init('.<?php echo(esc_html($moduleOrderClass)); ?>:first .wpz-payments-container:first');
            });</script>
		<?php

		return ob_get_clean();
	}


	/**
	 * Override parent method to set up conditional text shadow fields
	 * {@see parent::_set_fields_unprocessed}
	 *
	 * @param Array fields array
	 */
	protected function _set_fields_unprocessed($fields) {

		if ( ! is_array($fields) ) {
			return;
		}

		$template  = ET_Builder_Module_Helper_OptionTemplate::instance();
		$newFields = [];

		foreach ( $fields as $field => $definition ) {
			if ( ($definition === 'text_shadow' || $definition === 'box_shadow') && $template->is_enabled() && $template->has( $definition ) ) {

				$data    = $template->get_data($field);
				$setting = end($data);

				$settingWithShowIf = self::setFieldShowIf($setting, $field, $fields);
				$new_definition    = $settingWithShowIf ? ET_Builder_Module_Fields_Factory::get($definition == 'box_shadow' ? 'BoxShadow' : 'TextShadow')->get_fields($settingWithShowIf) : null;

				if ( $new_definition ) {
					$field      = array_keys($new_definition)[0];
					$definition = array_values($new_definition)[0];
				}

			} else if ( ! isset($definition['background_tab']) ) {
				$definitionWithShowIf = self::setFieldShowIf($definition, $field, $fields);
				$definition           = $definitionWithShowIf ? $definitionWithShowIf : $definition;
			}

			$newFields[ $field ] = $definition;
		}

		return parent::_set_fields_unprocessed($newFields);
	}


	public static function setFieldShowIf($field, $fieldId, $allFields) {

		// Add condition for register form
		if ( isset($field['toggle_slug']) ) {

			if ( empty($field['show_if']) ) {
				switch ( $field['toggle_slug'] ) {
					case 'price_fixed':
						$field['show_if'] = array(
							'price_type' => 'fixed'
						);
						break;
					case 'price_custom_field':
					case 'price_custom_currency':
						$field['show_if'] = array(
							'price_type' => 'custom'
						);
						break;
					case 'notes_field_instructions_design':
						$field['show_if'] = array(
							'notes_field' => 'on'
						);
						break;
					case 'notification_success':
						$field['show_if'] = array(
							'success_action' => 'message'
						);
						break;
				}
			}
		
		
			$field['show_if'] = apply_filters(
										'wpz_payments_divi_module_field_show_if',
										empty($field['show_if']) ? [] : $field['show_if'],
										$field['toggle_slug'],
										$fieldId
			);
			
			$field['show_if_not'] = apply_filters(
										'wpz_payments_divi_module_field_show_if_not',
										empty($field['show_if_not']) ? [] : $field['show_if_not'],
										$field['toggle_slug'],
										$fieldId
			);

			if ( isset($field['depends_show_if']) || isset($field['depends_show_if_not']) ) {

				foreach ( $allFields as $testFieldId => $testField ) {
					if ( isset($testField['affects']) && in_array($fieldId, $testField['affects']) ) {
						$dependsField = $testFieldId;
						break;
					}
				}

				if ( isset($dependsField) ) {
					if ( isset($field['depends_show_if']) ) {
						$showIf           = [$dependsField => $field['depends_show_if']];
						$field['show_if'] = isset($field['show_if']) ? array_merge($field['show_if'], $showIf) : $showIf;
					}
					if ( isset($field['depends_show_if_not']) ) {
						$showIf               = [$dependsField => $field['depends_show_if_not']];
						$field['show_if_not'] = isset($field['show_if_not']) ? array_merge($field['show_if_not'], $showIf) : $showIf;
					}
				}
			}

			return $field;
		}

		return null;
	}

	protected static function fixHtmlProp($propValue) {
		$propValue = trim($propValue);

		return substr(
			$propValue,
			strcasecmp(substr($propValue, 0, 4), '</p>') ? 0 : 4,
			strcasecmp(substr($propValue, - 3), '<p>') ? null : - 3
		);
	}


	// Borders fields may not support show_if when using the option template
	protected function _add_borders_fields() {
		add_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
		parent::_add_borders_fields();
		remove_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
	}


	public static function _false() {
		return false;
	}
}

new WPZ_Payments_Divi_Module;