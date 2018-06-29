<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {header('Location: /'); exit();}

if(isset($_POST['list'])){
  echo json_encode(pdo_get_notifications_menu_list($_SESSION['memberID']));
}
?>