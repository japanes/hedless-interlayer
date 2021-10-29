<?php

namespace JPNS\Directus\ApiUrl;

class ApiUrl {
	/*
	public function query_sort( $data ) {
		$sort = '';
		if( isset($data['sort']) && ! empty($data['sort']) ) {
			$sort = '&sort=' . trim($data['sort']);
		}

		return $sort;
	}
	public function query_filter( $data ) {
		$sort = '';
		if( isset($data['filter']) && ! empty($data['filter']) ) {
			if( substr( trim($data['filter']), 0, 1 ) !== "&" ) {
				$sort .= '&';
			}
			$sort .= trim($data['filter']);
		}

		return $sort;
	}
	public function query_fields( $data ) {
		$fields = '';
		if( isset($data['fields']) && ! empty($data['fields']) ) {
			if(strpos($data['fields'], "fields=") !== 0) {
				$data['fields'] = 'fields=' . $data['fields'];
			}
			$fields = '&' . trim($data['fields']);
		}

		return $fields;
	}
	public function query_limit( $data ) {
		$limit = '';
		if( isset($data['limit']) && ! empty($data['limit']) ) {
			$limit = '&limit=' . trim($data['limit']);
		}

		return $limit;
	}
	public function query_offset( $data ) {
		$offset = '';
		if( isset($data['offset']) && ! empty($data['offset']) ) {
			$offset = '&offset=' . trim($data['offset']);
		}

		return $offset;
	}
	public function query_status( $data ) {
		$status = '';
		if( isset($data['status']) && ! empty($data['status']) ) {
			$status = '&status=' . trim($data['status']);
		}

		return $status;
	}
	public function query_meta( $data ) {
		$meta = '';
		if( isset($data['meta']) && ! empty($data['meta']) ) {
			$meta = '&meta=' . trim($data['meta']);
		}

		return $meta;
	}
	public function query_single( $data ) {
		$single = '';
		if( isset($data['single']) && ! empty($data['single']) ) {
			$single = '&single=' . trim($data['single']);
		}

		return $single;
	}

	public function query_params( $data ) {
		$list = [];

		$sort = $this->query_sort($data);
		if( ! empty($sort) ) {
			$list[] = $sort;
		}

		$filter = $this->query_filter($data);
		if( ! empty($filter) ) {
			$list[] = $filter;
		}
		$fields = $this->query_fields($data);
		if( ! empty($fields) ) {
			$list[] = $fields;
		}

		$limit = $this->query_limit($data);
		if( ! empty($limit) ) {
			$list[] = $limit;
		}

		$offset = $this->query_offset($data);
		if( ! empty($offset) ) {
			$list[] = $offset;
		}

		$status = $this->query_status($data);
		if( ! empty($status) ) {
			$list[] = $status;
		}

		$meta = $this->query_meta($data);
		if( ! empty($meta) ) {
			$list[] = $meta;
		}

		$str = implode('&', $list);
		if( ! empty($str) ) {
			$str = str_replace('&&', '&', $str);
		}

		return $str;
	}
	*/
	public $params = [];
	public $user   = null;

	public function translations($data) {
		if( isset($data['translations']) && (int) $data['translations'] === 1 ) {

		}
	}

	/**
	 * @param $param param key
	 * @param $value param value
	 */
	public function set_param($param=null, $value=null) {
		if( $param !== null ) {
			$this->params[$param] = $value;
		}
	}

	public function param_str() {
		// http_build_query($this->params, '', '&');
		$result = '';

		if( is_array($this->params) && ! empty($this->params) ) {
			$sep = '';
			foreach($this->params as $key => $val) {
				$result .= $sep;
				$result .= $key . '=' . $val;

				$sep = '&';
			}
		}

		return $result;
	}

	public function role_fields($data) {
		$result = '';

		if( is_array($data) && isset($data['role']) && $data['role'] !== null ) {
			$collections = array_merge(APP_SETTINGS['collections'], APP_SETTINGS['system_collections']);

			$collection  = $collections[$data['collection']];
			$fields_list = [];

			$access_fields_all = $collection['permissions']['fields'][$data['role']];
			$access_fields = isset($access_fields_all['*']) ? $access_fields_all['*'] : ( isset($access_fields_all[$data['action']]) ? $access_fields_all[$data['action']] : null );

			$is_all_fields = isset($access_fields_all['*']) && $access_fields_all['*'] === '*' ? true : ( isset($access_fields_all[$data['action']]) && $access_fields_all[$data['action']] ? true : false );

			if( $is_all_fields ) {
				$fields_list[] = isset( $data['prefix'] ) ? $data['prefix'] . '.*' : '*';
			}

			foreach($collection['fields'] as $field) {

				if( is_array($access_fields) ) {
					foreach($access_fields as $access_field) {
						if( $field['field'] === $access_field ) {
							if( ! is_array($collection['permissions']['action'][$data['role']]) || ! in_array($data['action'], $collection['permissions']['action'][$data['role']]) ) {
								continue;
							}

							if( $field['field'] === 'translations' ) {
								$translation_data = [
									'action'     => $data['action'],
									'role'       => $data['role'],
									'prefix'     => $field['field'],
									'collection' => $collection['translations']['language']['many_collection'],
								];

								$fields_list[] = $this->role_fields($translation_data);
							}
							else if( isset($field['relation']) ) {
								$relation_data = [
									'action'     => $data['action'],
									'role'       => $data['role'],
									'prefix'     => isset( $data['prefix'] ) ? $data['prefix'] . '.' . $field['field'] : $field['field'],
									'collection' => $field['relation']['foreign_key_table'],
								];

								$fields_list[] = $this->role_fields($relation_data);
							}
							else if( isset($field['langcode']) ) {
								$lang_field = isset( $data['prefix'] ) ? $data['prefix'] . '.' . $field['field'] : $field['field'];
								$fields_list[] = $lang_field . '.*';
							}
							else {
								if( ! $is_all_fields ) {
									$field_str = isset( $data['prefix'] ) ? $data['prefix'] . '.' . $field['field'] : $field['field'];

									if( ! empty($field_str) ) {
										$fields_list[] = $field_str;
									}
								}
							}
						}
					}
				}
			}

			if( ! empty($fields_list) ) {
				$result = implode(',', $fields_list);
			}
		}

		return $result;
	}

	/**
	 * Send GET http-request
	 * @param string $path api request query
	 * @param string $token request's token
	 * @param array  $data request's user data
	 * @param array  $filter filtering payload
	 */
	public function url($path, $token=null, $data=null, $filter=[]) {
		if( $token !== null ) {
			$this->set_param('access_token', $token);
		}

		if( $data !== null ) {
			$role_fields = $this->role_fields($data);

			if( ! empty($role_fields) ) {
				$this->set_param('fields[]', $role_fields);
			}
		}

		if(strpos($path, "/") !== 0) {
			$path = '/' . $path;
		}
		$params = $this->param_str();

		$url = API_SERVER . $path . '?' . $params;


//		$fields = true;
//		$fields = false;
//		if($fields) {
//			$url .= '?fields[]=*.*.*' ;
//		}
//
//
//
//		if( $token !== null ) {
//			if($fields) {
//				$url .= '&access_token=' . $token;
//			}
//			else {
//				$url .= '?access_token=' . $token;
//			}
//		}

//		var_dump($url);
//		exit();
//		if( $token !== null ) {
//			$url .= '?access_token=' . $token;
//		}
//
//		$url .= $this->query_params($data);
//
////        $url .= '&' . $this->generate_id();
//
		return $url;
	}


}