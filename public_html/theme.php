<?php
require_once('includes/config.php');

if(isset($_SESSION['memberID']) && isset($_POST['theme'])){
    pdo_set_theme($_SESSION['memberID'], trim($_POST['theme']));
}else if(isset($_SESSION['memberID'])){
  $theme = false;
  if(isset($other_memberID))
    $theme = pdo_get_theme($other_memberID);
  else
    $theme = pdo_get_theme($_SESSION['memberID']);
  if($theme === false){
    echo '//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css';
  }else{
    if(empty($theme)){
      echo '//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css';
    }else{
      echo '//code.jquery.com/ui/1.12.1/themes/'.$theme.'/jquery-ui.css';
    }
  }
}else{
    echo '//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css';
}
?>