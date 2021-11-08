<?php

namespace JPNS\Directus\InitDirectus;

use JPNS\Basic\http\HTTP;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\Auth\Auth;
use JPNS\Directus\Collection\Collection;
use JPNS\Directus\Relation\Relation;
use JPNS\Directus\Field\Field;
use JPNS\Directus\Item\Item;
use JPNS\Directus\User\User;
use JPNS\Directus\File\File;

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
	public $Relation;
	public $User;

	private $login;
	private $password;
	private $user;

	function __construct($login='', $password='') {
		$this->HTTP         = new HTTP();
		$this->Validation   = new Validation();
		$this->Notification = new Notification();
		$this->ApiUrl       = new ApiUrl();
		$this->Auth         = new Auth();

		$this->login    = $login;
		$this->password = $password;

		$login_res  = $this->Auth->login($login, $password);
		$this->user = $this->Auth->get_user($login_res);

		$this->Collection = new Collection($this->user['token']);
		$this->Field      = new Field($this->user['token']);
		$this->Item       = new Item($this->user['token']);
		$this->Relation   = new Relation($this->user['token']);
		$this->User       = new User($this->user['token']);
	}

	public function init() {
		/* Create languages collection */
		$lang_title  = 'lang';
		$lang_fields = APP_SETTINGS['languages'];

		$res = $this->create_collection($lang_title, $lang_fields);


		/* Create all collections  */
		foreach(APP_SETTINGS['collections'] as $collection => $fields) {
			$this->create_collection($collection, $fields);
		}

		/* Create roles */
		/* && */
		/* Create permissions */
		$this->create_role_n_permissions();

		$this->create_api_user();

	}

	private function check_collection($collection=null) {
		$is_exists = false;
		if( $collection !== null && is_string($collection) ) {

			$url      = $this->ApiUrl->url('/collections/' . $collection, $this->user['token']);
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
				if( isset($fields['system_fields']) && is_array($fields['system_fields']) ) {
					$data['meta'] = [];
					if( in_array('status', $fields['system_fields']) ) {
						$data['meta']['archive_field']      = 'status';
						$data['meta']['archive_value']      = 'archived';
						$data['meta']['unarchive_value']    = 'draft';
						$data['meta']['archive_app_filter'] = true;
					}
					if( in_array('sort', $fields['system_fields']) ) {
						$data['meta']['sort_field'] = 'sort';
					}
				}

				$result = $this->Collection->create($data);
				foreach ( $fields['fields'] as $key => $val ) {
					$field = $this->Field->create( $collection, $val );
				}
				if( isset($fields['system_fields']) && is_array($fields['system_fields']) ) {
					foreach ($fields['system_fields'] as $sys_field) {
						$field = $this->Field->create_sys( $collection, $sys_field );
					}
				}

				$items = $this->Item->create( $collection, $fields['values'] );

				if( isset($fields['translations']) && ! empty($fields['translations']) && is_array($fields['translations']) ) {
//					$translations_data = [
//						'collection' => $collection . '_translations'
//					];
//					$result = $this->Collection->create($translations_data);
					$this->Relation->create_translations($fields['translations']);
				}

//				var_dump($items);
//				var_dump('********');
			}
			else {
				$this->Collection->delete($collection);
				if( isset($fields['translations']) && ! empty($fields['translations']) && is_array($fields['translations']) ) {
//					$this->Collection->delete($collection . '_translations');
				}
			}
		}

		return $result;
	}

	private function create_role_n_permissions() {
		$roles           = APP_SETTINGS['user_roles'];
		$collections     = array_merge(APP_SETTINGS['collections'], APP_SETTINGS['system_collections']);

		$roles_data = [];
		foreach($roles as $role) {
			$collection_list = [];

			$role_exists = false;
			$role_file   = __DIR__ . '/../roles/' . $role;
			if( is_file($role_file) ) {
				$role_id = file_get_contents($role_file);

				$url      = $this->ApiUrl->url('/roles/' . $role_id, $this->user['token']);
				$role_data = $this->HTTP->get($url);
			}

			if( ! $role_exists ) {
				foreach($collections as $key => $collection) {
					$actions = $collection['permissions']['action'][$role];
					if( in_array('read', $actions) || in_array('add', $actions) || in_array('edit', $actions) ) {
						$collection_list[] = $key;
					}
				}

				$roles_data[] = [
					'name' => $role,
					'description' => null,
					'ip_access' => null,
					'enforce_tfa' => false,
					'collection_list' => $collection_list,
					'admin_access' => false,
					'app_access' => false,
				];
			}
		}

		if( ! empty($roles_data) ) {
			$url       = $this->ApiUrl->url('/roles', $this->user['token']);
			$raw_data  = $this->HTTP->post($url, $roles_data);
			$role_data = $this->Validation->output($raw_data);

			if( isset($role_data['response']['data']) && is_array($role_data['response']['data']) ) {
				foreach($role_data['response']['data'] as $role) {
					if( isset($role['id']) && isset($role['name']) ) {

						foreach($collections as $collection_key => $collection) {
							$perm = $collection['permissions'];

							$own     = $perm['own'][$role['name']];
							$fields  = $perm['fields'][$role['name']];
							$status  = isset($perm['status']) && is_array($perm['status']) && isset($perm['status'][$role['name']]) ? $perm['status'][$role['name']] : null;
							$actions = $perm['action'][$role['name']];

							foreach($actions as $action) {

								if( $own !== '*' || $status !== null ) {
									$is_and = ($own !== '*' && $status !== null);

									$filter_data = [];
									if($is_and) {
										$filter_data['_and'] = [];
									}

									if( $own !== '*' ) {
										if($collection_key === 'directus_users') {
											if($is_and) {
												$filter_data['_and']['id'] = [
													'_eq' => '$CURRENT_USER',
												];
											}
											else {
												$filter_data['id'] = [
													'_eq' => '$CURRENT_USER',
												];
											}
										}
										else {
											if($is_and) {
												$filter_data['_and']['owner'] = [
													'_eq' => '$CURRENT_USER',
												];
											}
											else {
												$filter_data['owner'] = [
													'_eq' => '$CURRENT_USER',
												];
											}
										}
									}
									if($status !== null) {
										if($is_and) {
											$filter_data['_and']['status'] = [
												'_in' => $status
											];
										}
										else {
											$filter_data['status'] = [
												'_in' => $status
											];
										}
									}
								}

								$permission_fields = null;
								if( isset($fields['*']) ) {
									$permission_fields = $fields['*'];
								}
								else {
									$permission_fields = $fields[$action];
								}
								if( ! is_array($permission_fields) && $permission_fields === '*' ) {
									$filter_data = null;
								}

								if( is_array($permission_fields) && $action === 'read' ) {
									array_unshift($permission_fields , 'id');
								}

								$permission = [
									'role'        => $role['id'],
									'collection'  => $collection_key,
									'action'      => $action,
									'permissions' => $filter_data,
									'validation'  => null,
									'presets'     => null,
									'fields'      => $permission_fields,
								];

								var_dump($permission_fields);

								$permission_url  = $this->ApiUrl->url('/permissions', $this->user['token']);
								$raw_data        = $this->HTTP->post($permission_url, $permission);
								$permission_data = $this->Validation->output($raw_data);
							}

						}


						$res = file_put_contents( __DIR__ . '/../roles/' . $role['name'], $role['id']);

//						var_dump(__DIR__ . '/../roles/' . $role['name']);
//						var_dump($res);
					}
				}
			}
		}
	}

	private function create_api_user() {
		$role_path = $roles_dir = __DIR__ . '/../roles';
		$role_id   = file_get_contents($role_path . '/api_user');

		$user_data = [
			'email'    => API_USER,
			'password' => API_PASSWORD,
			'role'     => $role_id,
		];

		$raw_data = $this->User->create($user_data);
		$result = $this->Validation->output($raw_data);

		return $result;
	}
}