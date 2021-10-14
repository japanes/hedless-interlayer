<?php
namespace JPNS\Directus\Item;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Validation\Validation;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\ApiUrl\ApiUrl;

/**
 * List Collections
 * Retrieve a Collection
 * Create a Collection
 * Update a Collection
 * Delete a Collection
 */
class Item {
	public $token;
	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;

	function __construct($token) {
		$this->token = $token;

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
	public function get_list($data=[]) {
		$collection = trim($data['collection']);
		$url = $this->ApiUrl->url('/items/' . $collection, $this->token);

		/* Get collection data */
		$raw_data = $this->HTTP->get($url);
		$data = $this->Validation->output($raw_data);


//		var_dump($data);
//		exit();
		return $data;
	}

	/**
	 * Login user to directus fot getting auth token
	 * @param string $login user login
	 * @param string $password user password
	 *
	 * @return array array with data
	 */
	public function get_single($data=[]) {
		$collection = trim($data['collection']);
		$id = (int) $data['id'];

		$url = $this->ApiUrl->url('/items/' . $collection . '/' . $id, $this->token);

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
	public function create($collection, $data=[]) {
		$result = null;

		$url = $this->ApiUrl->url('/items/' . $collection, $this->token);

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