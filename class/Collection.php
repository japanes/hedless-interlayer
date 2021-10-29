<?php
namespace JPNS\Directus\Collection;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;

/**
 * List Collections
 * Retrieve a Collection
 * Create a Collection
 * Update a Collection
 * Delete a Collection
 */
class Collection {
	public $token;
	public $user;

	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;

	function __construct($token, $user=null) {
		$this->token = $token;
		$this->user  = $user;

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
		$url_data = [
			'collection' => $data['collection'],
			'role'       => $this->user['user_role_title'],
			'action'     => 'read'
		];
		$url = $this->ApiUrl->url('/collections', $this->token, $url_data);

		/* Get collection data */
		$raw_data = $this->HTTP->get($url);
		$data = $this->Validation->output($raw_data);

		foreach( $data['data'] as $elem ) {
			var_dump($elem['collection']);
		}

		var_dump($data);
		var_dump(11111);
		exit();
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

		$url_data = [
			'collection' => $data['collection'],
			'role'       => $this->user['user_role_title'],
			'action'     => 'read'
		];
		$url = $this->ApiUrl->url('/collections/' . $collection, $this->token, $url_data);

		/* Get collection data */
		$raw_data = $this->HTTP->get($url);
		$data = $this->Validation->output($raw_data);

		var_dump(2221122);
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
	public function create($data=[]) {
		$result = null;

		$url = $this->ApiUrl->url('/collections', $this->token);

//		var_dump($url);
//		var_dump($this->token);
//		var_dump(1234);
//		var_dump($data);
		$raw_data = $this->HTTP->post($url, $data);
		$result   = $this->Validation->output($raw_data);

//		exit();

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
	public function delete($collection=null) {
		$result = null;

		if( $collection !== null && is_string($collection) ) {
			$url = $this->ApiUrl->url('/collections/' . $collection, $this->token);

			$raw_data = $this->HTTP->delete($url);
			$result = $this->Validation->output($raw_data);
		}

		return $result;
	}
}