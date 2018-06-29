<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
<? //editable below this line:
   //leave id names and "display: none;" ?>

</script>


<div class="container-fluid" style="border: 1px solid ;">
  <div class="row" style="border: 1px solid ;">
    <div class="col-sm" style="border: 1px solid ;justify-content: space-between;">
     <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/profile_info_codelet.php'); ?>
     <br><br><br>
    </div>
    <div class="col-sm-6" style="border: 1px solid ;justify-content: space-between;">
      <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/post_send_codelet.php'); ?>
          <hr>
          <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/post_list_codelet.php'); ?>
    </div>
    <div class="col-sm" style="border: 1px solid ;justify-content: space-between;">
      <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/media_recent_codelet.php'); ?>
    </div>
  </div>
  <td>
  	<p>
  <div class="row">
    <div class="col-sm" style="border: 1px solid ;">
    </div>
    <div class="col-sm-5" style="border: 1px solid ;">
      <mark style="color: red;">Favorite movies</mark>
    </div>
    <div class="col-sm">
     <mark style="color: ;">Music</mark>
    </div>
  </div>
</div>
</p>
</td>




<br><br><br>