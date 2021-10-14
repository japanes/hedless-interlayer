<?php
namespace JPNS\Directus\Field;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Validation\Validation;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\Relation\Relation;

/**
 * List Fields
 * Retrieve a Field
 * Create a Field
 * Update a Field
 * Delete a Field
 */
class Field {
	public $token;
	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;
	public $Relation;

	function __construct($token) {
		$this->token = $token;

		$this->HTTP         = new HTTP();
		$this->Validation   = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl       = new ApiUrl();
		$this->Relation     = new Relation($token);
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
		$collection = trim($data['collection']);
		$url = $this->ApiUrl->url('/items/' . $collection, $this->token);

		/* Get collection data */
		$raw_data = $this->HTTP->get($url);
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
	public function get_single($data=[]) {
		$result = [];
		$collection = trim($data['collection']);
		$id = (int) $data['id'];

		$url = $this->ApiUrl->url('/items/' . $collection . '/' . $id, $this->token);

		/* Get collection data */
		$raw_data = $this->HTTP->get($url);
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
	public function create($collection=null, $data=[]) {
		$result = [];
		if($collection !== null) {
			if( is_string($collection) && is_array($data) ) {
				if( ! empty($collection) && ! empty($data) ) {
					$collection = trim($collection);
					$url        = $this->ApiUrl->url('/fields/' . $collection, $this->token);

					$payload = [
						'field' => $data['field'],
						'type'  => $data['type'],
					];

					if( isset($data['relation']) && is_array($data['relation']) && ! empty($data['relation']) ) {
						$this->Relation->create($data);
					}


					/* Get collection data */
					$raw_data = $this->HTTP->post($url, $payload);
					$result   = $this->Validation->output($raw_data);
				}
			}
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