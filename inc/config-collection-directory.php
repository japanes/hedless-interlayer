<?php

const COLLECTION_DIRECTORY_COMPANY_TYPE_LANG = [
	'title' => 'directory_company_type_lang',
	'fields' => [
		'title' => [
			'field' => 'title',
			'type'  => 'text',
		],
		'directory_company_type_id' => [
			'field' => 'directory_company_type_id',
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
			'company' => '*',
			'user' => '*',
		],
		'fields' => [
			'api_user' => [
				'*' => ['slider_title','lang']
			],
			'moderator' => [
				'*' => '*'
			],
			'company' => [
				'*' => ['slider_title','lang']
			],
			'user' => [
				'*' => ['slider_title','lang']
			],
		],
		'status' => [
			'api_user' => ['published'],
			'moderator' => ['published', 'draft', 'archived'],
			'company' => ['published'],
			'user' => ['published'],
		],
		'action' => [
			'api_user' => ['read'],
			'moderator' => ['read','create','update'],
			'company' => ['read'],
			'user' => ['read'],
		],
	],
];

const COLLECTION_DIRECTORY_COMPANY_TYPE = [
	'title' => 'directory_company_type',
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
			'many_collection' => 'directory_company_type_lang',
			'one_field' => null,
			'one_collection' => 'lang',
			'junction_field' => 'directory_company_type_id',
		],
		'translation' => [
			'many_field' => 'directory_company_type_id',
			'many_collection' => 'directory_company_type_lang',
			'one_field' => 'translations',
			'one_collection' => 'directory_company_type',
			'junction_field' => 'lang',
		],
	],
	'permissions' => [
		'own' => [
			'api_user' => '*',
			'moderator' => '*',
			'company' => '*',
			'user' => '*',
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
			'company' => ['published'],
			'user' => ['published'],
		],
		'action' => [
			'api_user' => ['read'],
			'moderator' => ['read','create','update'],
			'company' => ['read'],
			'user' => ['read'],
		],
	],
];