<?php
const COLLECTION_BANK_DETAILS_LANG = [
	'title' => 'bank_details_lang',
	'fields' => [
		'title' => [
			'field' => 'title',
			'type'  => 'text',
		],
		'type' => [
			'field' => 'type',
			'type'  => 'integer',
			'relation' => [
				"foreign_key_table" => "directory_company_type",
				"foreign_key_column" => "id",
			]
		],
		'inn' => [
			'field' => 'inn',
			'type'  => 'text',
		],
		'vat' => [
			'field' => 'vat',
			'type'  => 'integer',
		],
		'certificate_number' => [
			'field' => 'certificate_number',
			'type'  => 'text',
		],
		'income_tax' => [
			'field' => 'income_tax',
			'type'  => 'integer',
		],
		'address' => [
			'field' => 'address',
			'type'  => 'text',
		],
		'bank' => [
			'field' => 'bank',
			'type'  => 'text',
		],
		'edrpo' => [
			'field' => 'edrpo',
			'type'  => 'text',
		],
		'account' => [
			'field' => 'account',
			'type'  => 'text',
		],
		'appointment' => [
			'field' => 'appointment',
			'type'  => 'text',
		],
		'tel' => [
			'field' => 'tel',
			'type'  => 'text',
		],
		'ceo_name' => [
			'field' => 'ceo_name',
			'type'  => 'text',
		],
		'accountant_name' => [
			'field' => 'accountant_name',
			'type'  => 'text',
		],
		'note' => [
			'field' => 'address',
			'type'  => 'text',
		],
		'bank_details_lang_id' => [
			'field' => 'bank_details_lang_id',
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
				'*' => ['title', 'type', 'inn', 'vat', 'certificate_number', 'income_tax', 'address', 'bank', 'edrpo', 'account', 'appointment', 'tel', 'ceo_name', 'accountant_name', 'note', 'bank_details_lang_id', 'lang']
			],
			'moderator' => [
				'*' => '*'
			],
			'company' => [
				'*' => ['title', 'type', 'inn', 'vat', 'certificate_number', 'income_tax', 'address', 'bank', 'edrpo', 'account', 'appointment', 'tel', 'ceo_name', 'accountant_name', 'note', 'bank_details_lang_id', 'lang']
			],
			'user' => [
				'*' => ['title', 'type', 'inn', 'vat', 'certificate_number', 'income_tax', 'address', 'bank', 'edrpo', 'account', 'appointment', 'tel', 'ceo_name', 'accountant_name', 'note', 'bank_details_lang_id', 'lang']
			],
		],
		'status' => [
			'api_user' => ['published'],
			'moderator' => ['published', 'draft', 'archived'],
			'company' => ['published', 'draft'],
			'user' => ['published'],
		],
		'action' => [
			'api_user' => ['read'],
			'moderator' => ['read','create','update'],
			'company' => ['read','create','update'],
			'user' => ['read'],
		],
	],
];

const COLLECTION_BANK_DETAILS = [
	'title' => 'bank_details',
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
			'many_collection' => 'bank_details_lang',
			'one_field' => null,
			'one_collection' => 'lang',
			'junction_field' => 'bank_details_id',
		],
		'translation' => [
			'many_field' => 'bank_details_id',
			'many_collection' => 'bank_details_lang',
			'one_field' => 'translations',
			'one_collection' => 'bank_details',
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
			'user' => ['published'],
		],
		'action' => [
			'api_user' => ['read'],
			'moderator' => ['read','create','update'],
			'company' => ['read','create','update'],
			'user' => ['read'],
		],
	],
];

const COLLECTION_USERS_LANG = [
	'title' => 'users_lang',
	'fields' => [
		'title' => [
			'field' => 'title',
			'type'  => 'string',
			'schema' => [
				'is_unique'  => true,
				'max_length' => 1000,
			]
		],
		'tel1_text' => [
			'field' => 'tel1_text',
			'type'  => 'text',
		],
		'tel2_text' => [
			'field' => 'tel2_text',
			'type'  => 'text',
		],
		'tel3_text' => [
			'field' => 'tel3_text',
			'type'  => 'text',
		],
		'email1_text' => [
			'field' => 'email1_text',
			'type'  => 'text',
		],
		'email2_text' => [
			'field' => 'email2_text',
			'type'  => 'text',
		],
		'email3_text' => [
			'field' => 'email3_text',
			'type'  => 'text',
		],
		'users_id' => [
			'field' => 'users_id',
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

const COLLECTION_USERS = [
	'title' => 'users',
	'fields' => [
		'user_id' => [
			'field'  => 'user_id',
			'type'   => 'uuid',
			'relation' => [
				"foreign_key_table" => "directus_users",
				"foreign_key_column" => "id",
			]
		],
		'client_id' => [
			'field'  => 'client_id',
			'type'   => 'integer',
			'schema' => [
				'is_unique' => true,
			]
		],
		'logo' => [
			'field' => 'logo',
			'type'  => 'uuid',
			'relation' => [
				"foreign_key_table" => "directus_files",
				"foreign_key_column" => "id",
			]
		],
		'tel1' => [
			'field'  => 'tel1',
			'type'   => 'string',
			'schema' => [
				'is_unique'  => true,
				'max_length' => 100,
			]
		],
		'tel2' => [
			'field'  => 'string',
			'type'   => 'text',
			'schema' => [
				'max_length' => 100,
			]
		],
		'tel3' => [
			'field'  => 'tel3',
			'type'   => 'string',
			'schema' => [
				'max_length' => 100,
			]
		],
		'email1' => [
			'field'  => 'email1',
			'type'   => 'string',
			'schema' => [
				'max_length' => 200,
			]
		],
		'email2' => [
			'field'  => 'email2',
			'type'   => 'string',
			'schema' => [
				'max_length' => 200,
			]
		],
		'email3' => [
			'field'  => 'email3',
			'type'   => 'string',
			'schema' => [
				'max_length' => 200,
			]
		],
		'translations' => [
			'field' => 'translations',
			'type'  => 'alias',
		],
	],
	'system_fields' => ['status', 'sort', 'user_created', 'date_created', 'user_updated', 'date_updated'],
	'translations' => [
		'language' => [
			'many_field' => 'lang',
			'many_collection' => 'users_lang',
			'one_field' => null,
			'one_collection' => 'lang',
			'junction_field' => 'users_id',
		],
		'translation' => [
			'many_field' => 'users_id',
			'many_collection' => 'users_lang',
			'one_field' => 'translations',
			'one_collection' => 'users',
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
				'*' => ['logo','tel1','tel2','tel3','email1','email2','email3','translations']
			],
			'moderator' => [
				'*' => '*'
			],
			'company' => [
				'*' => ['user_id','logo','tel1','tel2','tel3','email1','email2','email3','translations']
			],
			'user' => [
				'*' => ['user_id','logo','tel1','tel2','tel3','email1','email2','email3','translations']
			],
		],
		'status' => [
			'api_user' => ['published'],
			'moderator' => ['published', 'draft', 'archived'],
			'company' => ['published', 'draft'],
			'user' => ['published', 'draft'],
		],
		'action' => [
			'api_user' => ['read','create'],
			'moderator' => ['read','create','update'],
			'company' => ['read','update'],
			'user' => ['read','update'],
		],
	],
];