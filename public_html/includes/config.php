<?php
//ob_start();
//require_once 'includes/pdofunc.php';
$sescookielifetime = strval(24*60*60);
session_start([ 'gc_maxlifetime' => $sescookielifetime, 'cookie_lifetime' => $sescookielifetime, 'cookie_httponly' => true ]);
//session_start();

//set timezone
date_default_timezone_set('America/New_York');

//database credentials
define('DBHOST', 'localhost');
define('DBUSER', 'db_username');
define('DBPASS', 'db_pass');
define('DBNAME', 'db_name');

//application address
define('DIR', 'https://www.cartercountywebdesign.com/');
define('SITEEMAIL', 'datajumper83@gmail.com');

//define page title
$title = 'Social :)';
$pinger_delay = 5;

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
	//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
	//show error
	echo '<p class="bg-danger">'.$e->getMessage().'</p>';
	exit;
}

//include the user class, pass in the database connection
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/user.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/phpmailer/mail.php');
$user = new User($db);
require_once($_SERVER['DOCUMENT_ROOT'].'/functions/pdofunc1.php');
?>
