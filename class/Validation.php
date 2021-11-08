<?php

namespace JPNS\Directus\Validation;

class Validation {
	/**
	 * Send GET http-request
	 * @param string $data json string
	 * @param array $fields array of strings with field names that will be removed from answer
	 */
	static public function output($data, $fields=[]) {
//		$data = stripslashes($data);

		$data = json_decode($data, JSON_OBJECT_AS_ARRAY);

//		var_dump($data);
//		exit();

		return $data;
	}

	static public function format($data=[]) {
		return [
			'response' => [
				'data' => $data
			]
		];
	}

	static public function create_user_role($user_role=null, $role=null) {
		$result = false;

		if($user_role !== null && $role !== null) {
			$permissions = APP_SETTINGS['system_collections']['directus_users']['permissions'];
			$role_list = [];
			if( isset($permissions['roles']) && is_array($permissions['roles'][$user_role]) ) {
				$role_list = $permissions['roles'][$user_role];
			}

			if( in_array($role, $role_list) ) {
				$result = true;
			}
		}

		return $result;
	}


}