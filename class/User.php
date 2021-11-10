<?php
namespace JPNS\Directus\User;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\Auth\Auth;

/**
 * List Users
 * Retrieve a User
 * Create a User
 * Update a User
 * Delete a User
 */
class User {
	public $token;
	public $user;

	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;
	public $Auth;

	function __construct($token=null, $user=null) {
		$this->token = $token;
		$this->user  = $user;

		$this->HTTP = new HTTP();
		$this->Validation = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl = new ApiUrl();
		$this->Auth = new Auth();
	}

	/**
	 * @param mixed|null $token
	 */
	public function set_token( $token ) {
		$this->token = $token;
	}

	/**
	 * @return mixed|null
	 */
	public function get_token() {
		return $this->token;
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function get_list($data=[]) {
		$result = [];

		var_dump($this->user);
		exit();
		$url_data = null;
//		if( isset($data['token']) ) {
//			$user_raw = $this->Auth->get_user(['session' => $data['token']]);
//
//			var_dump($user_raw);
//			exit();
//
//			$url_data = [
//				'collection' => $data['collection'],
//				'role'       => $this->user['user_role_title'],
//				'action'     => 'read'
//			];
//		}
		$url = $this->ApiUrl->url('/users', $this->token, $url_data);

		var_dump($data);
		var_dump($url);
		exit();
//		$collection = trim($data['collection']);
//		$url = $this->ApiUrl->url('/items/' . $collection, $this->token);
//
//		/* Get collection data */
//		$raw_data = $this->HTTP->get($url);
//		$data = $this->Validation->output($raw_data);
//
//
////		var_dump($data);
////		exit();
		return $result;
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function get_single($user_id='me') {
		$url = $this->ApiUrl->url('/users/' . $user_id, $this->token);

		/* Get collection data */
		$raw_data = $this->HTTP->get($url);
		$data = $this->Validation->output($raw_data);

		return $data;
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function create($data=[]) {
		$url = $this->ApiUrl->url('/users', $this->token);
		$raw_data = $this->HTTP->post($url, $data);
		$result = $this->Validation->output($raw_data);

		return $result;
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function update($data=[]) {

	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function delete($data=[]) {

	}
}