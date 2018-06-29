<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
echo '<script>$(document).ready(function(){   $(\'#chatbox_repeater2\').show(); setTimeout("$(\"#chatbox_repeater2\").dialog(\"open\"); $(\"#chatbox_repeater2\").css(\"height\", \"300px\");", 1000); });'.PHP_EOL;
echo '</script>';
}
?>




<style type="text/css">
  
  .ui-widget-content{
    z-index:1000000000;
    top: 0; left: 0;
    margin: auto;
    position: fixed;
    max-width: 100%;
    max-height: 100%;
    display: flex;
    flex-direction: column;
    align-items: stretch;
    left: 0 !important;
    right: 0 !important;
}
.chatbox_repeater2 .ui-widget-content {
    flex: 1;
}
</style>



<script type="text/javascript">
   var dWidth = $(window).width() * 0.9;
            var dHeight = $(window).height() * 0.9; 
</script>


<script>
$(document).ready(function(){
  $('#chatbox_repeater').draggable();
  $('#chatbox_repeater2').dialog({
    resizable: false,
    width: dWidth,
    modal: true,
    zIndex: 10000,
    height: dHeight,
    title: 'Chat Box',
    autoOpen: false,
    fluid: true,
  }).css({"overflow-y": "scroll", "overflow-x": "hidden"});
  var divfooter = $(document.createElement('div'));
  $('#chatbox_repeater2').parent().append(divfooter);
  divfooter.addClass('ui-corner-all ui-widget-header');
  divfooter.attr('align', 'center');
  var inpt = $(document.createElement('input'));
  inpt.attr('type', 'text');
  inpt.css('width', '35%');
  inpt.addClass('ui-widget ui-state-default ui-corner-all');
  var cbtn = $(document.createElement('button'));
  cbtn.css('width', '35%');
 // cbtn.append('SEND');
  cbtn.button();
 // divfooter.append(inpt);
  divfooter.append('&nbsp;');
 // divfooter.append(cbtn);
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>



<div id="chatbox_repeater2" class="ui-widget-content" style="display: none;">
  <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/friends_list_codelet.php'); ?>
  </div>



  <!--

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <style>
  #targetElement {
    height: 200px;
    margin: 50px;
    background: #9cf;
  }
  .positionDiv {
    position: absolute;
    width: 75px;
    height: 75px;
    background: #080;
  }
  </style>
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
 
<div id="targetElement">
  <div class="positionDiv" id="position1"></div>
  <div class="positionDiv" id="position2"></div>
  <div class="positionDiv" id="position3"></div>
  <div class="positionDiv" id="position4"></div>
</div>
 
<script>
$( "#position1" ).position({
  my: "center",
  at: "center",
  of: "#targetElement"
});
 
$( "#position2" ).position({
  my: "left top",
  at: "left top",
  of: "#targetElement"
});
 
$( "#position3" ).position({
  my: "right center",
  at: "right bottom",
  of: "#targetElement"
});
 
$( document ).mousemove(function( event ) {
  $( "#position4" ).position({
    my: "left+3 bottom-3",
    of: event,
    collision: "fit"
  });
});
</script>


-->