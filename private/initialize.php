<?php

ob_start();

session_start([
	'use_only_cookies' => 1,
	'cookie_lifetime' => (60 * 60 * 24 * 1), //cookies last only for one day
	'cookie_httponly' => 1
]);

$public_end= strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0 , $public_end);
define("DOC_ROOT", $doc_root);

require_once('constants.php');
require_once('database.php');
require_once('functions.php');
require_once('validation_functions.php');
require_once('PasswordStorage.php');

$db = db_connect();


?>