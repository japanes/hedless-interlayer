<?php
namespace JPNS\Directus\File;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\User\User;

/**
 * List Collections
 * Retrieve a Collection
 * Create a Collection
 * Update a Collection
 * Delete a Collection
 */
class File {
	public $token;
	public $user;

	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;
	public $User;

	function __construct($token, $user=null) {
		$this->token = $token;
		$this->user  = $user;

		$this->HTTP = new HTTP();
		$this->Validation = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl = new ApiUrl();

//		$this->ApiUrl->set_user();
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function get_list($data=[]) {
//		$collection = trim($data['collection']);
//
//		$url_data = [
//			'collection' => $data['collection'],
//			'role'       => $this->user['user_role_title'],
//			'action'     => 'read'
//		];
//		$url = $this->ApiUrl->url('/items/' . $collection, $this->token, $url_data);
//
//////		var_dump(2142141);
////		var_dump(222);
////		var_dump($url);
////		exit();
//		/* Get collection data */
//		$raw_data = $this->HTTP->get($url);
//		$data = $this->Validation->output($raw_data);
//
//
////		var_dump($data);
////		exit();
//		return $data;
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function get_single($data=[]) {
//		$collection = trim($data['collection']);
//		$id = (int) $data['id'];
//
//		$url_data = [
//			'collection' => $data['collection'],
//			'role'       => $this->user['user_role_title'],
//			'action'     => 'read'
//		];
//		$url = $this->ApiUrl->url('/items/' . $collection . '/' . $id, $this->token, $url_data);
//
//		/* Get collection data */
//		$raw_data = $this->HTTP->get($url);
//		$data = $this->Validation->output($raw_data);
//
//		return $data;
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function upload() {
		$result = [];

		foreach($_FILES as $key => $file) {
			$url = $this->ApiUrl->url('/files', $this->token);

			$raw_data = $this->HTTP->file($url, $file['tmp_name'], $file['type'], $file['name']);
			$result[$key] = $this->Validation->output($raw_data);
		}

		return $result;
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function import($data=[]) {
		var_dump($data);
		exit();
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