<?php
/* include config and basic data */
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/notification.php';

/* include classes */
require_once __DIR__ . '/class/HTTP.php';
require_once __DIR__ . '/class/Validation.php';
require_once __DIR__ . '/class/Notification.php';
require_once __DIR__ . '/class/ApiUrl.php';
require_once __DIR__ . '/class/Auth.php';
require_once __DIR__ . '/class/Collection.php';
require_once __DIR__ . '/class/Item.php';
require_once __DIR__ . '/class/Directus.php';

if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
	require_once __DIR__ . '/inc/request-get.php';
}
elseif( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
//	$user = $auth->login(API_USER, API_PASSWORD);


}
elseif( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
//	$user = $auth->login(API_USER, API_PASSWORD);
}
elseif( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
//	$user = $auth->login(API_USER, API_PASSWORD);
}


//$user_data = $auth->login("admin@example.com", "d1r3ctu5");
////$login_url = $url->url('/auth/login');
////$login_data = array(
////	"email"    => "admin@example.com",
////	"password" => "d1r3ctu5"
////);
////$res = $http->post($login_url, $login_data);
//
//$json = $user_data;//json_decode($user_data);
//print '<pre>';
//print_r($json);
//print '</pre>';
