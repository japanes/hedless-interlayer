<?php

namespace JPNS\Directus\Validation;

class Validation {
	/**
	 * Send GET http-request
	 * @param string $data json string
	 * @param array $fields array of strings with field names that will be removed from answer
	 */
	static public function output($data, $fields=[]) {
		$data = json_decode($data, JSON_OBJECT_AS_ARRAY);

//		var_dump($data);
//		exit();

		return $data;
	}


}