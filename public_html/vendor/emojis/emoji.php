<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<!--
<?php/*
$db_str = " <3  [umbr],  [peace].";
echo $db_str;
echo "<hr />";
$chars = array("<3", "[peace]", "[umbr]");
$icons = array("&#10084;", "&#9774;", "&#9730;");
$new_str = str_replace($chars,$icons,$db_str);
echo $new_str;*/
?>

<?php/*

$db->query("SET character_set_client='utf8'");
$db->query("SET character_set_results='utf8'");
$db->query("set collation_connection='utf8_general_ci'");
$statement = $db->prepare("INSERT INTO `emoticons` (`text`) VALUES (?)");
$emoji = '😀';
$statement->bind_param('s', $emoji);
$statement->execute();
echo "inserted $emoji";*/
?>

-->
