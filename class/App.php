<?php

namespace JPNS\Directus\App;

class App {
	private $app_user;
	private $app_token;

	/**
	 * @return mixed
	 */
	public function get_app_token() {
		return $this->app_token;
	}

	/**
	 * @return mixed
	 */
	public function get_app_user() {
		return $this->app_user;
	}

	/**
	 * @param mixed $app_token
	 */
	public function set_app_token( $app_token ) {
		$this->app_token = $app_token;
	}

	/**
	 * @param mixed $app_user
	 */
	public function set_app_user( $app_user ) {
		$this->app_user = $app_user;
	}
}