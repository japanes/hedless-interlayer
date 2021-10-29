<?php
namespace JPNS\Directus\Role;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;

/**
 * List Roles
 * Retrieve a Role
 * Create a Role
 * Update a Role
 * Delete a Role
 */
class Role {
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
	 * @return mixed
	 */
	public function get_role_name($role_id=null) {
		$role = null;
		$roles_dir = __DIR__ . '/../roles';
		$roles     = scandir($roles_dir);

		$exclude = ['.', '..', '.htaccess'];
		foreach($roles as $role_file) {
			if( ! in_array($role_file, $exclude) ) {
				$curr_id = file_get_contents( $roles_dir . '/' . $role_file );

				if( $curr_id === $role_id ) {
					$role = $role_file;
				}
			}
		}

		return $role;
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

		$url = $this->ApiUrl->url('/relations', $this->token);

		$relation = [
			'collection'         => $collection,
			'field'              => $data['field'],
			'related_collection' => $data['relation']['foreign_key_table'],
			'schema' => [
				'table'              => $collection,
				'column'             => $data['field'],
				'foreign_key_table'  => $data['relation']['foreign_key_table'],
				'foreign_key_column' => $data['relation']['foreign_key_column'],
				'constraint_name'    => $data['relation']['constraint_name'],
			],
			'meta' => [
				'many_collection' => $collection,
				'many_field' => $data['field'],
				'one_allowed_collections' => null,
				'one_collection' => $data['relation']['foreign_key_table'],
				'one_collection_field' => null,
				'one_deselect_action' => 'nullify',
				'one_field' => null,
				'sort_field' => null
			],
		];

//		var_dump($relation);

		/*
		 * ,
	'meta': {
		'id': 1,
		'junction_field': null,
		'many_collection': 'about_us',
		'many_field': 'logo',
		'one_allowed_collections': null,
		'one_collection': 'directus_files',
		'one_collection_field': null,
		'one_deselect_action': 'nullify',
		'one_field': null,
		'sort_field': null
	}
		 */
		$raw_data = $this->HTTP->post($url, $relation);
		$result = $this->Validation->output($raw_data);

//		var_dump($result);
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
	public function create_translations($data=[]) {
		$result = null;

		$url = $this->ApiUrl->url('/relations', $this->token);

//		var_dump($url);
//		exit();
		/*
  ["language"]=> {
    ["many_field"]=> "lang"
    ["many_collection"]=> "test_collection_lang"
    ["one_field"]=> NULL
    ["one_collection"]=> "lang"
    ["junction_field"]=> "test_collection_id"
  }
  ["translation"]=> {
    ["many_field"]=> "test_collection_id"
    ["many_collection"]=> "test_collection_lang"
    ["one_field"]=> "translations"
    ["one_collection"]=> "test_collection"
    ["junction_field"]=> "lang"
  }
}

  ["collection"]=> "test"
  ["field"]=> "test2_id"
  ["related_collection"]=> "test2"
  ["schema"]=> {
    ["table"]=> "test"
    ["column"]=> "test2_id"
    ["foreign_key_table"]=> "test2"
    ["foreign_key_column"]=> "id"
    ["constraint_name"]=> "about_us_logo_foreign"
  }
  ["meta"]=> {
    ["many_collection"]=> "test"
    ["many_field"]=> "test2_id"
    ["one_allowed_collections"]=> NULL
    ["one_collection"]=> "test2"
    ["one_collection_field"]=> NULL
    ["one_deselect_action"]=> "nullify"
    ["one_field"]=> NULL
    ["sort_field"]=> NULL
  }
}
		 */

		foreach( $data as $key => $val ) {
//			var_dump($key);
//			var_dump($val);
			$relation = [
				'collection'         => $val['many_collection'],
				'field'              => $val['many_field'],
				'related_collection' => $val['one_collection'],
				'schema' => [
					'table'              => $val['many_collection'],
					'column'             => $val['many_field'],
					'foreign_key_table'  => $val['one_collection'],
					'foreign_key_column' => $val['one_field'],
					'constraint_name'    => $val['junction_field'],
//				'junction_field'     => $val['junction_field'],
				],
				'meta' => [
					'junction_field'          => $val['junction_field'],
					'many_collection'         => $val['many_collection'],
					'many_field'              => $val['many_field'],
					'one_allowed_collections' => null,
					'one_collection'          => $val['one_collection'],
					'one_collection_field'    => null,
					'one_deselect_action'     => 'nullify',
					'one_field'               => $val['one_field'],
				],
			];

			$raw_data = $this->HTTP->post($url, $relation);
			$result = $this->Validation->output($raw_data);
		}

		$translation_relation = [
			'collection'         => $data['translation']['many_collection'],
			'field'              => $data['translation']['many_field'],
			'related_collection' => $data['translation']['one_collection'],
			'schema' => [
				'table'              => $data['translation']['many_collection'],
				'column'             => $data['translation']['many_field'],
				'foreign_key_table'  => $data['translation']['one_collection'],
				'foreign_key_column' => $data['translation']['one_field'],
				'constraint_name'    => $data['translation']['junction_field'],
//				'junction_field'     => $data['translation']['junction_field'],
			],
			'meta' => [
				'junction_field'          => $data['translation']['junction_field'],
				'many_collection'         => $data['translation']['many_collection'],
				'many_field'              => $data['translation']['many_field'],
				'one_allowed_collections' => null,
				'one_collection'          => $data['translation']['one_collection'],
				'one_collection_field'    => $data['translation']['one_field'],
				'one_deselect_action'     => 'nullify',
				'one_field'               => $data['translation']['one_field'],
			],
		];

//		$relation = [
//			'collection'         => $collection,
//			'field'              => $data['field'],
//			'related_collection' => $data['relation']['foreign_key_table'],
//			'schema' => [
//				'table'              => $collection,
//				'column'             => $data['field'],
//				'foreign_key_table'  => $data['relation']['foreign_key_table'],
//				'foreign_key_column' => $data['relation']['foreign_key_column'],
//				'constraint_name'    => $data['relation']['constraint_name'],
//			],
//			'meta' => [
//				'many_collection' => $collection,
//				'many_field' => $data['field'],
//				'one_allowed_collections' => null,
//				'one_collection' => $data['relation']['foreign_key_table'],
//				'one_collection_field' => null,
//				'one_deselect_action' => 'nullify',
//				'one_field' => null,
//				'sort_field' => null
//			],
//		];

		/*
		 * ,
	'meta': {
		'id': 1,
		'junction_field': null,
		'many_collection': 'about_us',
		'many_field': 'logo',
		'one_allowed_collections': null,
		'one_collection': 'directus_files',
		'one_collection_field': null,
		'one_deselect_action': 'nullify',
		'one_field': null,
		'sort_field': null
	}
		 */

//		var_dump($result);
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
	public function delete($data=[]) {

	}
}