<?php
 

// Http Default Url
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('HTTP_URL', '/'. substr_replace(trim($_SERVER['REQUEST_URI'], '/'), '', 0, strlen($scriptName)));

// Define Path Application
define('SCRIPT', str_replace('\\', '/', rtrim(__DIR__, '/')) . '/');
define('SYSTEM', SCRIPT . 'System/');
define('CONTROLLERS', SCRIPT . 'Application/Controllers/');
define('MODELS', SCRIPT . 'Application/Models/');
define('JWT',SCRIPT.'vendor/firebase/php-jwt/src/');
 // Config Database
define('DATABASE', [
    'Port'   => '3307',
    'Host'   => 'localhost',
    'Driver' => 'PDO',
    'Name'   => 'messenger',
    'User'   => 'root',
    'Pass'   => 'Linh@12345',
    'Prefix' => 'messenger'
]);


// DB_PREFIX
define('DB_PREFIX', 'messenger');

// For Limit Page
define('LIMIT_PRE_PAGE_SHOW_BOOKS', 5);
?>
