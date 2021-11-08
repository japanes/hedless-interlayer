<?php
namespace JPNS\Directus\Item;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\User\User;
use JPNS\Directus\File\File;

/**
 * List Collections
 * Retrieve a Collection
 * Create a Collection
 * Update a Collection
 * Delete a Collection
 */
class Item {
	public $token;
	public $user;

	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;
	public $User;
	public $File;

	function __construct($token, $user=null) {
		$this->token = $token;
		$this->user  = $user;

		$this->HTTP = new HTTP();
		$this->Validation = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl = new ApiUrl();
		$this->File = new File($this->token, $this->user);

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
		$collection = trim($data['collection']);

		$url_data = [
			'collection' => $data['collection'],
			'role'       => $this->user['user_role_title'],
			'action'     => 'read'
		];
		$url = $this->ApiUrl->url('/items/' . $collection, $this->token, $url_data);

////		var_dump(2142141);
//		var_dump(222);
//		var_dump($url);
//		exit();
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

		$url_data = [
			'collection' => $data['collection'],
			'role'       => $this->user['user_role_title'],
			'action'     => 'read'
		];
		$url = $this->ApiUrl->url('/items/' . $collection . '/' . $id, $this->token, $url_data);

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
		$result = [];

		$files = [];
		if( ! empty($_FILES) ) {
			$files = $this->File->upload();
		}

		if( isset($data['payload']) ) {
			$payload = json_decode($data['payload'], JSON_OBJECT_AS_ARRAY);
			if( json_last_error() === JSON_ERROR_NONE ) {

				$translation_result = [];
				/* Check if translations field */
				if( isset($payload['translations']) ) {
					$translation_collection = APP_SETTINGS['collections'][$data['collection']]['translations']['language']['many_collection'];
					foreach($payload['translations'] as $translation) {
						$translation_id = $translation['id'];
						$translation_url = $this->ApiUrl->url('/items/' . $translation_collection . '/' . $translation_id, $this->token);

						if( ! empty($files) ) {
							foreach($files as $key => $file) {
								$key_parts = explode('__', $key);
								if( $translation_id == $key_parts[1] ) {
									$translation[$key_parts[2]] = $file['data']['id'];
								}
							}
						}

						unset($translation['id']);

						$raw_data = $this->HTTP->patch($translation_url, $translation);
						$translation_result[] = $this->Validation->output($raw_data);
					}
				}


				$id = $payload['id'];

				unset($payload['id']);
				unset($payload['translations']);

				if( ! empty($payload) ) {
					$url = $this->ApiUrl->url('/items/' . $data['collection'] . '/' . $id, $this->token);
					$this->HTTP->patch($url, $payload);
				}

				$url_data = [
					'collection' => $data['collection'],
					'role'       => $this->user['user_role_title'],
					'action'     => 'read'
				];
				$url = $this->ApiUrl->url('/items/' . $data['collection'] , $this->token, $url_data);

				$raw_data = $this->HTTP->get($url, $payload);
				$result = $this->Validation->output($raw_data);

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
	public function delete($data=[]) {

	}
}