<?php
/**
 * Plugin Name:        WPZ Payments Free
 * Version:            1.1.14
 * Description:        A Simple, Lightweight Solution For Collecting Payments In Divi Without The Need For WooCommerce
 * Author:             WP Zone
 * Author URI          https://wpzone.co
 * Plugin URI:         https://wpzone.co/product/simple-payment-module-for-divi/
 * GitLab Plugin URI:  https://gitlab.com/aspengrovestudios/wpz-payments/
 * License:            GPLv3+
 * License URI:        http://www.gnu.org/licenses/gpl.html
 * AGS Info:           -
 * Text Domain:        wpz-payments
 * Domain Path:        includes/languages
 */


/*
WPZ Payments Free Plugin
Copyright (C) 2024  WP Zone

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

============

For the text of the GNU General Public License version 3, and licensing/copyright
information for third-party code used in this product, see ./license.txt.

*/

defined( 'ABSPATH' ) || die();
class WPZ_Payments {

	const    VERSION = '1.1.14';
	const    PLUGIN_AUTHOR_URL = 'https://wpzone.co/';
	const    PLUGIN_SLUG = 'wpz-payments';
	const    PLUGIN_NAME = "WPZ Payments Free";
	const    PLUGIN_PAGE = 'admin.php?page=wpz-payments-settings';
	const    PRODUCT_URI = 'https://wpzone.co/product/simple-payment-module-for-divi/';
	const    DEFAULT_SETTINGS = [
		'general_currency_symbol' => '$',
		'general_currency_symbol_position' => 'before',
		'stripe_enable' => 1,
		'stripe_test' => 0,
		'stripe_key_live' => '',
		'stripe_secret_live' => '',
		'stripe_key_test' => '',
		'stripe_secret_test' => '',
		'stripe_currency' => 'USD',
		'stripe_webhook_secret' => '',
		'paypal_enable' => 0,
		'paypal_test' => 0,
		'paypal_client_id_live' => '',
		'paypal_client_id_test' => '',
		'paypal_webhook_id_live' => '',
		'paypal_webhook_id_test' => '',
		'paypal_currency' => 'USD',
		'paypal_sources_enabled' => '',
		'paypal_sources_disabled' => ''
	];

        public static $plugin_base_url;
        public static $plugin_directory;
        public static $plugin_file;
        public static $paymentStatuses;
        public static $modulePaymentParams = false;

        private static $isFree = true;

        public static function setup() {
            self::$plugin_base_url  = plugin_dir_url( __FILE__ );
            self::$plugin_directory = __DIR__ . '/';
            self::$plugin_file      = __FILE__;
            

            

            if ( is_admin() ) {
                include_once self::$plugin_directory . 'includes/admin/addons/addons.php';
                add_action( 'admin_menu', [ 'WPZ_Payments', 'admin_menu' ], 11 );
                register_activation_hook( __FILE__, [ 'WPZ_Payments', 'plugin_first_activate' ] );
            }

            

            self::load_text_domain();

            


                add_action( 'divi_extensions_init', [ 'WPZ_Payments', 'initialize_divi_extension' ] );
                add_action( 'wp_ajax_wpz_payments_preflight', [ __CLASS__, 'paymentPreflightAjax' ] );
                add_action( 'wp_ajax_nopriv_wpz_payments_preflight', [ __CLASS__, 'paymentPreflightAjax' ] );
                add_action('init', [__CLASS__, 'onInit']);
                add_action('admin_init', [__CLASS__, 'onAdminInit']);

                // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- just a flag, any needed nonce validation will be handled in the hooked function
			if (isset($_REQUEST['wpz_payments_payment'])) {
				add_filter('et_builder_should_load_framework', '__return_true', 999);
                // required for payment validation
                add_action('wp', [__CLASS__, 'handlePayment'], 999);
                // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- just a flag, any needed nonce validation will be handled in the hooked function
                } else if (isset($_GET['wpz_payments_webhook'])) {
				    add_filter('et_builder_should_load_framework', '__return_true', 999); // required for payment validation
                    add_action('wp', [__CLASS__, 'handleWebhook'], 999);
                }

                

            add_action( 'load-plugins.php', [ 'WPZ_Payments', 'plugin_action_links' ], 10 );
            add_action( 'admin_enqueue_scripts', [ 'WPZ_Payments', 'admin_scripts' ], 10 );
			
			add_filter( 'wp_untrash_post_status', [__CLASS__, 'maybeRestoreUntrashedPostStatus'], 99, 3 );

            self::$paymentStatuses = [
			'wpz-payment-draft' => __('Draft', 'wpz-payments'),
                'wpz-payment-paid' => __('Paid', 'wpz-payments'),
                'wpz-payment-process' => __('Payment Processing', 'wpz-payments'),
                'wpz-payment-failed' => __('Payment Failed', 'wpz-payments'),
                'wpz-payment-invalid' => __('Payment Invalid', 'wpz-payments'),
                'wpz-payment-complete' => __('Complete', 'wpz-payments'),
                'wpz-payment-refunded' => __('Payment Refunded', 'wpz-payments'),
            ];

            
        }

        static function isFree() {
            return self::$isFree;
        }
		
		static function maybeRestoreUntrashedPostStatus($filterValue, $postId, $preTrashStatus) {
			return get_post_type($postId) == 'wpz-payment' ? $preTrashStatus : $filterValue;
		}

        static function onInit() {
            // wp-includes/post.php
            register_post_type(
                'wpz-payment',
                array(
                    'labels'                => array(
                        'name'           => __( 'Payments', 'wpz-payments' ),
                        'singular_name'  => __( 'Payment', 'wpz-payments' ),
                        'edit_item'      => __( 'Edit Payment', 'wpz-payments' ),
                        'add_new_item'   => __( 'Add New Payment', 'wpz-payments' ),
                        'search_items'   => __( 'Search Payment', 'wpz-payments' ),
                        'not_found'      => __( 'Not Found', 'wpz-payments' ),
                    ),
                    'public'                => false,
                    'show_ui'               => true,
                    'capability_type'       => 'wpz-payment',
                    'map_meta_cap'          => true,
                    'capabilities' =>		['create_posts' => 'wpz-payment-create'],
                    'menu_icon'             => 'dashicons-money',
                    'hierarchical'          => false,
                    'rewrite'               => false,
                    'query_var'             => false,
                    'show_in_nav_menus'     => false,
                    'delete_with_user'      => false,
                    'supports'              => array( 'title' ),
                )
            );

            foreach (self::$paymentStatuses as $statusId => $statusName) {
                register_post_status(
                    $statusId,
                    [
                        'label' => $statusName,
                        'label_count' => array_map(
                            function($str) use ($statusName) {
                                return $str ? sprintf(
                                    $str,
                                    esc_html($statusName),
                                    '%s'
                                ) : $str;
                            },
                            // translators: first %s is the post status name, second %s is the post count
                            _n_noop('%s <span class="count">(%s)</span>', '%s <span class="count">(%s)</span>', 'wpz-payments')
                        ),
					'public' => $statusId != 'wpz-payment-draft'
                    ]
                );
            }

            if (is_multisite() && is_super_admin()) {
                // Suppress the Add New option for the payment CPT
                add_filter('map_meta_cap', function($capabilities, $capability) {
                    if ($capability == 'wpz-payment-create') {
                        $capabilities[] = 'do_not_allow';
                    }
                    return $capabilities;
                }, 10, 2);
            }

        }

        static function onAdminInit() {
            remove_meta_box('submitdiv', 'wpz-payment', 'side');

            if ( is_admin() && current_user_can('manage_options') ) {
	        include_once self::$plugin_directory . 'includes/admin/notices/admin-notices.php';
            }
            // wp-admin/includes/meta-boxes.php
            add_meta_box( 'wpz_payment_info', __( 'Payment Details', 'wpz-payments' ), [__CLASS__, 'paymentMetaBox'], 'wpz-payment', 'normal' );

            add_action('edit_post_wpz-payment', [__CLASS__, 'savePaymentMeta']);
            add_filter('manage_wpz-payment_posts_columns', [__CLASS__, 'filterPaymentColumns']);
            add_action('manage_wpz-payment_posts_custom_column', [__CLASS__, 'renderPaymentColumn'], 10, 2);
        }

        /**
         *  On plugin activate, creates an options to store
         *  activation date
         *
         * @used in notice_admin_conditions
         */
        public static function plugin_first_activate() {
            $firstActivate = get_option( 'wpz_payments_first_activate' );
            if ( empty( $firstActivate ) ) {
                update_option( 'wpz_payments_first_activate', time(), false );
                update_option( 'wpz_payments_notice_hidden', 0, false );
            }
        }

        static function filterPaymentColumns($columns) {
            return [
                'cb' => $columns['cb'],
                'title' => $columns['title'],
                'item' => esc_html__('Item', 'wpz-payments'),
                'amount' => esc_html__('Amount', 'wpz-payments'),
                'status' => esc_html__('Status', 'wpz-payments'),
                'date' => $columns['date']
            ];
        }

        static function renderPaymentColumn($column, $postId) {
		$postStatus = get_post_status($postId);
		if ($column == 'status' || $postStatus != 'wpz-payment-draft') {
            switch ($column) {
                case 'item':
                    $description = get_post_meta($postId, '_description', true);
                    echo(esc_html($description ? $description : __('(not specified)', 'wpz-payments')));
                    break;
                case 'amount':
                    $total = (float) get_post_meta($postId, '_total', true);
                    echo(number_format($total, 2));
                    break;
                case 'status':
					echo(esc_html(self::$paymentStatuses[$postStatus == 'trash' ? get_post_meta($postId, '_wp_trash_meta_status', true) : $postStatus]));
                    break;
            }
        }
	}

        static function savePaymentMeta($paymentId) {
            if (isset($_POST['wpz_payments']) && current_user_can('edit_post', $paymentId)) {
                check_admin_referer('wpz_payment_meta_'.$paymentId, 'wpz_payments_nonce');

                $fields = array_map('sanitize_textarea_field', $_POST['wpz_payments']);
                unset($_POST['wpz_payments']); // prevent infinite loops

                if (isset($fields['payment_status'])) {
                    $newStatus = $fields['payment_status'];
                    if (isset(self::$paymentStatuses[$newStatus])) {
                        wp_update_post([
                            'ID' => $paymentId,
                            'post_status' => $newStatus
                        ]);
                    }
                }

                if (isset($fields['internal_notes'])) {
                    if ($fields['internal_notes']) {
                        update_post_meta($paymentId, '_internal_notes', $fields['internal_notes']);
                    } else {
                        delete_post_meta($paymentId, '_internal_notes');
                    }

                }
            }
        }

        static function paymentMetaBox($paymentPost) {
		if ($paymentPost->post_status == 'wpz-payment-draft') {
?>
			<p class="wpz-payment-draft-notice">
				<?php esc_html_e('This is a draft payment. Details are not yet available.', 'wpz-payments'); ?>
			</p>
<?php
			return;
		}
			
            $sourceId = get_post_meta($paymentPost->ID, '_source_id', true);
            $description = get_post_meta($paymentPost->ID, '_description', true);
            $quantity = get_post_meta($paymentPost->ID, '_quantity', true);
            $total = get_post_meta($paymentPost->ID, '_total', true);
            $paymentMethod = get_post_meta($paymentPost->ID, '_payment_method', true);
            $currency = get_post_meta($paymentPost->ID, '_currency', true);
            $transactionId = get_post_meta($paymentPost->ID, '_transaction_id', true);
            $internalNotes = get_post_meta($paymentPost->ID, '_internal_notes', true);
            if ( $paymentPost->post_status == 'wpz-payment-failed' || $paymentPost->post_status == 'wpz-payment-invalid' ) {
                $paymentError = get_post_meta($paymentPost->ID, '_payment_error', true);
            }
			
			switch ($paymentMethod) {
				case 'stripe':
					require_once(__DIR__.'/includes/stripe.php');
					$paymentMethodObject = new WPZ_Payments_Stripe();
					break;
				case 'paypal':
					require_once(__DIR__.'/includes/paypal.php');
					$paymentMethodObject = new WPZ_Payments_PayPal();
					break;
			}

            wp_nonce_field('wpz_payment_meta_'.$paymentPost->ID, 'wpz_payments_nonce');
    ?>
            <div class="wpz-payment-meta-3col">
                <div>
                    <label><?php esc_html_e('Payment Time:', 'wpz-payments'); ?></label>
                    <span><?php echo(esc_html(get_post_time(get_option('date_format').' '.get_option('time_format'), false, $paymentPost, true))); ?></span>
                </div>
                <div>
                    <label for="wpz_payments_payment_status"><?php esc_html_e('Payment Status:', 'wpz-payments'); ?></label>
                    <span>
                        <select id="wpz_payments_payment_status" name="wpz_payments[payment_status]">
						<?php foreach (self::$paymentStatuses as $statusId => $statusName) { if ($statusId !== 'wpz-payment-draft') {?>
                            <option value="<?php echo(esc_attr($statusId)); ?>"<?php selected($paymentPost->post_status == $statusId); ?>><?php echo(esc_html($statusName)); ?></option>
						<?php } } ?>
                        </select>
                    </span>
                </div>
                <div>
                    <label><?php esc_html_e('Source Page/Post:', 'wpz-payments'); ?></label>
                    <span><?php if ($sourceId) { echo('<a href="'.esc_url(get_the_permalink($sourceId)).'" target="_blank">'.((int) $sourceId).'</a>'); } else { esc_html_e('Unknown', 'wpz-payments'); } ?></span>
                </div>
            </div>

            <div class="wpz-payment-meta-item">
                <div>
                    <label><?php esc_html_e('Item Name:', 'wpz-payments'); ?></label>
                    <span><?php echo(esc_html($description ? $description : __('(not specified)', 'wpz-payments'))); ?></span>
                </div>
                <div>
                    <label><?php esc_html_e('Quantity:', 'wpz-payments'); ?></label>
                    <span><?php if ($quantity) { echo((float) $quantity); } else { esc_html_e('N/A', 'wpz-payments'); } ?></span>
                </div>
                <div>
                    <label><?php esc_html_e('Price:', 'wpz-payments'); ?></label>
                    <span><?php echo(number_format((float) $total / ($quantity ? $quantity : 1), 2)); ?></span>
                </div>
                <div>
                    <label><?php esc_html_e('Total:', 'wpz-payments'); ?></label>
                    <span><?php echo(number_format((float) $total, 2)); ?></span>
                </div>
            </div>

            <div class="wpz-payment-meta-3col">
                <div>
                    <label><?php esc_html_e('Payment Method:', 'wpz-payments'); ?></label>
                    <span>
						<?php
							switch ($paymentMethod) {
								case 'stripe':
									esc_html_e('Stripe', 'wpz-payments');
									break;
								case 'paypal':
									esc_html_e('PayPal', 'wpz-payments');
									break;
								default:
									esc_html_e('Unknown', 'wpz-payments');
							}
						?>
					</span>
                </div>
                <div>
                    <label><?php esc_html_e('Currency:', 'wpz-payments'); ?></label>
                    <span><?php echo(esc_html(strtoupper($currency))); ?></span>
                </div>
                <div>
                    <label><?php esc_html_e('Transaction ID:', 'wpz-payments'); ?></label>
                    <span><?php if ($transactionId) { echo('<a href="'.esc_url($paymentMethodObject->getTransactionUrl($transactionId)).'" target="_blank">'.esc_html($transactionId).'</a>'); } else { esc_html_e('Unknown', 'wpz-payments'); } ?></span>
                </div>
            </div>

            <div class="wpz-payment-meta-full">
                <?php if ( !empty($paymentError) ) { ?>
                <div>
                    <label><?php esc_html_e('Payment Error:', 'wpz-payments'); ?></label>
                    <p><?php echo(esc_html($paymentError)); ?></p>
                </div>
                <?php } ?>

                <?php if ( !empty($paymentPost->post_content) ) { ?>
                <div>
                    <label><?php esc_html_e('Customer Notes:', 'wpz-payments'); ?></label>
                    <?php echo(et_core_intentionally_unescaped(wpautop(esc_html($paymentPost->post_content)), 'html')); ?>
                </div>
                <?php } ?>

                <div>
                    <label><?php esc_html_e('Internal Notes:', 'wpz-payments'); ?></label>
                    <textarea class="notes-textarea" name="wpz_payments[internal_notes]"><?php echo(esc_textarea($internalNotes)); ?></textarea>
                </div>
            </div>

            <button class="button button-primary"><?php esc_html_e('Save Payment', 'wpz-payments'); ?></button>
    <?php
        }

        static function paymentPreflightAjax() {
            check_ajax_referer('wpz_payments_payment');

            if (isset($_POST['paymentMethod'])) {
                switch ($_POST['paymentMethod']) {
                    case 'stripe':
                        require_once(__DIR__.'/includes/stripe.php');
                        $stripe = new WPZ_Payments_Stripe();
                        try {
                            $postSanitized = array_map('sanitize_text_field', array_intersect_key($_POST,[
								'intentId' => 1,
								'amount' => 1,
								'description' => 1,
								'quantity' => 1,
								'sourceId' => 1,
								'statementDescriptor' => 1
							]));
							if (isset($_POST['notes'])) {
								$postSanitized['notes'] = sanitize_textarea_field($_POST['notes']);
							}
                            if (empty($postSanitized['intentId'])) {
                                throw new Exception();
                            }
							$intentId = sanitize_text_field($postSanitized['intentId']);
                            $updatedIntentId = $stripe->updateSessionPaymentIntent(
                                $intentId,
                                $postSanitized
                            );
							if ($updatedIntentId == $intentId) {
								wp_send_json_success();
							} else {
								wp_send_json_error(['newIntentId' => $updatedIntentId]);
							}
                        } catch (Exception $ex) {
                            wp_send_json_error($ex->getMessage());
                        }
                        break;
                }
            }

            wp_send_json_error();
        }

        static function handlePayment() {
            // phpcs:disable WordPress.Security.NonceVerification -- since input will be validated with the payment processor, CSRF should not be an issue - only legitimate requests will be accepted

            $success = false;
            $resultArgs = [];
		if (isset($_REQUEST['wpz_payments_payment'])) {
			switch ($_REQUEST['wpz_payments_payment']) {
                    case 'stripe':
                        if (isset($_GET['payment_intent']) && isset($_GET['payment_intent_client_secret'])) {
                            require_once(__DIR__.'/includes/stripe.php');
                            $stripe = new WPZ_Payments_Stripe();
                            try {
                                $stripe->processPayment(sanitize_text_field($_GET['payment_intent']), sanitize_text_field($_GET['payment_intent_client_secret']));
                                $success = true;
                            } catch (Exception $ex) {
                                $message = $ex->getMessage();
                                if ($message) {
                                    $resultArgs['wpz_payments_reason'] = $message;
                                }
                            }
							$stripe->clearSessionPaymentIntent();
                        }
                        break;

				case 'paypal':
					// phpcs:disable WordPress.Security.NonceVerification.Missing -- this is a non-privileged insertion of a draft payment that will be validated via PayPal; not a CSRF security risk
					if (isset($_POST['payment_id']) && isset($_POST['post_id']) && isset($_POST['notes'])) {
						require_once(__DIR__.'/includes/paypal.php');
						$paypal = new WPZ_Payments_PayPal();
						try {
							$paypal->processPayment(
								sanitize_text_field($_POST['payment_id']),
								(int) $_POST['post_id'],
								sanitize_textarea_field($_POST['notes'])
							);
							$success = true;
						} catch (Exception $ex) {
							$message = $ex->getMessage();
							if ($message) {
								$resultArgs['wpz_payments_reason'] = $message;
							}
						}
					}
					// phpcs:enable WordPress.Security.NonceVerification.Missing
					break;
                }
            }


		if (empty($_REQUEST['ajax'])) {
                $resultArgs[ 'wpz_payments_'.($success ? 'success' : 'error') ] = isset($_GET['wpz_payments_target']) ? (int) $_GET['wpz_payments_target'] : 0;
                wp_safe_redirect( add_query_arg($resultArgs, remove_query_arg(['payment_intent', 'payment_intent_client_secret', 'redirect_status', 'wpz_payments_payment', 'wpz_payments_target', 'wpz_payments_success[]', 'wpz_payments_error[]'])) );
                exit;
            }

            // phpcs:enable WordPress.Security.NonceVerification

            if ($success) {
                wp_send_json_success();
            }

            wp_send_json_error(isset($resultArgs['wpz_payments_reason']) ? $resultArgs['wpz_payments_reason'] : null);
        }

        static function handleWebhook() {
            // phpcs:disable WordPress.Security.NonceVerification -- incoming webhooks are verified via signature or other means, so CSRF should not be an issue since only legitimate requests will be accepted
            if (isset($_GET['wpz_payments_webhook'])) {
                switch ($_GET['wpz_payments_webhook']) {
                    case 'stripe':
                        require_once(__DIR__.'/includes/stripe.php');
                        $stripe = new WPZ_Payments_Stripe();
                        try {
                            $stripe->processWebhook( sanitize_textarea_field( file_get_contents('php://input') ) );
                            $success = true;
                        } catch (Exception $ex) {
                            $message = $ex->getMessage();
					}
					break;
				case 'paypal':
					require_once(__DIR__.'/includes/paypal.php');
					$paypal = new WPZ_Payments_PayPal();
					try {
						$paypal->processWebhook( sanitize_textarea_field( file_get_contents('php://input') ) );
						$success = true;
					} catch (Exception $ex) {
						$message = $ex->getMessage();
                        }
                        break;
                }
            }
            // phpcs:enable WordPress.Security.NonceVerification
        }

        static function getPostPaymentParams($postId) {
            self::$modulePaymentParams = [];

            $postIdToCheck = $postId;
            $tbRequest = ET_Theme_Builder_Request::from_post($postId);
            $tbLayouts = et_theme_builder_get_template_layouts($tbRequest);

            if (!empty($tbLayouts[ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE]['enabled']) && !empty($tbLayouts[ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE]['id']) && !et_theme_builder_layout_has_post_content($tbLayouts[ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE])) {
                $postIdToCheck = $tbLayouts[ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE]['id'];
            }

            ob_start(); // as a precaution
            apply_filters('the_content', get_post($postIdToCheck)->post_content);
            ob_end_clean();

            $params = self::$modulePaymentParams;
            self::$modulePaymentParams = false;

            return $params;
        }

        static function validatePayment($sourcePostId, $itemName, $amount, $quantity) {
            $itemName = trim($itemName);
            $params = self::getPostPaymentParams($sourcePostId);

            if (!isset($params[$itemName])) {
                throw new Exception( sprintf(
                    __('Invalid item name: %s (expected one of: %s)', 'wpz-payments'),
                    $itemName,
                    $params ? implode(',', array_keys($params)) : __('[none found]',  'wpz-payments')
                ) );
            }

            $params = $params[$itemName];
			$quantityStep = (float) $params['quantityStep'];

            if ($quantity < max(0, $params['quantityMin']) || ($params['quantityMax'] && $quantity > $params['quantityMax']) || ($quantityStep && fmod($quantity, $quantityStep))) {
                throw new Exception( sprintf(
                    __('Invalid quantity: %s (expected: min %f, max %f, step %f)', 'wpz-payments'),
                    $quantity,
                    max(0, $params['quantityMin']),
                    $params['quantityMax'],
                    $quantityStep
                ) );
            }

            $itemPrice = round($amount / $quantity, 2);
			$priceStep = (float) $params['priceStep'];

            if ($itemPrice < max(0, $params['priceMin']) || ($params['priceMax'] && $itemPrice > $params['priceMax']) || ($priceStep && fmod($itemPrice, $priceStep))) {
                throw new Exception( sprintf(
                    __('Invalid item price: %s/%f = %f (expected: min %f, max %f, step %f)', 'wpz-payments'),
                    $amount,
                    $quantity,
                    $itemPrice,
                    max(0, $params['priceMin']),
                    $params['priceMax'],
                    $priceStep
                ) );
            }

            return true;
        }


        /**
         * Creates the extension's main class instance.
         *
         * @since 1.0.0
         */

        public static function initialize_divi_extension() {
            require_once plugin_dir_path( __FILE__ ) . 'includes/PaymentModule.php';
        }


        /**
         * Enqueue scripts for admin page.
         * Called in setup()
         *
         * @param int $hook Hook suffix for the current admin page.
         *
         * @since 1.0.0
         *
         */
        public static function admin_scripts( $hook ) {
            if ( 'wpz-payment_page_wpz-payments-settings' === $hook || 'admin_page_wpz-payments-settings' === $hook || 'settings_page_wpz-payments-settings' === $hook ) {
                wp_enqueue_style( 'wpz-payments-admin', self::$plugin_base_url . 'assets/css/admin.min.css', [], self::VERSION );
                wp_enqueue_script( 'wpz-payments-admin', self::$plugin_base_url . 'assets/js/admin.min.js', [ 'jquery' ], self::VERSION, true );
            }
        }

        /**
         * Register Admin Menu Item "WPZ Payments Free"
         *
         * @since 1.0.0
         *
         */
        public static function admin_menu() {

            
	            add_submenu_page(
		            'edit.php?post_type=wpz-payment', __( 'WPZ Payments Free', 'wpz-payments' ),  __( 'Settings', 'wpz-payments' ), 'manage_options', 'wpz-payments-settings', [
		            'WPZ_Payments',
		            'admin_page'
	            ], 7 );
            

        }


        /**
         * The function outputs the admin page content
         * Called in admin_menu()
         *
         * @since 1.0.0
         *
         */
        public static function admin_page() {
            

            if (isset($_POST['settings'])) {
                check_admin_referer('wpz_payments_settings', 'wpz_payments_nonce');

                $currentSettings = get_option('wpz_payments_settings', []);
			if (empty($_POST['settings']['stripe_enable'])) {
				$_POST['settings']['stripe_enable'] = 0;
			}
                $settings = array_merge(self::DEFAULT_SETTINGS, array_intersect_key(array_map('sanitize_text_field', $_POST['settings']), self::DEFAULT_SETTINGS));

                foreach ($settings as $settingsKey => &$settingsValue) {
                    if (
					in_array($settingsKey, ['stripe_key_live', 'stripe_secret_live', 'stripe_key_test', 'stripe_secret_test', 'stripe_webhook_secret', 'paypal_client_id_live', 'paypal_client_id_test', 'paypal_webhook_id_live', 'paypal_webhook_id_test'])
                        && $settingsValue
                        && $settingsValue == str_repeat('*', strlen($settingsValue))
                        && isset($currentSettings[$settingsKey])
                    ) {
                        $settingsValue = $currentSettings[$settingsKey];
                    }
                }

                update_option('wpz_payments_settings', $settings, false);

                require_once(__DIR__.'/includes/stripe.php');
                WPZ_Payments_Stripe::clearAllSessionPaymentIntents();
            }
            ?>
            <div id="wpz-payments-settings-container">
                <div id="wpz-payments-settings">

                    <div id="wpz-payments-settings-header">
                        <div class="wpz-payments-settings-logo">
                            <img alt="wpz-payments-logo"
                                 src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/plugin_icon.svg' ); ?>">
                            <h1><?php esc_html_e( 'WPZ Payments Free', 'wpz-payments' ); ?></h1>
                        </div>
                        <div id="wpz-payments-settings-header-links">
                            <a id="wpz-payments-settings-header-link-settings"
                               href=""><?php esc_html_e( 'Settings', 'wpz-payments' ); ?></a>
                            <a id="wpz-payments-settings-header-link-support"
                               href="https://wpzone.co/docs/plugin/simple-payment-module-for-divi/"
                               target="_blank"><?php esc_html_e( 'Documentation', 'wpz-payments' ); ?></a>
                        </div>
                    </div>

                    <ul id="wpz-payments-settings-tabs">

                        <?php
                        
                            ?>
                            <li class="wpz-payments-settings-active">
                                <a href="#settings"><?php esc_html_e( 'Settings', 'wpz-payments' ); ?></a>
                            </li>
                            <li>
                                <a href="#about"><?php esc_html_e( 'About', 'wpz-payments' ); ?></a>
                            </li>
                            <li>
                                <a href="#addons"><?php esc_html_e( 'Addons', 'wpz-payments' ) ?></a>
                            </li>
                            <?php
                            
                        ?>
                        
                    </ul>

                    <div id="wpz-payments-settings-tabs-content">

                        <?php
                        

                            ?>
                            <div id="wpz-payments-settings-settings"
                                 class="wpz-payments-settings-active">

                                 <?php $settings = array_merge( self::DEFAULT_SETTINGS, get_option('wpz_payments_settings', []) ); ?>

                                <form method="post">

                                    <?php wp_nonce_field('wpz_payments_settings', 'wpz_payments_nonce'); ?>

                                    <div class="wpz-payments-settings-title">
                                        <h3><?php esc_html_e('General Settings', 'wpz-payments'); ?></h3>
                                    </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Currency Symbol:</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">
                                            <input type="text" name="settings[general_currency_symbol]" value="<?php if ( isset($settings['general_currency_symbol']) ) {
                                                echo(esc_attr($settings['general_currency_symbol']));
                                            } ?>">
                                            <p class="wpz-payments-setting-description with-space">
                                                <?php esc_html_e('This is the currency symbol that will be used for displaying prices.', 'wpz-payments'); ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Currency Symbol Position:</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">

                                            <select name="settings[general_currency_symbol_position]">
                                                <?php foreach(
                                                    [
                                                        'before'       => __( 'Before Price', 'wpz-payments' ),
                                                        'before_space' => __( 'Before Price With Space', 'wpz-payments' ),
                                                        'after'        => __( 'After Price', 'wpz-payments' ),
                                                        'after_space'  => __( 'After Price With Space', 'wpz-payments' ),
                                                    ] as $option => $optionDisplay ) { ?>
                                                        <option value="<?php echo(esc_attr($option)); ?>"<?php selected($settings['general_currency_symbol_position'] == $option); ?>>
                                                            <?php echo(esc_html($optionDisplay)); ?>
                                                        </option>
                                                <?php } ?>
                                            </select>

                                            <p class="wpz-payments-setting-description with-space">
                                                <?php esc_html_e('Specify how you want the currency symbol to be shown when a price is displayed.', 'wpz-payments'); ?>
                                            </p>
                                        </div>
                                    </div>

                                    <hr class="wpz-payments-settings-sep">

                                    <div class="wpz-payments-settings-title">
                                        <h3><?php esc_html_e('Stripe', 'wpz-payments'); ?></h3>
                                    </div>

                                <div class="wpz-payments-settings-box wpz-payments-settings-box-columns has-checkbox">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Enable Stripe</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="checkbox" name="settings[stripe_enable]" value="1" <?php checked(! empty($settings['stripe_enable'])); ?>>
                                        <p class="wpz-payments-setting-description with space">
		                                    <?php esc_html_e('Check this box if you would like to use Stripe as the payment processor for one or more payment modules on your site. This will load the Stripe JS API on your site.', 'wpz-payments'); ?>
                                        </p>
                                    </div>
                                </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns has-checkbox">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Test mode</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">
                                            <input type="checkbox" name="settings[stripe_test]" value="1" <?php checked(! empty($settings['stripe_test'])); ?>>
                                            <p class="wpz-payments-setting-description with space">
                                                <?php
                                                printf(
                                                // translators: %s are link tags
                                                    esc_html__('Check this box if you want to enable Stripe\'s test mode - payments will not actually be processed. See %sStripe documentation%s for more information, such as card numbers that you can use for testing.', 'wpz-payments'),
                                                    '<a href="https://stripe.com/docs/testing" target="_blank">',
                                                    '</a>'
                                                );
                                                ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Live Publishable key:</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">
                                            <input type="password" name="settings[stripe_key_live]" value="<?php if ( isset($settings['stripe_key_live']) ) {
                                                echo(esc_attr(str_repeat('*', strlen($settings['stripe_key_live']))));
                                            } ?>">
                                            <p class="wpz-payments-setting-description with-space">
                                                <?php
                                                printf(
                                                // translators: %s are link tags
                                                    esc_html__('This value is from the %sAPI keys page in your Stripe dashboard%s (in live mode). This key is not needed while you are using test mode.', 'wpz-payments'),
                                                    '<a href="https://dashboard.stripe.com/apikeys" target="_blank">',
                                                    '</a>'
                                                );
                                                ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Live Secret key:</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">
                                            <input type="password" name="settings[stripe_secret_live]" value="<?php if ( isset($settings['stripe_secret_live']) ) {
                                                echo(esc_attr(str_repeat('*', strlen($settings['stripe_secret_live']))));
                                            } ?>">
                                            <p class="wpz-payments-setting-description with-space">
                                                <?php
                                                printf(
                                                // translators: %s are link tags
                                                    esc_html__('This value is from the %sAPI keys page in your Stripe dashboard%s (in live mode). This key is not needed while you are using test mode.', 'wpz-payments'),
                                                    '<a href="https://dashboard.stripe.com/apikeys" target="_blank">',
                                                    '</a>'
                                                );
                                                ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Test Publishable key:</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">
                                            <input type="password" name="settings[stripe_key_test]" value="<?php if ( isset($settings['stripe_key_test']) ) {
                                                echo(esc_attr(str_repeat('*', strlen($settings['stripe_key_test']))));
                                            } ?>">
                                            <p class="wpz-payments-setting-description with-space">
                                                <?php
                                                printf(
                                                // translators: %s are link tags
                                                    esc_html__('This value is from the %sAPI keys page in your Stripe dashboard%s (in test mode). This key is only needed if you are using test mode.', 'wpz-payments'),
                                                    '<a href="https://dashboard.stripe.com/test/apikeys" target="_blank">',
                                                    '</a>'
                                                );
                                                ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Test Secret key:</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">
                                            <input type="password" name="settings[stripe_secret_test]" value="<?php if ( isset($settings['stripe_secret_test']) ) {
                                                echo(esc_attr(str_repeat('*', strlen($settings['stripe_secret_test']))));
                                            } ?>">
                                            <p class="wpz-payments-setting-description with-space">
                                                <?php
                                                printf(
                                                // translators: %s are link tags
                                                    esc_html__('This value is from the %sAPI keys page in your Stripe dashboard%s (in test mode). This key is only needed if you are using test mode.', 'wpz-payments'),
                                                    '<a href="https://dashboard.stripe.com/test/apikeys" target="_blank">',
                                                    '</a>'
                                                );
                                                ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Webhook signing secret:</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">
                                            <input type="password" name="settings[stripe_webhook_secret]" value="<?php if ( isset($settings['stripe_webhook_secret']) ) {
                                                echo(esc_attr(str_repeat('*', strlen($settings['stripe_webhook_secret']))));
                                            } ?>">
                                            <p class="wpz-payments-setting-description with-space">
                                                <?php
                                                $webhookUrl = add_query_arg('wpz_payments_webhook', 'stripe', trailingslashit(home_url()));
                                                printf(
                                                // translators: %s are mostly link tags
                                                    esc_html__('Create a webhook in your Stripe dashboard (%2$shere%1$s for live mode, or %3$shere%1$s for test mode). For the webhook URL, set %4$s%1$s. The webhook should be set to listen to the following Charge events: charge.succeeded, charge.failed, charge.refunded, charge.refund.updated. After creating the webhook, you will have the option to reveal the signing secret - enter that value here.', 'wpz-payments'),
                                                    '</a>',
                                                    '<a href="https://dashboard.stripe.com/webhooks" target="_blank">',
                                                    '<a href="https://dashboard.stripe.com/test/webhooks" target="_blank">',
                                                    '<a href="'.esc_url($webhookUrl).'" target="_blank">'.esc_url($webhookUrl)
                                                );
                                                ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                        <div class="wpz-payments-settings-box-title">
                                            <label>Currency:</label>
                                        </div>
                                        <div class="wpz-payments-settings-box-content">
                                            <input type="text" name="settings[stripe_currency]" value="<?php if ( isset($settings['stripe_currency']) ) {
                                                echo(esc_attr($settings['stripe_currency']));
                                            } ?>">
                                            <p class="wpz-payments-setting-description with-space">
                                                <?php
                                                printf(
                                                // translators: %s are link tags
                                                    esc_html__('Enter a currency abbreviation (usually 3 or 4 letters) from Stripe\'s %ssupported currencies list%s.', 'wpz-payments'),
                                                    '<a href="https://stripe.com/docs/currencies" target="_blank">',
                                                    '</a>'
                                                );
                                                ?>
                                            </p>
                                        </div>
                                    </div>

								<hr class="wpz-payments-settings-sep">

                                <div class="wpz-payments-settings-title">
                                    <h3><?php esc_html_e('PayPal', 'wpz-payments'); ?></h3>
                                </div>

                                <div class="wpz-payments-settings-box wpz-payments-settings-box-columns has-checkbox">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Enable PayPal</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="checkbox" name="settings[paypal_enable]" value="1" <?php checked(! empty($settings['paypal_enable'])); ?>>
                                        <p class="wpz-payments-setting-description with space">
		                                    <?php esc_html_e('Check this box if you would like to use PayPal as the payment processor for one or more payment modules on your site. This will load the PayPal JavaScript SDK on your site.', 'wpz-payments'); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="wpz-payments-settings-box wpz-payments-settings-box-columns has-checkbox">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Test mode</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="checkbox" name="settings[paypal_test]" value="1" <?php checked(! empty($settings['paypal_test'])); ?>>
                                        <p class="wpz-payments-setting-description with space">
		                                    <?php esc_html_e('Check this box if you want to use the sandbox PayPal client ID.', 'wpz-payments'); ?>
                                        </p>
                                    </div>
                                </div>

								<?php
									// translators: first two %s are <a> </a> tags, third is Live/Sandbox
									$paypalClientIdInstructions = __('Go to the %sApps & Credentials%s page in the PayPal Developer Dashboard (in %s mode), click Create App and follow the on-screen prompts. Copy and paste the client ID shown after creating the app.', 'wpz-payments');
									// translators: first two %s are <a> </a> tags, third is Live/Sandbox, forth is <a></a>
									$paypalWebhookIdInstructions = __('On the %sApps & Credentials%s page in the PayPal Developer Dashboard (in %s mode), click on the app that matches the client ID entered above. In the Webhooks section, click Add Webhook. Enter the following URL: %s. Enable the "Checkout order approved" event and all events starting with "Payment capture". After submitting the form, copy the Webhook Id corresponding to the newly created webhook.', 'wpz-payments');
								?>


                                <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Live Client ID:</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="password" name="settings[paypal_client_id_live]" value="<?php if ( isset($settings['paypal_client_id_live']) ) {
					                        echo(esc_attr(str_repeat('*', strlen($settings['paypal_client_id_live']))));
				                        } ?>">
                                        <p class="wpz-payments-setting-description with-space">
											<?php
												printf(
													esc_html($paypalClientIdInstructions),
													'<a href="https://developer.paypal.com/dashboard/applications/live" target="_blank">',
													'</a>',
													esc_html_x('Live', 'paypal live or sandbox mode', 'wpz-payments')
												);
											?>
                                        </p>
                                    </div>
                                </div>

								<div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Live Webhook ID:</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="password" name="settings[paypal_webhook_id_live]" value="<?php if ( isset($settings['paypal_webhook_id_live']) ) {
					                        echo(esc_attr(str_repeat('*', strlen($settings['paypal_webhook_id_live']))));
				                        } ?>">
                                        <p class="wpz-payments-setting-description with-space">
		                                    <?php
		                                    $webhookUrl = add_query_arg('wpz_payments_webhook', 'paypal', trailingslashit(home_url()));
		                                    printf(
												esc_html($paypalWebhookIdInstructions),
			                                   '<a href="https://developer.paypal.com/dashboard/applications/live" target="_blank">',
												'</a>',
												esc_html_x('Live', 'paypal live or sandbox mode', 'wpz-payments'),
			                                    '<a href="'.esc_url($webhookUrl).'" target="_blank">'.esc_url($webhookUrl).'</a>'
		                                    );
		                                    ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Sandbox Client ID:</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="password" name="settings[paypal_client_id_test]" value="<?php if ( isset($settings['paypal_client_id_test']) ) {
					                        echo(esc_attr(str_repeat('*', strlen($settings['paypal_client_id_test']))));
				                        } ?>">
                                        <p class="wpz-payments-setting-description with-space">
											<?php
												printf(
													esc_html($paypalClientIdInstructions),
													'<a href="https://developer.paypal.com/dashboard/applications/sandbox" target="_blank">',
													'</a>',
													esc_html_x('Sandbox', 'paypal live or sandbox mode', 'wpz-payments')
												);
											?>
                                        </p>
                                    </div>
                                </div>

								<div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Sandbox Webhook ID:</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="password" name="settings[paypal_webhook_id_test]" value="<?php if ( isset($settings['paypal_webhook_id_test']) ) {
					                        echo(esc_attr(str_repeat('*', strlen($settings['paypal_webhook_id_test']))));
				                        } ?>">
                                        <p class="wpz-payments-setting-description with-space">
		                                    <?php
		                                    $webhookUrl = add_query_arg(['wpz_payments_webhook' => 'paypal', 'wpz_payments_test' => 1], trailingslashit(home_url()));
		                                    printf(
												esc_html($paypalWebhookIdInstructions),
			                                   '<a href="https://developer.paypal.com/dashboard/applications/sandbox" target="_blank">',
												'</a>',
												esc_html_x('Sandbox', 'paypal live or sandbox mode', 'wpz-payments'),
			                                    '<a href="'.esc_url($webhookUrl).'" target="_blank">'.esc_url($webhookUrl).'</a>'
		                                    );
		                                    ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Currency:</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="text" name="settings[paypal_currency]" value="<?php if ( isset($settings['paypal_currency']) ) {
					                        echo(esc_attr($settings['paypal_currency']));
				                        } ?>">
                                        <p class="wpz-payments-setting-description with-space">
		                                    <?php
		                                    printf(
		                                    // translators: %s are link tags
			                                    esc_html__('Enter a currency abbreviation (usually 3 letters) from PayPal\'s %ssupported currencies list%s.', 'wpz-payments'),
			                                    '<a href="https://developer.paypal.com/api/rest/reference/currency-codes/" target="_blank">',
			                                    '</a>'
		                                    );
		                                    ?>
                                        </p>
                                    </div>
                                </div>


                                <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Enabled Payment Sources:</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="text" name="settings[paypal_sources_enabled]" value="<?php if ( isset($settings['paypal_sources_enabled']) ) {
					                        echo(esc_attr($settings['paypal_sources_enabled']));
				                        } ?>">
                                        <p class="wpz-payments-setting-description with-space">
		                                    <?php
		                                    printf(
		                                    // translators: %s are link tags
			                                    esc_html__('One or more payment sources (comma-separated) to enable when loading the PayPal JavaScript SDK (optional). See the %sconfiguration documentation%s for details.', 'wpz-payments'),
			                                    '<a href="https://developer.paypal.com/sdk/js/configuration/#enable-funding" target="_blank">',
			                                    '</a>'
		                                    );
		                                    ?>
                                        </p>
                                    </div>
                                </div>


                                <div class="wpz-payments-settings-box wpz-payments-settings-box-columns">
                                    <div class="wpz-payments-settings-box-title">
                                        <label>Disabled Payment Sources:</label>
                                    </div>
                                    <div class="wpz-payments-settings-box-content">
                                        <input type="text" name="settings[paypal_sources_disabled]" value="<?php if ( isset($settings['paypal_sources_disabled']) ) {
					                        echo(esc_attr($settings['paypal_sources_disabled']));
				                        } ?>">
                                        <p class="wpz-payments-setting-description with-space">
											<?php
		                                    printf(
		                                    // translators: %s are link tags
			                                    esc_html__('One or more payment sources (comma-separated) to enable when loading the PayPal JavaScript SDK (optional). See the %sconfiguration documentation%s for details.', 'wpz-payments'),
			                                    '<a href="https://developer.paypal.com/sdk/js/configuration/#disable-funding" target="_blank">',
			                                    '</a>'
		                                    );
		                                    ?>
                                        </p>
                                    </div>
                                </div>

                                    <button class="wpz-payments-button-primary"><?php esc_html_e('Save Changes', 'wpz-payments'); ?></button>

                                    <p class="wpz-payments-footnote">
                                        <?php esc_html_e('Note: Saving these settings will cause all current Stripe payment intents to be cleared from the WordPress database and will result in payment failure for any subsequent payment attempts where the page was loaded before the settings were saved.', 'wpz-payments'); ?>
                                    </p>
                                </form>

                            </div>
                            <div id="wpz-payments-settings-about">
                                <p>
                                    <?php
                                    // translators: 1 and 2 are <a> tags
                                    echo sprintf( esc_html__( '%1$sWPZ Payments Free%2$s is an easy to use extension for the Divi Theme and Divi Plugin.', 'wpz-payments' ), '<a href="https://wpzone.co/product/simple-payment-module-for-divi/" target="_blank">', '</a>' );
                                    ?>
                                </p>
                                <hr class="wpz-payments-settings-sep">
                                <h4> <?php esc_html_e( 'About WPZ Payments Free', 'wpz-payments' ); ?> </h4>
                                <p>
                                    <?php esc_html_e( 'Allows to integrate with a payment processor to take payments without needing to run a full-fledged ecommerce platform like WooCommerce or EDD.', 'wpz-payments' );
                                    // translators: 1 and 2 are <a> tags
                                    echo sprintf( esc_html__( 'Learn more about WPZ Payments Free from %1$sour documentation article%2$s.', 'wpz-payments' ), '<a href="https://wpzone.co/docs/plugin/simple-payment-module-for-divi/" target="_blank">', '</a>' );
                                    ?>
                                </p>

                            </div>
                            <div id="wpz-payments-settings-addons">
                                <?php DS_Divi_Payment_Module_Addons::outputList(); ?>
                            </div>
                            <?php
                            
                        ?>

                        
                    </div>

                </div>
            </div>
            <?php
        }

        /**
         * Loads a plugin’s translated strings.
         * The .mo file should be named based on the text domain with a dash, and then the locale exactly.
         *
         * @since 1.0.0
         *
         */
        public static function load_text_domain() {
            load_plugin_textdomain( 'wpz-payments', false, self::$plugin_directory . 'languages' );
        }


        /**
         * Add settings link on plugins page
         *
         * @since 1.0.0
         *
         */
        public static function plugin_action_links() {
            add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
                array_unshift( $links, '<a href="admin.php?page=wpz-payments-settings">' . esc_html__( 'Settings', 'wpz-payments' ) . '</a>' );

                return $links;
            } );
        }

        static function onPluginActivate() {
            $roles = wp_roles();
            foreach (get_post_type_capabilities((object) ['capability_type' => 'wpz-payment', 'map_meta_cap' => true, 'capabilities' => []]) as $capability) {
                $roles->add_cap('administrator', $capability);
            }
        }

        static function getPaymentIdByTransactionId($paymentMethod, $transactionId) {
            $result = get_posts([
                'post_type' => 'wpz-payment',
                'posts_per_page' => 1,
                'fields' => 'ids',
                'post_status' => 'any',
                'ignore_sticky_posts' => true,
                'orderby' => 'none',
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => '_payment_method',
                        'value' => $paymentMethod
                    ],
                    [
                        'key' => '_transaction_id',
                        'value' => $transactionId
                    ]
                ]
            ]);

            return $result ? current($result) : 0;
        }

    }
WPZ_Payments::setup();
register_activation_hook(__FILE__, ['WPZ_Payments', 'onPluginActivate']);
