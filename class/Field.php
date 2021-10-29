<?php
namespace JPNS\Directus\Field;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
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

					if( isset($data['meta']) ) {
						$payload['meta'] = $data['meta'];
					}
					if( isset($data['schema']) ) {
						$payload['schema'] = $data['schema'];
					}

					if( $data['field'] === 'translations' ) {
						if( ! isset($payload['meta']) ) {
							$payload['meta'] = [];
						}
						$payload['meta']['special']   = $data['field'];
						$payload['meta']['interface'] = $data['field'];
					}

					/* Get collection data */
					$raw_data = $this->HTTP->post($url, $payload);
					$result   = $this->Validation->output($raw_data);

					if( isset($data['relation']) && is_array($data['relation']) && ! empty($data['relation']) ) {
						$this->Relation->create($collection, $data);
					}
				}
			}
		}

		return $result;
	}

	public function create_sys($collection=null, $title=null) {
		$result = [];

		if( $collection !== null && $title !== null ) {
			if($title === 'status') {
				$result = $this->create_status($collection, $title);
			}
			elseif($title === 'sort') {
				$result = $this->create_sort($collection, $title);
			}
			elseif($title === 'user_created') {
				$result = $this->create_user_created($collection, $title);
			}
			elseif($title === 'user_updated') {
				$result = $this->create_user_updated($collection, $title);
			}
			elseif($title === 'date_created') {
				$result = $this->create_date_created($collection, $title);
			}
			elseif($title === 'date_updated') {
				$result = $this->create_date_updated($collection, $title);
			}
		}

		return $result;
	}

	private function create_status($collection=null, $title=null) {
		$result = [];

		if( $collection !== null && $title !== null ) {
			$field = [
				'field'  => $title,
				'type'   => 'text',
				'meta'   => [
					'collection'      => $collection,
					'field'           => $title,
					'interface'       => 'select-dropdown',
					'readonly'        => false,
					'hidden'          => false,
					'display'         => 'labels',
					'options'         => [
						'choices' => [
							[
								'text' => 'Published',
								'value' => 'published',
							],
							[
								'text' => 'Draft',
								'value' => 'draft',
							],
							[
								'text' => 'Archived',
								'value' => 'archived',
							],
						],
					],
					'display_options' => [
						'choices' => [
							[
								'value' => 'published',
								'background' => '#00C897',
							],
							[
								'value' => 'draft',
								'background' => '#D3DAE4',
							],
							[
								'value' => 'archived',
								'background' => '#F7971C',
							],
						],
						'showAsDot' => true,
					]
				],
				'schema' => [
					'name'          => $title,
					'table'         => $collection,
					'data_type'     => 'text',
					'default_value' => 'draft',
				],
			];

			$result = $this->create($collection, $field);
		}

		return $result;
	}

	private function create_sort($collection=null, $title=null) {
		$result = [];

		if( $collection !== null && $title !== null ) {
			$field = [
				'field'  => $title,
				'type'   => 'integer',
				'meta'   => [
					'collection' => $collection,
					'field'      => $title,
					'interface'  => 'input',
					'readonly'   => false,
					'hidden'     => true,
				],
			];

			$result = $this->create($collection, $field);
		}

		return $result;
	}

	private function create_user_created($collection=null, $title=null) {
		$result = [];

		if( $collection !== null && $title !== null ) {
			$field = [
				'field'  => $title,
				'type'   => 'uuid',
				'meta'   => [
					'collection'      => $collection,
					'field'           => $title,
					'special'         => 'user-created',
					'interface'       => 'select-dropdown-m2o',
					'readonly'        => true,
					'hidden'          => true,
					'display'         => 'user',
					'options'         => [
						'template' => '{{avatar.$thumbnail}} {{first_name}} {{last_name}}',
					],
				],
				'schema' => [
					'name'               => $title,
					'table'              => $collection,
					'foreign_key_table'  => 'directus_users',
					'foreign_key_column' => 'id',
				],
				'relation' => [
					"foreign_key_table"  => "directus_users",
					"foreign_key_column" => "id",
				]
			];

			$result = $this->create($collection, $field);
		}

		return $result;
	}

	private function create_date_created($collection=null, $title=null) {
		$result = [];

		if( $collection !== null && $title !== null ) {
			$field = [
				'field'  => $title,
				'type'   => 'dateTime',
				'meta'   => [
					'collection'      => $collection,
					'field'           => $title,
					'special'         => 'date-created',
					'interface'       => 'datetime',
					'readonly'        => true,
					'hidden'          => true,
					'display'         => 'datetime',
					'display_options'         => [
						'relative' => true,
					],
				],
			];

			$result = $this->create($collection, $field);
		}

		return $result;
	}

	private function create_user_updated($collection=null, $title=null) {
		$result = [];

		if( $collection !== null && $title !== null ) {
			$field = [
				'field'  => $title,
				'type'   => 'uuid',
				'meta'   => [
					'collection'      => $collection,
					'field'           => $title,
					'special'         => 'user-updated',
					'interface'       => 'select-dropdown-m2o',
					'readonly'        => true,
					'hidden'          => true,
					'display'         => 'user',
					'options'         => [
						'template' => '{{avatar.$thumbnail}} {{first_name}} {{last_name}}',
					],
				],
				'schema' => [
					'name'               => $title,
					'table'              => $collection,
					'foreign_key_table'  => 'directus_users',
					'foreign_key_column' => 'id',
				],
				'relation' => [
					"foreign_key_table"  => "directus_users",
					"foreign_key_column" => "id",
				]
			];

			$result = $this->create($collection, $field);
		}

		return $result;
	}

	private function create_date_updated($collection=null, $title=null) {
		$result = [];

		if( $collection !== null && $title !== null ) {
			$field = [
				'field'  => $title,
				'type'   => 'dateTime',
				'meta'   => [
					'collection'      => $collection,
					'field'           => $title,
					'special'         => 'date-updated',
					'interface'       => 'datetime',
					'readonly'        => true,
					'hidden'          => true,
					'display'         => 'datetime',
					'display_options'         => [
						'relative' => true,
					],
				],
			];

			$result = $this->create($collection, $field);
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