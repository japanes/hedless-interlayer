<?php
namespace JPNS\Basic\Notification;
use JPNS\Basic\http\HTTP;
use JPNS\Directus\Validation\Validation;
use JPNS\Directus\ApiUrl\ApiUrl;

/**
 * Return notifications in standard format
 */
class Notification {

	/**
	 * Refresh auth token (life cycle is 90000 seconds)
	 * @param string $login user login
	 * @param string $password user password
	 */
	private function get_type() {

	}

	/**
	 * Outputs standardized notification for any type of notification
	 * like errors, warnings or success
	 * @param array|string $notification notification in any type of data
	 */
	public function output($notification) {
		var_dump($notification);
		exit();

		$result = [
			'title' => '',
			'description' => '',
			'type' => '',
			'code' => '',
		];

		return $result;
	}

	/**
	 * Outputs standardized notification for any type of notification
	 * like errors, warnings or success
	 * @param array|string $notification notification in any type of data
	 */
	public function forbidden() {
		return [
			'errors' => [
				[
					'message' => "You don't have permission to access this.",
					'extensions' => [ 'code' => 'FORBIDDEN' ],
				],
			]
		];
	}

	/**
	 * Outputs standardized notification for any type of notification
	 * like errors, warnings or success
	 * @param array|string $notification notification in any type of data
	 */
	public function auth_denied() {
		return [
			'errors' => [
				[
					'message' => "You don't have permission to access this.",
					'extensions' => [ 'code' => 'FORBIDDEN' ],
				],
			]
		];
	}
}