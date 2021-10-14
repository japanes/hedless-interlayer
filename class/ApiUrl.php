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
	public $params=[];

	public function translations($data) {
		if( isset($data['translations']) && (int) $data['translations'] === 1 ) {

		}
	}

	/**
	 * Send GET http-request
	 * @param string $path api request query
	 * @param string $token content type of request
	 * @param array  $data content type of request
	 */
	static public function url($path, $token=null, $data=[]) {
		if(strpos($path, "/") !== 0) {
			$path = '/' . $path;
		}
		$url = API_SERVER . $path;// . '?fields[]=*,translations.*.*' ;

		if( $token !== null ) {
//			$url .= '&access_token=' . $token;
			$url .= '?access_token=' . $token;
		}

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