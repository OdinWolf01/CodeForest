<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<!-- Bootstrap CSS -->
<!-- jQuery first, then Bootstrap JS. -->
<script>
$(document).ready(function(){
  $("#pnav-home").parent().off('click');
  $("#pnav-home").parent().click(function(){ window.location.href = '/'; });
});
</script>
<!-- Nav tabs -->


<img style="width: 100%" src="/wave.php" alt="gif"  height="20px">

<nav class="ui-tabs ui-corner-all ui-widget ui-widget-content">





<ul style="justify-content: center;" class="nav nav-tabs ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header" role="tablist">
  <li class="nav-item ui-tabs-tab ui-corner-top ui-state-default ui-tab">
    <a class="nav-link active" id="pnav-home" href="#Home" role="tab" data-toggle="tab">Home</a>
  </li>

  <li class="nav-item ui-tabs-tab ui-corner-top ui-state-default ui-tab">
    <a class="nav-link active" href="#Timeline" role="tab" data-toggle="tab">Timeline</a>
  </li>

  <li class="nav-item ui-tabs-tab ui-corner-top ui-state-default ui-tab">
    <a class="nav-link" href="#Friends" role="tab" data-toggle="tab">Friends</a>
  </li>

  <li class="nav-item ui-tabs-tab ui-corner-top ui-state-default ui-tab">
    <a class="nav-link" href="#About" role="tab" data-toggle="tab">About</a>
  </li>
  
   <li class="nav-item ui-tabs-tab ui-corner-top ui-state-default ui-tab">
    <a class="nav-link" href="#Photos" role="tab" data-toggle="tab">Photos</a>
  </li>
</ul>
</nav>
<!-- Tab panes -->
<div class="tab-content">
  <div style="color: black;" role="tabpanel" class="tab-pane fade show active" id="Timeline">
    <? require_once($_SERVER['DOCUMENT_ROOT'].'/doublets/ptimeline_doublet.php'); ?>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="Friends">
    <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/friends_list_codelet.php'); ?>
  </div>

  <div role="tabpanel" class="tab-pane fade" id="About">
    <p>About Here</p>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="Photos">
    <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/media_upload_codelet.php'); ?>
    <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/media_list_codelet.php'); ?>
  </div>
</div>
