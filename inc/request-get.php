<?php
/* Init namespaces */
use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\Auth\Auth;
use JPNS\Directus\Directus\Directus;
use JPNS\Directus\User\User;

/* Init basic classes */
$http         = new HTTP();
$validation   = new Validation();
$notification = new Notification();
$url          = new ApiUrl();
$auth         = new Auth();


/* Get user access token */
$session = $auth->get_api_user();
$user    = $auth->get_user($session);
$token   = $user['token'];

/* Collect request data to $data array */
$data = [];
if( isset($_GET['method']) && ! empty($_GET['method']) ) {
	$data['method'] = trim($_GET['method']);
}
if( isset($_GET['action']) && ! empty($_GET['action']) ) {
	$data['action'] = trim($_GET['action']);
}
if( isset($_GET['collection']) && ! empty($_GET['collection']) ) {
	$data['collection'] = trim($_GET['collection']);
}
if( isset($_GET['id']) && ! empty($_GET['id']) ) {
	$data['id'] = trim($_GET['id']);
}
if( isset($_GET['token']) && ! empty($_GET['token']) ) {
	$data['token'] = trim($_GET['token']);
}
if( isset($_GET['aggregate']) && ! empty($_GET['aggregate']) ) {
	$data['aggregate'] = trim($_GET['aggregate']);
}
if( isset($_GET['filter']) && ! empty($_GET['filter']) ) {
	$data['filter'] = trim($_GET['filter']);
}

/* Init Directus class and request result data */
$directus = new Directus($data['action'], $token, $user);
$result   = $directus->request($data);

//print_r($result);
echo json_encode($result);

//var_dump($directus);
//exit();