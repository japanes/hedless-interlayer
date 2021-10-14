<?php
/* Init namespaces */
use JPNS\Basic\http\HTTP;
use JPNS\Basic\Validation\Validation;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\Auth\Auth;
use JPNS\Directus\Directus\Directus;

/* Init basic classes */
$http         = new HTTP();
$validation   = new Validation();
$notification = new Notification();
$url          = new ApiUrl();
$auth         = new Auth();

/* Get user access token */
$user = $auth->get_api_user();
$token = $auth->get_token($user['token']);

//var_dump($user);
//var_dump($token);
//exit();

/* Collect request data to $data array */
$data = [];
if( isset($_GET['method']) && ! empty($_GET['method']) ) {
	$data['method'] = trim($_GET['method']);
}
if( isset($_GET['entity']) && ! empty($_GET['entity']) ) {
	$data['entity'] = trim($_GET['entity']);
}
if( isset($_GET['collection']) && ! empty($_GET['collection']) ) {
	$data['collection'] = trim($_GET['collection']);
}
if( isset($_GET['id']) && ! empty($_GET['id']) ) {
	$data['id'] = trim($_GET['id']);
}

/* Init Directus class and request result data */
$directus = new Directus($data['entity'], $token);
$result   = $directus->request($data);

//print_r($result);
echo json_encode($result);

//var_dump($directus);
//exit();