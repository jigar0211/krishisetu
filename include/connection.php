<?php
session_start();
date_default_timezone_set('Asia/Calcutta');

define('HOSTNAME', 'localhost');
define('DATABASE', 'main');
define('USERNAME', 'root');
define('PASSWORD', '');

define("APPNAME", "krishisetu");
define("FULLPATH", "http://localhost/krishisetu/");
define("SYSPATH", "{$_SERVER['DOCUMENT_ROOT']}/krishisetu/");
define("MODE", "local");

define("MAILER_NAME", "IngeniousWebTech");

define("MAILER_HOST", "mail.bestwaywebsites.com");
define("MAILER_EMAIL", "noreply@bestwaywebsites.com"); //@bestwaywebsites.com
define("MAILER_PASS", "*npw2023!");
define("MAILER_PORT", 465); //465
define("MAILER_SMTPSecure", "ssl"); //ssl

$dsn = "mysql:host=".HOSTNAME.";dbname=". DATABASE. ";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, USERNAME, PASSWORD, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

include_once SYSPATH . "classes/database.php";
$db = new Database();

include_once SYSPATH . "include/functions.php";
