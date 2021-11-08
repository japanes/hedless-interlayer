<?php
namespace JPNS\Directus\Auth;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\User\User;
use JPNS\Directus\Role\Role;

/**
 * Methods of this class returns directus's auth token for user
 */
class Auth {
	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;
	public $User;
	public $Role;

	function __construct() {
		$this->HTTP = new HTTP();
		$this->Validation = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl = new ApiUrl();
		$this->User = new User();
		$this->Role = new Role();
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function login($login, $password, $api_user=false) {
		$url = $this->ApiUrl->url('/auth/login');

		/* TODO. Validation */
		$login_data = [
			"email"    => $login,
			"password" => $password
		];

		/* Get user data */
		$raw_data = $this->HTTP->post($url, $login_data);
		$data = $this->Validation->output($raw_data);

		/* TODO. Errors handler */

		$is_error = false;
		if($is_error) {
			$response = ['error'];
		}
		else {
			$response = $this->set_user_data($data, $api_user);
		}

		return $response;
	}

	/**
	 * Get API-user's data
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function get_api_user() {
		$session_path = __DIR__ . '/../session';
		$session_file = md5(API_USER . API_PASSWORD);

		if( ! is_file($session_path . '/' . $session_file) ) {
			$user = $this->login(API_USER, API_PASSWORD, true);
//			$user = $this->login('mode@rator.com', '1234567890', true);
		}

		$response = [
			'session' => $session_file
		];

		return $response;
	}

	/**
	 * Get logged-in user's authorisation token.
	 * Search file in /session directory with filename that equal $token
	 * @param string $token - value that saved in user cookie (user_token) on frontend
	 */
	public function get_user($session) {
		$session_path = __DIR__ . '/../session';
		$session_data = null;

		/**
		 * Check if a file with a token exists
		 */
		if( is_file( $session_path . '/' . $session['session'] ) ) {
			$session_data_raw  = file_get_contents($session_path . '/' . $session['session'] );
			$session_data_curr = json_decode($session_data_raw, true);

			if( ! $session_data_curr ) {

			}
			else {
				$expires = (int) $session_data_curr['expires'] / 1000;
				if( $expires > 0 ) {
					$filetime = filemtime($session_path . '/' . $session['session']) + $expires;
					if( $filetime <= time() ) {
						$this->refresh($session['session']);
					}
				}
			}

			$session_data_raw = file_get_contents($session_path . '/' . $session['session'] );
			$session_data     = json_decode($session_data_raw, true);
		}

		return $session_data;
	}

	/**
	 * Refresh auth token (life cycle is 90000 seconds)
	 * @param string $login user login
	 * @param string $password user password
	 */
	public function refresh($session_file) {
		$url = $this->ApiUrl->url('/auth/refresh');

		$session_path     = __DIR__ . '/../session';
		$session_data_raw = file_get_contents($session_path . '/' . $session_file );
		$session_data     = json_decode($session_data_raw, true);
		$refresh_token    = $session_data['refresh_token'];
		/* TODO. Validation */
		$login_data = [
			"refresh_token" => $refresh_token
		];
		/* Get user data */
		$raw_data = $this->HTTP->post($url, $login_data);
		$data = $this->Validation->output($raw_data);

		/* Save tokens to files */
		$token         = $data['response']['data']['access_token'];
		$refresh_token = $data['response']['data']['refresh_token'];
		$expires       = $data['response']['data']['expires'];
		$session_path  = __DIR__ . '/../session';

		if( isset($data['response']['data']) && isset($data['response']['data']['access_token']) ) {
			$session_data = [
				'token'           => $token,
				'refresh_token'   => $refresh_token,
				'expires'         => $expires,
				'user_id'         => $session_data['user_id'],
				'user_role'       => $session_data['user_role'],
				'user_role_title' => $session_data['user_role_title']
			];

			unlink($session_path . '/' . $session_file);
			$fp = fopen($session_path . '/' . $session_file,"w");
			$res = fwrite($fp, json_encode($session_data));
			fclose($fp);
		}

		$response = [
			'session' => $session_file
		];

		return $response;
	}

	/**
	 *
	 */
	public function request($data) {
		$result = [];
		$payload = json_decode($data['payload'], JSON_OBJECT_AS_ARRAY);
		if( $data['method'] === 'login' && isset($payload['login']) && isset($payload['password']) && ! empty($payload['login']) && ! empty($payload['password']) ) {
			$result = $this->login($payload['login'], $payload['password']);
			$result = $this->Validation->format($result);
		}
		elseif( $data['method'] === 'ping' ) {
			$session = [
				'session' => $payload['token']
			];
			$result = $this->get_user($session);

			if( isset($result['token']) && ! empty($result['token']) ) {
				$result = $this->Validation->format($session);
			}
			else {

			}
		}
		elseif( $data['method'] === 'register') {
			if( isset($data['token']) ) {
				$session = [
					'session' => $data['token']
				];
			}
			else {
				$session = $this->get_api_user();
			}
			$user = $this->get_user($session);

			$result = $this->register($payload, $user);
		}

		return $result;
	}

	public function register($data=[], $user=null) {
		$result = [];

		if( ! empty($data) && $user !== null ){
			$role      = $user['user_role_title'];
			$is_access = $this->Validation->create_user_role($role, $data['type']);

			if( $is_access ) {
				$url   = $this->ApiUrl->url('/users', $user['token']);
				$role = $this->Role->get_role_id($data['type']);

				$payload = [
					'email'    => $data['login'],
					'password' => $data['password'],
					'role'     => $role,
				];

				$raw_data = $this->HTTP->post($url, $payload);
				$data = $this->Validation->output($raw_data);

				/* TODO. Errors handler */

				$is_error = false;
				if($is_error) {
					$result = ['error'];
				}
				else {
					$result = $this->login($payload['email'], $payload['password']);
					$result = $this->Validation->format($result);
				}
			}
			else {
				$result = $this->Notification->forbidden();
			}
		}

		return $result;
	}

	private function set_user_data($data=[], $api_user=false) {
		/* Save tokens to files */
		$token         = $data['response']['data']['access_token'];
		$refresh_token = $data['response']['data']['refresh_token'];
		$expires       = $data['response']['data']['expires'];
		$session_path  = __DIR__ . '/../session';

		$this->User->set_token($token);
		$user = $this->User->get_single();

//		var_dump($token);
//		var_dump($user);
//		exit();

		$session_file = null;

		if( isset($user['response']['data']) && isset($user['response']['data']['id']) ) {
			$session_file = $api_user ? md5(API_USER . API_PASSWORD) : md5($user['response']['data']['id']);

			$session_data = [
				'token'           => $token,
				'refresh_token'   => $refresh_token,
				'expires'         => $expires,
				'user_id'         => $user['response']['data']['id'],
				'user_role'       => $user['response']['data']['role'],
				'user_role_title' => $this->Role->get_role_name($user['response']['data']['role'])
			];

			$fp = fopen($session_path . '/' . $session_file,"w");
			$res = fwrite($fp, json_encode($session_data));
			fclose($fp);
		}

		$response = [
			'session' => $session_file
		];

		return $response;
	}
}