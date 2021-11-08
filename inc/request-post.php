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

/* Collect request data to $data array */
$result = [];
$data = [];
if( isset($_POST['method']) && ! empty($_POST['method']) ) {
	$data['method'] = trim($_POST['method']);
}
if( isset($_POST['action']) && ! empty($_POST['action']) ) {
	$data['action'] = trim($_POST['action']);
}
if( isset($_POST['collection']) && ! empty($_POST['collection']) ) {
	$data['collection'] = trim($_POST['collection']);
}
if( isset($_POST['payload']) && ! empty($_POST['payload']) ) {
	$data['payload'] = trim($_POST['payload']);
}
if( isset($_POST['token']) && ! empty($_POST['token']) ) {
	$data['token'] = trim($_POST['token']);
}

if($data['action'] === 'auth') {
	/* Login user */
	$result = $auth->request($data);
}
else {
	/* Get user access token */
	if( isset($data['token']) ) {
		$session = [
			'session' => $data['token']
		];
	}
	else {
		$session = $auth->get_api_user();
	}
	$user    = $auth->get_user($session);
	$token   = $user['token'];

	/* Init Directus class and request result data */
	$directus = new Directus($data['action'], $token, $user);
	$result   = $directus->request($data);
}

//print_r($result);
echo json_encode($result);

//var_dump($directus);
//exit();