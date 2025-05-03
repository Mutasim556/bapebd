<?php

// SSLCommerz configuration

$apiDomain = env('SSLCZ_TESTMODE',true) ? "https://sandbox.sslcommerz.com" : "https://securepay.sslcommerz.com";
// $apiDomain = true;
return [
	'apiCredentials' => [
		'store_id' => 'sumit61cf0d05988e9',
		'store_password' =>'sumit61cf0d05988e9@ssl',
	],
	'apiUrl' => [
		'make_payment' => "/gwprocess/v4/api.php",
		'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
		'order_validate' => "/validator/api/validationserverAPI.php",
		'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
		'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
	],
	'apiDomain' => $apiDomain,
	'connect_from_localhost' => true, // For Sandbox, use "true", For Live, use "false"
	'success_url' => '/success',
	'failed_url' => '/fail',
	'cancel_url' => '/cancel',
	'ipn_url' => '/ipn',
];
