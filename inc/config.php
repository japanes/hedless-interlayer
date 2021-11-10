<?php
require_once __DIR__ . '/config-collection-homepage.php';
require_once __DIR__ . '/config-collection-directory.php';
require_once __DIR__ . '/config-collection-users.php';

const API_SERVER   = 'http://directus_alias:8055';
const API_USER     = 'default@user.com';
const API_PASSWORD = 's9v43KuguT7SeLARS2e2';

//const API_USER     = 'admin@example.com';
//const API_PASSWORD = 'd1r3ctu5';

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

/* TODO. Config for multiple Directuses!!! */

const APP_SETTINGS = [
	/**
	 * API list
	 */
//	'api' => [
//		'' => [
//
//		],
//	],

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
		'company',
		'user',
	],

	/**
	 * Fields && permissions for collections by user type
	 */
	'collections' => [
		'directory_company_type_lang' => COLLECTION_DIRECTORY_COMPANY_TYPE_LANG,
		'directory_company_type'      => COLLECTION_DIRECTORY_COMPANY_TYPE,

		'homepage_lang' => COLLECTION_HOMEPAGE_LANG,
		'homepage'      => COLLECTION_HOMEPAGE,

		'bank_details_lang' => COLLECTION_BANK_DETAILS_LANG,
		'bank_details'      => COLLECTION_BANK_DETAILS,
		'users_lang'        => COLLECTION_USERS_LANG,
		'users'             => COLLECTION_USERS,
	],

	/**
	 * Fields && permissions for directus collections by user type
	 */
	'system_collections' => [
		'directus_files' => [
			'system' => true,
			'fields' => [
				'storage' => ['field' => 'storage'],
				'filename_disk' => ['field' => 'filename_disk'],
				'filename_download' => ['field' => 'filename_download'],
				'title' => ['field' => 'title'],
				'type' => ['field' => 'type'],
				'folder' => ['field' => 'folder'],
				'uploaded_by' => ['field' => 'uploaded_by'],
				'uploaded_on' => ['field' => 'uploaded_on'],
				'modified_by' => ['field' => 'modified_by'],
				'modified_on' => ['field' => 'modified_on'],
				'charset' => ['field' => 'charset'],
				'filesize' => ['field' => 'filesize'],
				'width' => ['field' => 'width'],
				'height' => ['field' => 'height'],
				'duration' => ['field' => 'duration'],
				'embed' => ['field' => 'embed'],
				'description' => ['field' => 'description'],
				'location' => ['field' => 'location'],
				'tags' => ['field' => 'tags'],
				'metadata' => ['field' => 'metadata'],
			],
			'permissions' => [
				'own' => [
					'api_user' => '*',
					'moderator' => '*',
					'company' => 'my',
					'user' => 'my',
				],
				'fields' => [
					'api_user' => [
						'*' => '*'
					],
					'moderator' => [
						'*' => '*'
					],
					'company' => [
						'*' => '*'
					],
					'user' => [
						'*' => '*'
					],
				],
				'action' => [
					'api_user' => ['read'],
					'moderator' => ['read','create','update'],
					'company' => ['read','create','update'],
					'user' => ['read','create','update'],
				],
			],
		],
		'directus_users' => [
			'system' => true,
			'fields' => [
				'first_name' => ['field' => 'first_name'],
				'last_name' => ['field' => 'last_name'],
				'email' => ['field' => 'email'],
				'location' => ['field' => 'location'],
				'title' => ['field' => 'title'],
				'description' => ['field' => 'description'],
				'tags' => ['field' => 'tags'],
				'avatar' => ['field' => 'avatar'],
				'language' => ['field' => 'language'],
				'theme' => ['field' => 'theme'],
				'tfa_secret' => ['field' => 'tfa_secret'],
				'status' => ['field' => 'status'],
				'role' => ['field' => 'role'],
				'token' => ['field' => 'token'],
				'last_access' => ['field' => 'last_access'],
				'last_page' => ['field' => 'last_page'],
			],
			'permissions' => [
				'own' => [
					'api_user' => '*',
					'moderator' => '*',
					'company' => 'my',
					'user' => 'my',
				],
				'fields' => [
					'api_user' => [
						'read'   => ['first_name', 'last_name', 'email', 'location', 'title', 'description', 'avatar', 'status', 'role'],
						'create' => '*',
					],
					'moderator' => [
						'read'   => ['first_name', 'last_name', 'email', 'location', 'title', 'description', 'avatar', 'status', 'role'],
						'create' => '*',
						'update' => ['first_name', 'last_name', 'email', 'location', 'title', 'description', 'avatar', 'status', 'role']
					],
					'company' => [
						'read'   => ['first_name', 'last_name', 'email', 'location', 'title', 'description', 'avatar', 'status'],
						'update' => ['first_name', 'last_name', 'email', 'location', 'title', 'description', 'avatar']
					],
					'user' => [
						'read'   => ['first_name', 'last_name', 'email', 'location', 'title', 'description', 'avatar', 'status'],
						'update' => ['first_name', 'last_name', 'email', 'location', 'title', 'description', 'avatar']
					],
				],
				'action' => [
					'api_user' => ['read','create'],
					'moderator' => ['read','create','update'],
					'company' => ['read','update'],
					'user' => ['read','update'],
				],
				'roles' => [
					'api_user' => ['user'],
					'moderator' => ['company'],
				]
			],
		],
		'lang' => [
			'permissions' => [
				'own' => [
					'api_user' => '*',
					'moderator' => '*',
					'company' => '*',
					'user' => '*',
				],
				'fields' => [
					'api_user' => [
						'read'   => '*',
					],
					'moderator' => [
						'read'   => '*',
					],
					'company' => [
						'read'   => '*',
					],
					'user' => [
						'read'   => '*',
					],
				],
				'action' => [
					'api_user' => ['read'],
					'moderator' => ['read'],
					'company' => ['read'],
					'user' => ['read'],
				],
			],
		],
	],
];