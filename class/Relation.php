<?php
namespace JPNS\Directus\Relation;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Validation\Validation;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\ApiUrl\ApiUrl;

/**
 * List Relations
 * Retrieve a Relation
 * Create a Relation
 * Update a Relation
 * Delete a Relation
 */
class Relation {
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
	public function create($data=[]) {
		$result = null;

		/*
		 * [
			'field'    => 'test2_id',
			'type'     => 'integer',
			'relation' => [
				"foreign_key_table" => "test2",
				"foreign_key_column" => "id",
				"constraint_name" => "about_us_logo_foreign",
			]
			],


		{
		"collection": "about_us",
		"field": "logo",
		"related_collection": "directus_files",
		"schema": {
			"table": "about_us",
			"column": "logo",
			"foreign_key_table": "directus_files",
			"foreign_key_column": "id",
			"constraint_name": "about_us_logo_foreign",
			"on_update": "NO ACTION",
			"on_delete": "SET NULL"
		},
	}
		 */

		$url = $this->ApiUrl->url('/relations', $this->token);

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