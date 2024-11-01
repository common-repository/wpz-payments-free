<?php
class WPZ_Payments_PayPal {
	
	const	JS_BASE_URL = 'https://www.paypal.com/sdk/js';
	
	private $settings, $debugLog;
	
	function __construct() {
		$this->settings = get_option('wpz_payments_settings', []);
	}
	
	function getTransactionUrl($transactionId) {
		return sprintf(
			empty($this->settings['stripe_test'])
			? 'https://paypal.com/activity/payment/%s'
			: 'https://sandbox.paypal.com/activity/payment/%s',
			rawurlencode($transactionId)
		);
	}
	
	function getJsUrl() {
		$args = [
			'client-id' => rawurlencode($this->settings['paypal_client_id_'.(empty($this->settings['paypal_test']) ? 'live' : 'test')])
		];
		if (!empty($this->settings['paypal_currency'])) {
			$args['currency'] = rawurlencode($this->settings['paypal_currency']);
		}
		if (!empty($this->settings['paypal_sources_enabled'])) {
			$args['enable-funding'] = rawurlencode(implode(',', array_map('trim', explode(',', $this->settings['paypal_sources_enabled']))));
		}
		if (!empty($this->settings['paypal_sources_disabled'])) {
			$args['disable-funding'] = rawurlencode(implode(',', array_map('trim', explode(',', $this->settings['paypal_sources_disabled']))));
		}
		
		return add_query_arg(
			$args,
			self::JS_BASE_URL
		);
	}
	
	function processPayment($transactionId, $sourcePostId, $notes) {
		$paymentId = wp_insert_post([
			'post_type' => 'wpz-payment',
			'post_status' => 'wpz-payment-draft',
			'post_content' => empty($notes) ? '' : $notes
		]);
		
		if (!$paymentId) {
			throw new Exception();
		}
		
		wp_update_post([
			'ID' => $paymentId,
			// translators: payment title (%d is payment ID)
			'post_title' => sprintf( __('Payment #%d', 'wpz-payments'), $paymentId )
		]);
		
		update_post_meta($paymentId, '_payment_method', 'paypal');
		
		if (!empty($sourcePostId)) {
			update_post_meta($paymentId, '_source_id', (int) $sourcePostId);
		}
		
		if (!empty($transactionId)) {
			update_post_meta($paymentId, '_transaction_id', $transactionId);
		}
	}
	
	function processWebhook($submittedData) {
		
		// Validate webhook signature
		
		$this->maybeDebugLog('PayPal webhook processing start');
		
		$headers = [];
		foreach (getallheaders() as $headerKey => $header) {
			$headers[strtolower($headerKey)] = $header;
		}

		if (empty($headers['paypal-cert-url']) || empty($headers['paypal-auth-algo'])) {
			$this->maybeDebugLog('PayPal webhook validation failed: missing certificate host or algorithm');;
			status_header(401);
			exit;
		}
		
		$validationCertHost = strtolower(wp_parse_url($headers['paypal-cert-url'], PHP_URL_HOST));
		if ($validationCertHost !== 'paypal.com' && substr($validationCertHost, -11) !== '.paypal.com') {
			$this->maybeDebugLog('PayPal webhook validation failed: invalid certificate host '.$validationCertHost);
			status_header(401);
			exit;
		}

		if ($headers['paypal-auth-algo'] !== 'SHA256withRSA') {
			$this->maybeDebugLog('PayPal webhook validation failed: invalid algorithm '.$headers['paypal-auth-algo']);
			status_header(401);
			exit;
		}
		
		$validationCert = wp_remote_get($headers['paypal-cert-url']);
		
		if (!$validationCert || is_wp_error($validationCert)) {
			$this->maybeDebugLog('PayPal webhook validation failed: unable to fetch certificate from '.$headers['paypal-cert-url']);
			status_header(401);
			exit;
		}
		
		$validationCert = wp_remote_retrieve_body($validationCert);
		
		if (!$validationCert) {
			$this->maybeDebugLog('PayPal webhook validation failed: unable to fetch certificate from '.$headers['paypal-cert-url']);
			status_header(401);
			exit;
		}

		$this->maybeDebugLog('PayPal webhook validation: successfully fetched certificate');

		if (!function_exists('openssl_verify')) {
			$this->maybeDebugLog('PayPal webhook validation failed: missing OpenSSL');
			status_header(500);
			exit;
		}
		
		$validationString = $headers['paypal-transmission-id']
								.'|'.$headers['paypal-transmission-time']
								// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- CSRF not a concern here since we will be processing a signed payload
								.'|'.$this->settings['paypal_webhook_id_'.(empty($_GET['wpz_payments_test']) ? 'live' : 'test')]
								.'|'.crc32($submittedData);
		
		if (openssl_verify($validationString, base64_decode($headers['paypal-transmission-sig']), $validationCert, OPENSSL_ALGO_SHA256) !== 1) {
			$this->maybeDebugLog('PayPal webhook validation failed: signature check failure');
			status_header(401);
			exit;
		}
		
		$this->maybeDebugLog('PayPal webhook validation succeeded');
		
		$submittedData = @json_decode($submittedData, true);
		
		if (empty($submittedData['event_type'])) {
			status_header(400);
			exit;
		}
		
		switch ($submittedData['event_type']) {
			case 'CHECKOUT.ORDER.APPROVED':
				status_header(empty($submittedData['resource']) ? 400 : $this->updateOrderFromWebhook($submittedData['resource']));
				exit;
			case 'PAYMENT.CAPTURE.COMPLETED':
				status_header(empty($submittedData['resource']['id']) ? 400 : $this->processWebhookStatusChange(sanitize_text_field($submittedData['resource']['id']), 'wpz-payment-paid'));
				exit;
			case 'PAYMENT.CAPTURE.DENIED':
				status_header(empty($submittedData['resource']['id']) ? 400 : $this->processWebhookStatusChange(sanitize_text_field($submittedData['resource']['id']), 'wpz-payment-failed'));
				exit;
			case 'PAYMENT.CAPTURE.PENDING':
				status_header(empty($submittedData['resource']['id']) ? 400 : $this->processWebhookStatusChange(sanitize_text_field($submittedData['resource']['id']), 'wpz-payment-process'));
				exit;
			case 'PAYMENT.CAPTURE.REFUNDED':
				if (!empty($submittedData['resource']['links'])) {
					
					foreach ($submittedData['resource']['links'] as $link) {
						if ($link['rel'] == 'up' && !empty($link['href'])) {
							$lastSlash = strrpos($link['href'], '/');
							if ($lastSlash !== false) {
								status_header($this->processWebhookStatusChange(sanitize_text_field(substr($link['href'], $lastSlash + 1)), 'wpz-payment-refunded'));
								exit;
							}
							break;
						}
					}
				}
				
				status_header(400);
				exit;
			case 'PAYMENT.CAPTURE.REVERSED':
				status_header(empty($submittedData['resource']['id']) ? 400 : $this->processWebhookStatusChange(sanitize_text_field($submittedData['resource']['id']), 'wpz-payment-refunded'));
				exit;
		}
		
		exit;
		
	}
	
	private function updateOrderFromWebhook($resource) {
		if (!isset($resource['purchase_units'][0]['payments']['captures'][0]['id'])) {
			return 200; // payment ID could not be found in the webhook data; assume this is not a payment from the module
		}
		
		$transactionId = sanitize_text_field($resource['purchase_units'][0]['payments']['captures'][0]['id']);
		
		$paymentId = WPZ_Payments::getPaymentIdByTransactionId('paypal', $transactionId);
		
		if (!$paymentId) {
			return 200; // payment ID could not be found; assume this is not a payment from the module
		}
		
		$sourceId = get_post_meta($paymentId, '_source_id', true);
		
		if ( !isset($resource['purchase_units'][0]['amount']['value']) || !isset($resource['purchase_units'][0]['items'][0]['name'])
				|| !isset($resource['purchase_units'][0]['items'][0]['quantity'])
				|| count($resource['purchase_units']) != 1 || count($resource['purchase_units'][0]['items']) != 1 ) {
			return 400;
		}
		
		$totalAmount = (float) $resource['purchase_units'][0]['amount']['value'];
		$quantity = (int) $resource['purchase_units'][0]['items'][0]['quantity'];
		$productName = sanitize_text_field($resource['purchase_units'][0]['items'][0]['name']);
		$originalQuantity = $quantity;
		
		$status = get_post_meta($paymentId, '_pending_status', true);
		if ($status) {
			delete_post_meta($paymentId, '_pending_status');
		} else {
			$status = 'wpz-payment-process';
		}
		
		$isValid = false;
		while (!$isValid && $quantity >= 1) {
			try {
				$isValid = WPZ_Payments::validatePayment(
					(int) $sourceId,
					$productName,
					$totalAmount,
					(float) $quantity
				);
			} catch (Exception $ex) {
				if (!isset($validationError)) {
					$validationError = $ex->getMessage();
				}
			}
			if (!$isValid) {
				$quantity /= 10;
			}
		}
		
		if ($isValid) {
			if ( !isset($resource['purchase_units'][0]['amount']['breakdown']['item_total']['value']) ) {
				$isValid = false;
				$validationError = __('Missing breakdown item total amount', 'wpz-payments');
			} else if ( $resource['purchase_units'][0]['amount']['breakdown']['item_total']['value'] != $totalAmount ) {
				$isValid = false;
				$validationError = sprintf( __('Incorrect breakdown item total amount: %s, expected: %f', 'wpz-payments'), sanitize_text_field($resource['purchase_units'][0]['amount']['breakdown']['item_total']['value']), $totalAmount );
			} else if ( !isset($resource['purchase_units'][0]['items'][0]['unit_amount']['value']) ) {
				$isValid = false;
				$validationError = __('Missing item unit amount', 'wpz-payments');
			} else if ( $resource['purchase_units'][0]['items'][0]['unit_amount']['value'] != $totalAmount / $originalQuantity ) {
				$isValid = false;
				$validationError = sprintf( __('Incorrect item unit amount: %s, expected: %f', 'wpz-payments'), sanitize_text_field($resource['purchase_units'][0]['items'][0]['unit_amount']['value']), $totalAmount / $originalQuantity );
			} else if ( !isset($resource['purchase_units'][0]['amount']['currency_code']) ) {
				$isValid = false;
				$validationError = __('Missing total amount currency', 'wpz-payments');
			} else if ( strcasecmp($resource['purchase_units'][0]['amount']['currency_code'], $this->settings['paypal_currency']) ) {
				$isValid = false;
				$validationError = sprintf( __('Incorrect total amount currency: %s, expected: %s', 'wpz-payments'), sanitize_text_field($resource['purchase_units'][0]['amount']['currency_code']), $this->settings['paypal_currency'] );
			} else if ( !isset($resource['purchase_units'][0]['amount']['breakdown']['item_total']['currency_code']) ) {
				$isValid = false;
				$validationError = __('Missing breakdown item total currency', 'wpz-payments');
			} else if ( strcasecmp($resource['purchase_units'][0]['amount']['breakdown']['item_total']['currency_code'], $this->settings['paypal_currency']) ) {
				$isValid = false;
				$validationError = sprintf( __('Incorrect breakdown item total currency: %s, expected: %s', 'wpz-payments'), sanitize_text_field($resource['purchase_units'][0]['amount']['currency_code']), $this->settings['paypal_currency'] );
			} else if ( !isset($resource['purchase_units'][0]['items'][0]['unit_amount']['currency_code']) ) {
				$isValid = false;
				$validationError = __('Missing item unit currency', 'wpz-payments');
			} else if ( strcasecmp($resource['purchase_units'][0]['items'][0]['unit_amount']['currency_code'], $this->settings['paypal_currency']) ) {
				$isValid = false;
				$validationError = sprintf( __('Incorrect item unit currency: %s, expected: %s', 'wpz-payments'), sanitize_text_field($resource['purchase_units'][0]['amount']['currency_code']), $this->settings['paypal_currency'] );
			}
		}
		
		if (!$isValid) {
			$status = 'wpz-payment-invalid';
			$quantity = $originalQuantity;
		}
		
		wp_update_post([
			'ID' => $paymentId,
			'post_status' => $status
		]);
		
		
		update_post_meta($paymentId, '_total', $totalAmount);
		if (isset($resource['purchase_units'][0]['amount']['currency_code'])) {
			update_post_meta($paymentId, '_currency', sanitize_text_field($resource['purchase_units'][0]['amount']['currency_code']));
		} else {
			delete_post_meta($paymentId, '_currency');
		}
		update_post_meta($paymentId, '_description', $productName);
		update_post_meta($paymentId, '_quantity', $quantity);
		
		if ($status == 'wpz-payment-invalid') {
		
			$paymentError = null;
			if ( isset($validationError) ) {
				$paymentError = $validationError;
			}
			
			if ($paymentError) {
				update_post_meta($paymentId, '_payment_error', $paymentError);
			}
		
		}
		
	}
	
	private function processWebhookStatusChange($transactionId, $newStatus, $failureMessage=null) {
		$paymentId = WPZ_Payments::getPaymentIdByTransactionId('paypal', $transactionId);
		
		if (!$paymentId) {
			return 200; // payment ID could not be found; assume this is not a payment from the module
		}
		
		$paymentStatus = get_post_status($paymentId);
		
		if ($paymentStatus == 'wpz-payment-invalid') {
			return 200;
		}
		
		if ($paymentStatus == 'wpz-payment-draft') {
			update_post_meta($paymentId, '_pending_status', $newStatus);
		} else {
			if (wp_update_post([
					'ID' => $paymentId,
					'post_status' => $newStatus
				]) !== (int) $paymentId) {
					return 500;
			}
		}
		
		
		if ($failureMessage) {
			update_post_meta($paymentPost->ID, '_payment_error', $failureMessage);
		}
		
		return 200;
	}

	private function maybeDebugLog($message) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- just checking a debug flag, not a CSRF concern
		if (!empty($_GET['wpz_payments_debug'])) {
			if (empty($this->debugLog)) {
				$this->debugLog = get_option('wpz_payments_debug_log');
				if (!$this->debugLog) {
					$this->debugLog = sanitize_key(base64_encode(random_bytes(16)));
					update_option('wpz_payments_debug_log', $this->debugLog, false);
				}
			}
			
			file_put_contents(WPZ_Payments::$plugin_directory.'debug-'.$this->debugLog.'.txt', gmdate('c')."\t".$message."\n", FILE_APPEND);
		}
	}
	
	
	
}