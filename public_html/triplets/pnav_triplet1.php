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
  $("#pnav_display").tabs({
    active: 1
  });
  $("#ui-id-1").off('click');
  $("#ui-id-1").click(function(){ window.location.href = '/'; });
  $("#pnav_display").show();
});
<? //editable below this line:
   //leave id names and "display: none;" ?>

</script>
<style>
@media (max-width: 767px) {
  #tabs {
    display: block;
  }
}

#pnav_display .ui-tabs-nav { 
    height: 2.35em; 
    text-align: center; 
} 
#pnav_display .ui-tabs-nav li { 
    display: inline-block; 
    float: none; 
    top: 0px; 
    margin: 0em; 
    padding-bottom: 0px; 
}

#timeline-box1 {
  justify-content: space-between;
}
#timeline-box2 {
  //background-color:lavenderblush;
  justify-content: space-between;
}
#timeline-box3 {
  justify-content: space-between;
}
</style>
<div  id='pnav_display' style='display: none;'>
  <ul>
    <li><a href="#fragment-1"><span>Home</span></a></li>
    <li><a href="#fragment-2"><span>Timeline</span></a></li>
    <li><a href="#fragment-3"><span>Friends</span></a></li>
    <li><a href="#fragment-4"><span>About</span></a></li>
    <li><a href="#fragment-5"><span>Photos</span></a></li>
  </ul>
  <div id="fragment-1">
  </div>
  <div id="fragment-2">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4" id="timeline-box1">
        <div class="card-header">Profile Info</div>
        <div class="card-body"><? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/profile_info_codelet.php'); ?></div>
        <hr>
      </div>
      <div class="col-sm-4" id="timeline-box2">
        <div class="card-header">Posts</div>
        <div class="card-body">
          <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/post_send_codelet.php'); ?>
          <hr>
          <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/post_list_codelet.php'); ?>
        </div>
        <hr>
      </div>
      <div class="col-sm-4" id="timeline-box3">
        <div class="card-header">Photos</div>
        <div class="card-body"><? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/media_recent_codelet.php'); ?></div>
        <hr>
      </div>
    </div>
  </div>
  </div>
  <div id="fragment-3">
    <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/friends_list_codelet.php'); ?>
  </div>
  <div id="fragment-4">
    About Here
  </div>
  <div id="fragment-5">
    <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/media_list_codelet.php'); ?>
  </div>
</div>
 
