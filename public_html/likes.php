<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php'); 
if (!$user->is_logged_in()) {header('Location: /');exit();}

if(isset($_POST['r']) && isset($_POST['t']) && isset($_POST['s'])){
  $count = pdo_likes_like_exist($_SESSION['memberID'], trim($_POST['r']), trim($_POST['t']), trim($_POST['s']));
  if($count == 0)
    pdo_likes_like($_SESSION['memberID'], trim($_POST['r']), trim($_POST['t']), trim($_POST['s']));
  else
    pdo_likes_unlike($_SESSION['memberID'], trim($_POST['r']), trim($_POST['t']), trim($_POST['s']));
} 
//else if(isset($_POST("r")) && isset($_POST("t")) && isset($_POST("s"))){
  //pdo_likes_get_count(trim($_POST("r")), trim($_POST("t")), trim($_POST("s")));
//}
?>