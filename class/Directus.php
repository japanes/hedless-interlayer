<?php
namespace JPNS\Directus\Directus;

use JPNS\Directus\Collection\Collection;
use JPNS\Directus\Item\Item;

class Directus {
	public $token;
	public $entity;

	public function __construct($type, $token) {
		$this->token = $token;
		if($type === 'collection') {
			$this->entity = new Collection($this->token);
		}
		if($type === 'item') {
			$this->entity = new Item($this->token);
		}
	}

	/**
	 * According to type of Directus-entity
	 * call method of particular entity
	 *
	 * @param array  $data list of parameters and filters
	 */
	public function request($data=[]) {
		$result = [];
		if( $data['method'] === 'single' ) {
			$result = $this->entity->get_single($data);
		}
		elseif( $data['method'] === 'list' ) {
			$result = $this->entity->get_list($data);
		}
		elseif( $data['method'] === 'create' ) {
			$result = $this->entity->get_list($data);
		}
		elseif( $data['method'] === 'update' ) {
			$result = $this->entity->get_list($data);
		}
		elseif( $data['method'] === 'delete' ) {
			$result = $this->entity->get_list($data);
		}

		return $result;
	}
}