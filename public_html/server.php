<?php require "includes/config.php";?>

<?php

$message = $_POST['message'];

if ($message != "") {
	$sql = "INSERT INTO `chat` VALUES('','$message')";
	mysql_query($sql);
}

$sql = "SELECT `Text` FROM `chat` ORDER BY `Id` DESC";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
	echo $row['Text'] . "\n";
}

?>










<!-- ****************** chat  sql table *********************************-->
<!--CREATE TABLE IF NOT EXISTS `chat` (
  `Id` int(11) NOT NULL auto_increment,
  `Text` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;-->