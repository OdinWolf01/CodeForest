<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
$(document).ready(function(){
  $('#bkgd_photo').show();
});
</script>
<? //editable below this line:
   //leave id names and "display: none;" ?>
<style>
.image1 {
  position: relative;
  top: 0;
  left: 0;
}


</style>



<div id='bkgd_photo' class='image1' style='display: none;'>
<img src="/background.php<?
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false){
  if($other_backgroundID !== false)
    echo "?pic=".htmlentities($other_backgroundID, ENT_QUOTES);
  else
    echo '?pic=';
}

?>" style="width: 100%;" height="420px" >
<? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/avatar_codelet.php'); ?>
</div>
