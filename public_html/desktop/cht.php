<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
var current_all_friends = [];
function var_dump(a){
  var acc = []
  $.each(a, function(index, value) {
    acc.push(index + ': ' + value);
  });
  console.log(JSON.stringify(acc));
}
function updateContactsMenu(){
  //var diff = current_all_friends.concat(pinger['online_friends']).filter(function (e, i, array) {
  //  return array.indexOf(e) === array.lastIndexOf(e);
  //});
  var diff = $(current_all_friends).not(pinger['online_friends']).get();
  $('#chatlist_display').empty();
  $.each(pinger['online_friends'], function(key, value){
    var new_repeater = $('#chatlist_repeater').clone();
    new_repeater.attr('id', '');
    new_repeater.html(new_repeater.html().replace(/{User}/g, value['u']));
    new_repeater.html(new_repeater.html().replace(/{PID}/g, value['p']));
    new_repeater.html(new_repeater.html().replace(/{AID}/g, value['av']));
    $('#chatlist_display').append(new_repeater);
    new_repeater.show();
  });
  setTimeout('updateContactsMenu();', 1000);
};

$(document).ready(function(){
  $.getJSON('/friend.php', {friends: ''}, function(data){
    $.each(data, function(key, value){
      current_all_friends.push({u:value['u'], p: value['p']});
    });
    var_dump(current_all_friends);
  });
  updateContactsMenu();
});
</script>
<? //editable below this line:
   //leave id names and "display: none;" ?>
<style>

</style>
<div style="width: 200px;height: 400px auto;" class="container">
  <div id='chatlist_msg_display'></div>
  <div id='chatlist_display'></div>
  <div id='chatlist_repeater' style='display: none;'>
    <div class="ui-widget-content ui-state-default ui-corner-all"><img height="10" width="10" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAJUlEQVQI12NkYGBgYPzP+58BCv4zfmZkRBaAASYGLACrICM2MwE9GQoUaURE9wAAAABJRU5ErkJggg==" alt="Green dot" /> {User}</div>
    
  </div>
 
</div>

