<?php


require_once 'includes/config.php';


if (!$user->is_logged_in()) {header('Location: login.php');exit();}

$title = 'Social :)';


?>
  


<div class="row" >
          
<?php
$friends_ary = pdo_get_all_friends_array($_SESSION['memberID']);
foreach($friends_ary as $memID){
	$avID = pdo_get_avatarID_from_memberID($memID);
	echo '<figure>'.PHP_EOL;
	echo '<img style="margin: 20px 70px 40px;" class="img-circle" src="avatar.php?pic='.$avID.'" alt="avatar" width="100px" height="100px" >'.PHP_EOL;
	echo '<figcaption><button class="btn-primary">Message</button>&nbsp;<button class="btn btn-danger">Unfriend</button></figcaption>'.PHP_EOL;
	echo '</figure>'.PHP_EOL;
}

?>