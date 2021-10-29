<?php
/* Init namespaces */
use JPNS\Basic\http\HTTP;
use JPNS\Basic\Validation\Validation;
use JPNS\Basic\Notification\Notification;
use JPNS\Directus\ApiUrl\ApiUrl;
use JPNS\Directus\User\User;
use JPNS\Directus\Auth\Auth;
use JPNS\Directus\Collection\Collection;
use JPNS\Directus\Relation\Relation;
use JPNS\Directus\Field\Field;
use JPNS\Directus\Item\Item;
use JPNS\Directus\Role\Role;
use JPNS\Directus\InitDirectus\InitDirectus;

/* include config and basic data */
require_once __DIR__ . '/inc/config.php';

/* include classes */
require_once __DIR__ . '/class/HTTP.php';
require_once __DIR__ . '/class/Validation.php';
require_once __DIR__ . '/class/Notification.php';
require_once __DIR__ . '/class/ApiUrl.php';
require_once __DIR__ . '/class/User.php';
require_once __DIR__ . '/class/Auth.php';
require_once __DIR__ . '/class/Collection.php';
require_once __DIR__ . '/class/Relation.php';
require_once __DIR__ . '/class/Field.php';
require_once __DIR__ . '/class/Item.php';
require_once __DIR__ . '/class/Role.php';
require_once __DIR__ . '/class/InitDirectus.php';

//$init = new InitDirectus('admin@example.com', 'd1r3ctu5');
//$init->init();