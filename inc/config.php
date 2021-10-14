<?php
const API_SERVER   = 'http://directus_alias:8055';
const API_USER     = 'default@user.com';
const API_PASSWORD = 's9v43KuguT7SeLARS2e2';

/**
 * Data structure of the site instance
 * Using for creating database tables && validation data in API queries
 *
 * languages - list of codes of languages
 * user_role - list of user roles in Directus
 * structure - list with collections
 *
 * type of fields
 * https://docs.directus.io/concepts/types/
 */
const APP_SETTINGS = [
	/**
	 * List of languages
	 */
	'languages' => [
		'fields' => [
			'code' => [
				'field' => 'code',
				'type'  => 'string',
			]
		],
		'values' => [
			['code' => 'uk-UA'],
			['code' => 'en-EN'],
			['code' => 'ru-RU'],
		]
	],

	/**
	 * List of user roles
	 */
	'user_roles' => [
		'api_user',
		'moderator',
		'user',
	],

	/**
	 * Fields && permissions for collections by user type
	 */
	'collections' => [
		'test' => [
			'fields' => [
				'title' => [
					'field' => 'title',
					'type'  => 'text',
				],
				'description' => [
					'field' => 'description',
					'type' => 'text',
				],
				'test2_id' => [
					'field'    => 'test2_id',
					'type'     => 'integer',
					'relation' => [
						"foreign_key_table" => "test2",
						"foreign_key_column" => "id",
						"constraint_name" => "about_us_logo_foreign",
					]
				],
			],
			'permissions' => [
				'read'   => [],
				'add'    => [],
				'edit'   => [],
				'delete' => [],
			],
		],
		'test2' => [
			'fields' => [
				'title' => [
					'field' => 'title',
					'type'  => 'text',
				],
			],
			'permissions' => [
				'read'   => [],
				'add'    => [],
				'edit'   => [],
				'delete' => [],
			],
		],
//		'test3' => [
//			'fields' => [],
//			'permissions' => [
//				'read'   => [],
//				'add'    => [],
//				'edit'   => [],
//				'delete' => [],
//			],
//		],
	],
];