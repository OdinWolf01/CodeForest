<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {exit();}
if(isset($_SESSION['memberID'])){
  pdo_set_ping($_SESSION['memberID']);
  $ary = array();
  $ary['online_friends'] = pdo_get_online_friends($_SESSION['memberID']);
  if(isset($_POST['require_post_update']) && $_POST['require_post_update'] !== 'false'){
    pdo_notifications_set_post($_SESSION['memberID'], 0);
    $ary['require_post_update'] = false;
  }else
    $ary['require_post_update'] = (pdo_notifications_get_post($_SESSION['memberID']) === 1)?true:false;
  $ary['notifications'] = array();
  $num_unread = pdo_have_unread_chats($_SESSION['memberID']);
  if($num_unread > 0)
    $ary['notifications'] = pdo_have_unread_chats_with_who($_SESSION['memberID']);
  echo json_encode($ary);
}
?>