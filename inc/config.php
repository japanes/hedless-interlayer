<?php
require_once __DIR__ . '/config-collection-homepage.php';

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
		'test2' => [
			'fields' => [
				'title' => [
					'field' => 'title',
					'type'  => 'text',
				],
			],
			'system_fields' => ['status', 'user_created', 'date_created', 'user_updated', 'date_updated'],
			'permissions' => [
				'own' => [
					'api_user' => '*',
					'moderator' => '*',
					'company' => 'my',
					'user' => 'my',
				],
				'fields' => [
					'api_user' => [
						'*' => ['title']
					],
					'moderator' => [
						'*' => '*'
					],
					'company' => [
						'*' => ['title']
					],
					'user' => [
						'*' => ['title']
					],
				],
				'status' => [
					'api_user' => ['published'],
					'moderator' => ['published', 'draft', 'archived'],
					'company' => ['published', 'draft'],
					'user' => ['published', 'draft'],
				],
				'action' => [
					'api_user' => ['read'],
					'moderator' => ['read','create','update'],
					'company' => ['read','create','update'],
					'user' => ['read','create','update'],
				],

			],
		],
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
			'system_fields' => ['status', 'owner', 'date_create'],
			'permissions' => [
				'own' => [
					'moderator' => '*',
					'company' => 'my',
					'user' => 'my',
				],
				'fields' => [
					'api_user' => [
						'read' => '*'
					],
					'moderator' => [
						'*' => '*'
					],
					'company' => [
						'read'   => ['title', 'description', 'test2_id'],
						'create' => ['title', 'description', 'test2_id'],
						'update' => ['description', 'test2_id']
					],
					'user' => [
						'read'   => ['title', 'description', 'test2_id'],
						'create' => ['title', 'description', 'test2_id'],
						'update' => ['description', 'test2_id']
					],
				],
				'status' => [
					'moderator' => ['published', 'draft', 'archived'],
					'company' => ['published', 'draft'],
					'user' => ['published', 'draft'],
				],
				'action' => [
					'api_user' => ['read'],
					'moderator' => ['read','create','update'],
					'company' => ['read','create','update'],
					'user' => ['read','create','update'],
				],
			],
		],
		'test_collection_lang' => [
			'fields' => [
				'title' => [
					'field' => 'title',
					'type'  => 'text',
				],
				'description' => [
					'field' => 'description',
					'type'  => 'text',
				],
				'lang' => [
					'field' => 'lang',
					'type'  => 'integer',
				],
				'test_collection_id' => [
					'field' => 'test_collection_id',
					'type'  => 'integer',
				],
			],
			'system_fields' => ['status', 'owner', 'date_create'],
			'permissions' => [
				'own' => [
					'api_user' => '*',
					'moderator' => '*',
					'company' => 'my',
					'user' => 'my',
				],
				'fields' => [
					'api_user' => [
						'*' => ['title', 'description', 'lang', 'test_collection_id']
					],
					'moderator' => [
						'*' => '*'
					],
					'company' => [
						'*' => ['title', 'description', 'lang', 'test_collection_id']
					],
					'user' => [
						'*' => ['title', 'description', 'lang', 'test_collection_id']
					],
				],
				'status' => [
					'api_user' => ['published'],
					'moderator' => ['published', 'draft', 'archived'],
					'company' => ['published', 'draft'],
					'user' => ['published', 'draft'],
				],
				'action' => [
					'api_user' => ['read'],
					'moderator' => ['read','create','update'],
					'company' => ['read','create','update'],
					'user' => ['read','create','update'],
				],
			],
		],
		'test_collection' => [
			'fields' => [
				'title' => [
					'field' => 'title',
					'type'  => 'text',
				],
				'translations' => [
					'field' => 'translations',
					'type'  => 'alias',
				],
			],
			'system_fields' => ['status', 'owner', 'date_create'],
			'translations' => [
				'language' => [
					'many_field' => 'lang',
					'many_collection' => 'test_collection_lang',
					'one_field' => null,
					'one_collection' => 'lang',
					'junction_field' => 'test_collection_id',
				],
				'translation' => [
					'many_field' => 'test_collection_id',
					'many_collection' => 'test_collection_lang',
					'one_field' => 'translations',
					'one_collection' => 'test_collection',
					'junction_field' => 'lang',
				],
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
						'*' => ['title', 'translations']
					],
					'moderator' => [
						'*' => '*'
					],
					'company' => [
						'*' => ['title', 'translations']
					],
					'user' => [
						'*' => ['title', 'translations']
					],
				],
				'status' => [
					'api_user' => ['published'],
					'moderator' => ['published', 'draft', 'archived'],
					'company' => ['published', 'draft'],
					'user' => ['published', 'draft'],
				],
				'action' => [
					'api_user' => ['read'],
					'moderator' => ['read','create','update'],
					'company' => ['read','create','update'],
					'user' => ['read','create','update'],
				],
			],
		],

		'homepage_lang' => COLLECTION_HOMEPAGE_LANG,
		'homepage'      => COLLECTION_HOMEPAGE,

//		'aboutpage_lang' => [
//			'fields' => [
//				'title' => [
//					'field' => 'title',
//					'type'  => 'text',
//				],
//				'description' => [
//					'field' => 'description',
//					'type'  => 'text',
//				],
//				'lang' => [
//					'field' => 'lang',
//					'type'  => 'integer',
//				],
//				'test_collection_id' => [
//					'field' => 'test_collection_id',
//					'type'  => 'integer',
//				],
//			],
//			'system_fields' => ['status', 'owner', 'date_create'],
//			'permissions' => [
//				'own' => [
//					'api_user' => '*',
//					'moderator' => '*',
//					'company' => 'my',
//					'user' => 'my',
//				],
//				'fields' => [
//					'api_user' => [
//						'*' => ['title', 'description', 'lang', 'test_collection_id']
//					],
//					'moderator' => [
//						'*' => '*'
//					],
//					'company' => [
//						'*' => ['title', 'description', 'lang', 'test_collection_id']
//					],
//					'user' => [
//						'*' => ['title', 'description', 'lang', 'test_collection_id']
//					],
//				],
//				'status' => [
//					'api_user' => ['published'],
//					'moderator' => ['published', 'draft', 'archived'],
//					'company' => ['published', 'draft'],
//					'user' => ['published', 'draft'],
//				],
//				'action' => [
//					'api_user' => ['read'],
//					'moderator' => ['read','create','update'],
//					'company' => ['read','create','update'],
//					'user' => ['read','create','update'],
//				],
//			],
//		],
//		'aboutpage' => [
//			'fields' => [
//				'title' => [
//					'field' => 'title',
//					'type'  => 'text',
//				],
//				'translations' => [
//					'field' => 'translations',
//					'type'  => 'alias',
//				],
//			],
//			'system_fields' => ['status', 'owner', 'date_create'],
//			'translations' => [
//				'language' => [
//					'many_field' => 'lang',
//					'many_collection' => 'test_collection_lang',
//					'one_field' => null,
//					'one_collection' => 'lang',
//					'junction_field' => 'test_collection_id',
//				],
//				'translation' => [
//					'many_field' => 'test_collection_id',
//					'many_collection' => 'test_collection_lang',
//					'one_field' => 'translations',
//					'one_collection' => 'test_collection',
//					'junction_field' => 'lang',
//				],
//			],
//			'permissions' => [
//				'own' => [
//					'api_user' => '*',
//					'moderator' => '*',
//					'company' => 'my',
//					'user' => 'my',
//				],
//				'fields' => [
//					'api_user' => [
//						'*' => ['title', 'translations']
//					],
//					'moderator' => [
//						'*' => '*'
//					],
//					'company' => [
//						'*' => ['title', 'translations']
//					],
//					'user' => [
//						'*' => ['title', 'translations']
//					],
//				],
//				'status' => [
//					'api_user' => ['published'],
//					'moderator' => ['published', 'draft', 'archived'],
//					'company' => ['published', 'draft'],
//					'user' => ['published', 'draft'],
//				],
//				'action' => [
//					'api_user' => ['read'],
//					'moderator' => ['read','create','update'],
//					'company' => ['read','create','update'],
//					'user' => ['read','create','update'],
//				],
//			],
//		],
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