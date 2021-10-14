<?php
namespace JPNS\Directus\Auth;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Validation\Validation;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\ApiUrl\ApiUrl;

/**
 * Methods of this class returns directus's auth token for user
 */
class Auth {
	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;

	function __construct() {
		$this->HTTP = new HTTP();
		$this->Validation = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl = new ApiUrl();
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function login($login, $password) {
		$url = $this->ApiUrl->url('/auth/login');

		/* TODO. Validation */
		$login_data = [
			"email"    => $login,
			"password" => $password
		];

		/* Get user data */
		$raw_data = $this->HTTP->post($url, $login_data);
		$data = $this->Validation->output($raw_data);

		/* Save tokens to files */
		$token         = $data['response']['data']['access_token'];
		$refresh_token = $data['response']['data']['refresh_token'];
		$expires       = $data['response']['data']['expires'];
		$session_path  = __DIR__ . '/../session';
		$session_file  = md5($token);

		$fp = fopen($session_path . '/' . $session_file,"w");
		$res = fwrite($fp,$token);
		fclose($fp);

		$fp = fopen($session_path . '/' . $session_file . '_refresh',"w");
		fwrite($fp,$refresh_token);
		fclose($fp);

		$fp = fopen($session_path . '/' . $session_file . '_expires',"w");
		fwrite($fp,$expires);
		fclose($fp);

		$response = [
			'token' => $session_file
		];

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
			$user = $this->login(API_USER, API_PASSWORD);

			if( isset($user['token']) ) {
				rename($session_path . '/' . $user['token'], $session_path . '/' . $session_file);
				rename($session_path . '/' . $user['token'] . '_refresh', $session_path . '/' . $session_file . '_refresh');
				rename($session_path . '/' . $user['token'] . '_expires', $session_path . '/' . $session_file . '_expires');
			}
			else {

			}
		}

		$response = [
			'token' => $session_file
		];

		return $response;
	}

	/**
	 * Get logged-in user's authorisation token.
	 * Search file in /session directory with filename that equal $token
	 * @param string $token - value that saved in user cookie (user_token) on frontend
	 */
	public function get_token($session_file) {
		$session_path = __DIR__ . '/../session';
		$token = null;

		/**
		 * Check if a file with a token exists
		 */
		if( is_file( $session_path . '/' . $session_file ) ) {
			/**
			 * If a file exists but lifetime of a token expired
			 * we need to refresh a token
			 */
			$expires_ms = (int) file_get_contents($session_path . '/' . $session_file . '_expires' );
			$expires    = $expires_ms / 1000;

			if( $expires > 0 ) {
				$filetime = filemtime($session_path . '/' . $session_file) + $expires;
				if( $filetime <= time() ) {
					$refresh_token = file_get_contents($session_path . '/' . $session_file . '_refresh');
					$this->refresh($refresh_token, $session_path, $session_file);
				}
			}

			$token_value = file_get_contents($session_path . '/' . $session_file);
			if( ! empty($token_value) ) {
				$token = $token_value;
			}
		}

		return $token;
	}

	/**
	 * Refresh auth token (life cycle is 90000 seconds)
	 * @param string $login user login
	 * @param string $password user password
	 */
	private function refresh($token, $session_path, $session_file) {
		 $url = $this->ApiUrl->url('/auth/refresh');

		/* TODO. Validation */
		$login_data = [
			"refresh_token" => $token
		];

		/* Get user data */
		$raw_data = $this->HTTP->post($url, $login_data);
		$data = $this->Validation->output($raw_data);

		/* Save tokens to files */
		$token         = $data['response']['data']['access_token'];
		$refresh_token = $data['response']['data']['refresh_token'];
		$expires       = $data['response']['data']['expires'];

		$fp = fopen($session_path . '/' . $session_file,"w");
		$res = fwrite($fp,$token);
		fclose($fp);

		$fp = fopen($session_path . '/' . $session_file . '_refresh',"w");
		fwrite($fp,$refresh_token);
		fclose($fp);

		$fp = fopen($session_path . '/' . $session_file . '_expires',"w");
		fwrite($fp,$expires);
		fclose($fp);

		$response = [
			'token' => $session_file
		];

		return $response;
	}
}