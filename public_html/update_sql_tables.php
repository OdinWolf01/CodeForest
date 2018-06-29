<?php
exit();
//This exit() at the top is a script stopper. If you ever need to use this script, remove the exit() from the top by comment it out
//and change it back when you are done.


require_once('includes/config.php'); 

$stmt = $db->prepare('CREATE TABLE IF NOT EXISTS avatars( memberID int(11) NOT NULL, avatarID text NOT NULL, imgdata blob NOT NULL, PRIMARY KEY(`memberID`) );');
$stmt->execute();

$stmt = $db->prepare('CREATE TABLE IF NOT EXISTS comments( post_id bigint(20) NOT NULL, memberID int(11) NOT NULL, comments text NOT NULL, timestamp int(11) NOT NULL, PRIMARY KEY(`post_id`));');
$stmt->execute();

$stmt = $db->prepare('CREATE TABLE IF NOT EXISTS members( memberID int(11) NOT NULL AUTO_INCREMENT, username varchar(255) COLLATE utf8mb4_bin NOT NULL, password varchar(255) COLLATE utf8mb4_bin NOT NULL, email varchar(255) COLLATE utf8mb4_bin NOT NULL, active varchar(255) COLLATE utf8mb4_bin NOT NULL, resetToken varchar(255) COLLATE utf8mb4_bin DEFAULT NULL, resetComplete varchar(3) COLLATE utf8mb4_bin DEFAULT "No", PRIMARY KEY(`memberID`) );');
$stmt->execute();

$stmt = $db->prepare('CREATE TABLE IF NOT EXISTS profiles( memberID int(11) NOT NULL, profileID tinytext NOT NULL, PRIMARY KEY(`memberID`));');
$stmt->execute();

$stmt = $db->prepare('CREATE TABLE IF NOT EXISTS backgrounds( memberID int(11) NOT NULL, backgroundID text NOT NULL, imgdata longblob NOT NULL, PRIMARY KEY(`memberID`) );');
$stmt->execute();

?>