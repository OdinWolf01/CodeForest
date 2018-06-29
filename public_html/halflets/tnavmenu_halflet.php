<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
echo '<script>$(document).ready(function(){  $("#btn").click(function(event){ $.post("/notificationsmenu.php", {list: ""}, function(data){ openTnavPulldownMenu(event, $("#btn"), data); }, "json"); }); });'.PHP_EOL;
echo '</script><button id="btn">CLICK</button>';
} 
?>
<script>
function openTnavPulldownMenu(event, target, post_results){
  l = target.offset().left;
  t = target.offset().top + target.outerHeight();
  var new_node = $('#tnav_pulldown_template').clone();
  new_node.attr('id', '');
  new_node.offset({left: l, top: t});
  $('body').prepend(new_node);
  new_node.empty();
  $.each(post_results, function(key, value){
    var new_repeater = $('#tnav_pulldown_template').clone();
    new_repeater.attr('id', '');
    new_repeater.html(new_repeater.html().replace(/{User}/g, value['u']));
    new_repeater.html(new_repeater.html().replace(/{PID}/g, value['p']));
    new_repeater.html(new_repeater.html().replace(/{AID}/g, value['av']));
    new_repeater.html(new_repeater.html().replace(/{Message}/g, value['msg']));
    new_repeater.html(new_repeater.html().replace(/{Timestamp}/g, value['t']));
    new_repeater.show();
    new_node.append(new_repeater);
  });
  new_node.menu();
  new_node.mouseleave(function(){
    new_node.remove();
  });
  new_node.show();
}
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>

<ul id="tnav_pulldown_menu" class="ui-widget-content ui-state-default ui-corners-all" style="position: absolute; top: 0; left: 0; z-index: 50; display: none;"></ul>
<li id="tnav_pulldown_template" class="ui-widget-content ui-state-default ui-corners-all" style="display: none;">
  <a href="/profile.php?id={PID}"> <img class="img-circle" src="/avatar.php?pic={AID}" alt="avatar" width="70px" height="70px" > {User}: {Message} </a>
</li>
