<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php'); 

if(!isset($_GET['id'])){
        header('Location: /');
        exit();
}

if(!$user->is_logged_in()){ header('Location: /'); exit(); }

$other_memberID = pdo_get_memberID_from_profileID($_GET['id']);
if($other_memberID === false){
        header('Location: /');
        echo "Error: memberID";
        exit();
}
$other_username = pdo_get_username_from_memberID($other_memberID);
if($other_username === false){
        header('Location: /');
        echo "Error: username";
        exit();
}
$other_avatarID = pdo_get_avatarID_from_memberID($other_memberID);
$other_backgroundID = pdo_get_backgroundID_from_memberID($other_memberID);
$other_profileID = $_GET['id'];


//include header template
require_once($_SERVER['DOCUMENT_ROOT'].'/layout/header_min.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/doublets/tnav_doublet.php');
?>
