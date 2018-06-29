<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
echo '<script>$(document).ready(function(){  $("#btn").click(function(){ openFrDisplayPulldownMenu([{u: "user1", p: "abcd", av: "1234"}]); }); });'.PHP_EOL;
echo '</script><button id="btn">CLICK</button>';
}
?>
<script>
function openFrDisplayPulldownMenu(event, post_results){
  l = $("#friends_searchbar").offset().left;
  t = $("#friends_searchbar").offset().top + $("#friends_searchbar").outerHeight();
  var new_node = $('#fr_display_menu').clone();
  new_node.attr('id', '');
  new_node.offset({left: l, top: t});
  $('body').prepend(new_node);
  new_node.empty();
  $.each(post_results, function(key, value){
    var new_repeater = $('#fr_display_template').clone();
    new_repeater.attr('id', '');
    new_repeater.html(new_repeater.html().replace(/{User}/g, value['u']));
    new_repeater.html(new_repeater.html().replace(/{PID}/g, value['p']));
    new_repeater.html(new_repeater.html().replace(/{AID}/g, value['av']));
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



<ul id="fr_display_menu" style="position: absolute; top: 0; left: 0; z-index: 50; display: none;"></ul>
<li id="fr_display_template" style="display: none; margin: 20px 70px 40px;">
  <a href="/profile.php?id={PID}"> <img style="" class="img-circle" src="/avatar.php?pic={AID}" alt="avatar" width="70px" height="70px" > {User} </a>
</li>

<!-- -->




