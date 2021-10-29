<?php

const COLLECTION_HOMEPAGE_LANG = [
	'title' => 'homepage_lang',
	'fields' => [
		'slider_title' => [
			'field' => 'slider_title',
			'type'  => 'text',
		],
		'slider_text' => [
			'field' => 'slider_text',
			'type'  => 'text',
		],
		'slider_bg' => [
			'field' => 'slider_bg',
			'type'  => 'uuid',
			'relation' => [
				"foreign_key_table" => "directus_files",
				"foreign_key_column" => "id",
			]
		],
		'start_text' => [
			'field' => 'start_text',
			'type'  => 'text',
		],
		'columns_title' => [
			'field' => 'columns_title',
			'type'  => 'text',
		],
		'columns' => [
			'field' => 'columns',
			'type'  => 'json',
		],
		'end_text' => [
			'field' => 'end_text',
			'type'  => 'text',
		],
		'meta_title' => [
			'field' => 'meta_title',
			'type'  => 'text',
		],
		'meta_description' => [
			'field' => 'meta_description',
			'type'  => 'text',
		],
		'homepage_id' => [
			'field' => 'homepage_id',
			'type'  => 'integer',
		],
		'lang' => [
			'field' => 'lang',
			'type'  => 'integer',
			'langcode' => true
		],
	],
	'system_fields' => ['status', 'sort', 'user_created', 'date_created', 'user_updated', 'date_updated'],
	'permissions' => [
		'own' => [
			'api_user' => '*',
			'moderator' => '*',
			'company' => 'my',
			'user' => 'my',
		],
		'fields' => [
			'api_user' => [
				'*' => ['slider_title', 'slider_text', 'slider_bg', 'start_text', 'columns_title', 'columns', 'end_text', 'meta_title', 'meta_description', 'homepage_id', 'lang']
			],
			'moderator' => [
				'*' => '*'
			],
			'company' => [
				'*' => ['slider_title', 'slider_text', 'slider_bg', 'start_text', 'columns_title', 'columns', 'end_text', 'meta_title', 'meta_description', 'homepage_id', 'lang']
			],
			'user' => [
				'*' => ['slider_title', 'slider_text', 'slider_bg', 'start_text', 'columns_title', 'columns', 'end_text', 'meta_title', 'meta_description', 'homepage_id', 'lang']
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
];

const COLLECTION_HOMEPAGE = [
	'title' => 'homepage',
	'fields' => [
		'translations' => [
			'field' => 'translations',
			'type'  => 'alias',
		],
	],
	'system_fields' => ['status', 'sort', 'user_created', 'date_created', 'user_updated', 'date_updated'],
	'translations' => [
		'language' => [
			'many_field' => 'lang',
			'many_collection' => 'homepage_lang',
			'one_field' => null,
			'one_collection' => 'lang',
			'junction_field' => 'homepage_id',
		],
		'translation' => [
			'many_field' => 'homepage_id',
			'many_collection' => 'homepage_lang',
			'one_field' => 'translations',
			'one_collection' => 'homepage',
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
				'*' => ['translations']
			],
			'moderator' => [
				'*' => '*'
			],
			'company' => [
				'*' => ['translations']
			],
			'user' => [
				'*' => ['translations']
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
];
/*











 */