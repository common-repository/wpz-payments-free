<?php
class WPZ_Payments_Stripe {
	
	const	API_URL = 'https://api.stripe.com/v1',
			ZERO_DECIMAL_CURRENCIES = ['BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF'];
	
	private $settings, $createdPaymentIntentId;
	
	function __construct() {
		$this->settings = get_option('wpz_payments_settings', []);
	}
	
	function getInitData() {
		$publicKey = ( empty($this->settings['stripe_test']) ? $this->settings['stripe_key_live'] :  $this->settings['stripe_key_test'] );
		
		if ($publicKey) {
			$data = [
				'publicKey' => $publicKey
			];
			
			try {
				$data['intent'] = $this->getSessionPaymentIntent();
			} catch (Exception $ex) {
				if (current_user_can('manage_options')) {
					$data['initErrorMessage'] = $ex->getMessage();
				}
			}
			
			return $data;
		}
		
		return [
			'initErrorMessage' => __('A Stripe publishable key was not provided in the plugin settings.', 'wpz-payments')
		];
	}
	
	function getSessionPaymentIntent() {
		$sessionId = wp_get_session_token();
		$stripeIntent = get_transient( 'wpz_payments_stripe_intent_'.$sessionId );
		if (empty($stripeIntent)) {
			$stripeIntent = $this->createPaymentIntent();
		}
		set_transient('wpz_payments_stripe_intent_'.$sessionId, $stripeIntent, 86400 * 2);
		return $stripeIntent;
	}
	
	function clearSessionPaymentIntent() {
		$sessionId = wp_get_session_token();
		delete_transient( 'wpz_payments_stripe_intent_'.$sessionId );
	}
	
	static function clearAllSessionPaymentIntents() {
		global $wpdb;
		$wpdb->query('DELETE FROM '.$wpdb->options.' WHERE option_name LIKE "_transient_wpz_payments_stripe_intent%" OR option_name LIKE "_transient_timeout_wpz_payments_stripe_intent%"');
	}
	
	function updateSessionPaymentIntent($paymentIntentId, $args, $retry=true) {
		$updates = [];
		
		$paymentIntentSecret = $this->getSessionPaymentIntent();
		
		$intent = $this->callApiMethod('payment_intents/'.$paymentIntentId, 'GET');
		
		if (empty($intent['client_secret']) || $intent['client_secret'] !== $paymentIntentSecret) {
			$this->clearSessionPaymentIntent();
			if ($retry) {
				$this->getSessionPaymentIntent();
				return $this->updateSessionPaymentIntent($this->createdPaymentIntentId, $args, false);
			} else {
				throw new Exception();
			}
		}
		
		if (!isset($args['amount'])) {
			throw new Exception();
		}
		
		$updates['amount'] = (int) ( $args['amount'] * ( in_array(strtoupper($this->settings['stripe_currency']), self::ZERO_DECIMAL_CURRENCIES) ? 1 : 100 ) );
		
		$updates['description'] = isset($args['description']) ? sanitize_text_field( $args['description'] ) : '';
		
		$updates['metadata'] = [
			'notes' => isset($args['notes']) ? sanitize_textarea_field( $args['notes'] ) : '',
			'quantity' => isset($args['quantity']) ? (float) $args['quantity'] : 1,
			'sourceId' => isset($args['sourceId']) ? (int) $args['sourceId'] : 0
		];
		
		if (isset($args['statementDescriptor'])) {
			$statementDescriptor = substr( sanitize_text_field( $args['statementDescriptor'] ), 0, 22 );
			$updates['statement_descriptor'] = $statementDescriptor;
			$updates['statement_descriptor_suffix'] = $statementDescriptor;
		}
		
		$intent = $this->callApiMethod('payment_intents/'.$paymentIntentId, 'POST', $updates);
		
		if (empty($intent['id'])) {
			$this->clearSessionPaymentIntent();
			if ($retry) {
				$this->getSessionPaymentIntent();
				return $this->updateSessionPaymentIntent($this->createdPaymentIntentId, $args, false);
			} else {
				throw new Exception(isset($intent['error']['message']) ? $intent['error']['message'] : null);
			}
		}
		
		return $paymentIntentId;
	}
	
	function createPaymentIntent() {
		$this->createdPaymentIntentId = null;
		
		// Default amount must be above the minimum charge amount for any currency - see https://stripe.com/docs/currencies#minimum-and-maximum-charge-amounts
		$intent = $this->callApiMethod('payment_intents', 'POST', ['amount' => 20000, 'currency' => $this->settings['stripe_currency']]);
		if (empty($intent['client_secret']) || empty($intent['id'])) {
			throw new Exception( isset($intent['error']['message']) ? $intent['error']['message'] : __('Payment intent creation error', 'wpz-payments') );
		}
		$this->createdPaymentIntentId = $intent['id'];
		return $intent['client_secret'];
	}
	
	function callApiMethod($method, $requestType='POST', $args=[]) {
		$headers = [
			'Authorization' => 'Bearer '.( empty($this->settings['stripe_test']) ? $this->settings['stripe_secret_live'] :  $this->settings['stripe_secret_test'] )
		];
		
		$requestParams = [
			'method' => $requestType,
			'timeout' => 30,
			'headers' => $headers
		];
		
		$url = self::API_URL.'/'.$method;
		if ($requestType != 'GET') {
			$requestParams['body'] = $args;
		} else if ($args) {
			$url = add_query_args($args, $url);
		}
		
		$response = wp_remote_request($url, $requestParams);
		
		if (is_wp_error($response)) {
			throw new Exception();
		}
		
		$response = @json_decode(wp_remote_retrieve_body($response), true);
		
		if (!$response) {
			throw new Exception();
		}
		
		return $response;
	}
	
	function processPayment($paymentIntentId, $paymentIntentSecret) {
		$intent = $this->callApiMethod('payment_intents/'.$paymentIntentId, 'GET');
		
		if (empty($intent['id'])) {
			throw new Exception();
		}
		
		if ($intent['client_secret'] !== $paymentIntentSecret) {
			throw new Exception();
		}
		
		$amount = (float) ( $intent['amount'] / (in_array(strtoupper($intent['currency']), self::ZERO_DECIMAL_CURRENCIES) ? 1 : 100) );
		
		switch ($intent['status']) {
			case 'succeeded':
				$status = 'wpz-payment-paid';
				break;
			case 'processing':
				$status = 'wpz-payment-process';
				break;
			default:
				$status = 'wpz-payment-failed';
		}
		
		if ($status != 'wpz-payment-failed') {
			$isValid = false;
			try {
				$isValid = WPZ_Payments::validatePayment(
					(int) $intent['metadata']['sourceId'],
					sanitize_text_field($intent['description']),
					$amount,
					isset($intent['metadata']['quantity']) ? (float) $intent['metadata']['quantity'] : 1
				);
			} catch (Exception $ex) {
				$validationError = $ex->getMessage();
			}
			
			if (!$isValid) {
				$status = 'wpz-payment-invalid';
			}
		}
		
		$paymentId = wp_insert_post([
			'post_type' => 'wpz-payment',
			'post_status' => $status,
			'post_content' => isset($intent['metadata']['notes']) ? $intent['metadata']['notes'] : ''
		]);
		
		if (!$paymentId) {
			throw new Exception();
		}
		
		wp_update_post([
			'ID' => $paymentId,
			// translators: payment title (%d is payment ID)
			'post_title' => sprintf( __('Payment #%d', 'wpz-payments'), $paymentId )
		]);
		
		update_post_meta($paymentId, '_payment_method', 'stripe');
		update_post_meta($paymentId, '_total', $amount);
		update_post_meta($paymentId, '_currency', $intent['currency']);
		update_post_meta($paymentId, '_description', sanitize_text_field($intent['description']));
		
		if (isset($intent['metadata']['quantity'])) {
			update_post_meta($paymentId, '_quantity', (float) $intent['metadata']['quantity']);
		}
		
		if (isset($intent['metadata']['sourceId'])) {
			update_post_meta($paymentId, '_source_id', (int) $intent['metadata']['sourceId']);
		}
		
		
		if (isset($intent['latest_charge'])) {
			update_post_meta($paymentId, '_transaction_id', sanitize_text_field($intent['latest_charge']));
		}
		
		if ($status == 'wpz-payment-failed' || $status == 'wpz-payment-invalid') {
		
			$paymentError = null;
			if ( isset($validationError) ) {
				$paymentError = $validationError;
			} else if (!empty($intent['last_payment_error']['message'])) {
				$paymentError = sanitize_text_field($intent['last_payment_error']['message']);
			}
			
			if ($paymentError) {
				update_post_meta($paymentId, '_payment_error', $paymentError);
			}
			
			throw new Exception(isset($validationError) ? __('Payment validation error', 'wpz-payments') : $paymentError);
		
		}
	}
	
	function getTransactionUrl($transactionId) {
		return sprintf(
			empty($this->settings['stripe_test'])
			? 'https://dashboard.stripe.com/payments/%s'
			: 'https://dashboard.stripe.com/test/payments/%s',
			rawurlencode($transactionId)
		);
	}
	
	function processWebhook($submittedData) {
		
		$headers = getallheaders();
		
		if (empty($headers['Stripe-Signature']) || empty($this->settings['stripe_webhook_secret'])) {
			status_header(401);
			exit;
		}
		
		$signatureParts = explode(',', $headers['Stripe-Signature']);
		foreach ($signatureParts as $part) {
			if (substr($part, 0, 2) == 't=') {
				$timestamp = substr($part, 2);
			} else if (substr($part, 0, 3) == 'v1=') {
				$signature = substr($part, 3);
			}
		}
		
		if (empty($timestamp) || empty($signature)) {
			status_header(401);
			exit;
		}
		
		$expectedSignature = hash_hmac('sha256', $timestamp.'.'.$submittedData, $this->settings['stripe_webhook_secret']);
		
		if ($signature !== $expectedSignature || absint(time() - $timestamp) > 60) {
			status_header(401);
			exit;
		}
		
		$submittedData = @json_decode($submittedData, true);
		
		if (empty($submittedData['type'])) {
			status_header(400);
			exit;
		}
		
		switch ($submittedData['type']) {
			case 'charge.succeeded':
				status_header(empty($submittedData['data']['object']['id']) ? 400 : $this->processWebhookStatusChange(sanitize_text_field($submittedData['data']['object']['id']), 'wpz-payment-paid'));
				exit;
			case 'charge.refunded':
				if (!empty($submittedData['data']['object']['id']) && isset($submittedData['data']['object']['status'])) {
					status_header( $submittedData['data']['object']['status'] == 'succeeded' ? $this->processWebhookStatusChange(sanitize_text_field($submittedData['data']['object']['id']), 'wpz-payment-refunded') : 200 );
					exit;
				}
				status_header(400);
				exit;
			case 'charge.refund.updated':
				if (!empty($submittedData['data']['object']['id']) && isset($submittedData['data']['object']['status'])) {
					switch ($submittedData['data']['object']['status']) {
						case 'succeeded':
							status_header( $this->processWebhookStatusChange(sanitize_text_field($submittedData['data']['object']['id']), 'wpz-payment-refunded') );
							exit;
						case 'failed':
							$paymentId = WPZ_Payments::getPaymentIdByTransactionId('stripe', sanitize_text_field($submittedData['data']['object']['id']));
							if ($paymentId && get_post_status($paymentId) == 'wpz-payment-refunded') {
								status_header( $this->processWebhookStatusChange(sanitize_text_field($submittedData['data']['object']['id']), 'wpz-payment-paid') );
								exit;
							}
					}
					status_header( 200 );
					exit;
				}
				status_header(400);
				exit;
			case 'charge.failed':
				status_header(empty($submittedData['data']['object']['id']) ? 400 : $this->processWebhookStatusChange(sanitize_text_field($submittedData['data']['object']['id']), 'wpz-payment-failed', empty($submittedData['data']['object']['failure_message']) ? null : sanitize_text_field($submittedData['data']['object']['failure_message'])));
				exit;
		}
		
		exit;
		
	}
	
	private function processWebhookStatusChange($transactionId, $newStatus, $failureMessage=null) {
		$paymentId = WPZ_Payments::getPaymentIdByTransactionId('stripe', $transactionId);
		
		if (!$paymentId || get_post_status($paymentId) == 'wpz-payment-invalid') {
			return 200; // payment ID could not be found; assume this is not a payment from the module
		}
		
		
		if (wp_update_post([
				'ID' => $paymentId,
				'post_status' => $newStatus
			]) !== (int) $paymentId) {
				return 500;
		}
		
		if ($failureMessage) {
			update_post_meta($paymentPost->ID, '_payment_error', $failureMessage);
		}
		
		return 200;
	}
	
	
	
}
