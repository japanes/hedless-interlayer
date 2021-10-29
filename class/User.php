<?php
namespace JPNS\Directus\User;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;

/**
 * List Users
 * Retrieve a User
 * Create a User
 * Update a User
 * Delete a User
 */
class User {
	public $token;

	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;

	function __construct($token=null) {
		$this->token = $token;

		$this->HTTP = new HTTP();
		$this->Validation = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl = new ApiUrl();
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
	public function get_list() {
		$result = [];
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