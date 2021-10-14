<?php

namespace JPNS\Directus\InitDirectus;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Validation\Validation;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\Auth\Auth;
use JPNS\Directus\Collection\Collection;
use JPNS\Directus\Field\Field;
use JPNS\Directus\Item\Item;

/**
 * Initial action. Create custom tables in database, user roles,
 * set languages && permissions
 */
class InitDirectus {
	public $HTTP;
	public $Validation;
	public $Notification;
	public $ApiUrl;
	public $Auth;
	public $Collection;
	public $Field;
	public $Item;

	private $login;
	private $password;
	private $token;

	function __construct($login='', $password='') {
		$this->HTTP         = new HTTP();
		$this->Validation   = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl       = new ApiUrl();
		$this->Auth         = new Auth();

		$this->login    = $login;
		$this->password = $password;

		$login_res   = $this->Auth->login($login, $password);
		$this->token = $this->Auth->get_token($login_res['token']);

		$this->Collection = new Collection($this->token);
		$this->Field      = new Field($this->token);
		$this->Item       = new Item($this->token);

	}

	public function init() {
		/* Create languages collection */
		$lang_title  = 'lang';
		$lang_fields = APP_SETTINGS['languages'];

		$res = $this->create_collection($lang_title, $lang_fields);

		/* Create all collections  */
		$collections = APP_SETTINGS['collections'];


		/* Create permissions */

	}

	private function check_collection($collection=null) {
		$is_exists = false;
		if( $collection !== null && is_string($collection) ) {

			$url      = $this->ApiUrl->url('/collections/' . $collection, $this->token);
			$raw_data = $this->HTTP->get($url);
			$data = $this->Validation->output($raw_data);

			if( is_array($data['response']['data']) && isset($data['response']['data']['collection']) && trim($data['response']['data']['collection']) === $collection ) {
				$is_exists = true;
			}
		}

		return $is_exists;
	}

	private function create_collection($collection=null, $fields=[]) {
		$result = null;

		if( $collection !== null && is_string($collection) ) {

			$is_exists = $this->check_collection($collection);

			if( ! $is_exists ) {
				$data = [
					'collection' => $collection
				];
				$result = $this->Collection->create($data);
				foreach ( $fields['fields'] as $key => $val ) {
					$field = $this->Field->create( $collection, $val );
				}

				$items = $this->Item->create( $collection, $fields['values'] );

//				var_dump($items);
//				var_dump('********');
			}
//			else {
//				$this->Collection->delete($collection);
//			}
		}

		return $result;
	}

	private function create_relation() {

	}

	private function create_permission() {

	}
}