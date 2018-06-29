<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/halflets/chatbox_halflet.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
var current_all_friends = [];
function updateChatlistMenu(){
  var p1 = [], p2 = [];
  $.each(current_all_friends, function(key, value){
    p1.push(value['p']);
  });
  $.each(pinger['online_friends'], function(key, value){
    p2.push(value['p']);
  });
  var diff = $(p1).not(p2).get();
  $('#chatlist_display').empty();
  $.each(pinger['online_friends'], function(key, value){
    var new_repeater = $('#chatlist_repeater_on').clone();
    new_repeater.attr('id', '');
    new_repeater.html(new_repeater.html().replace(/{User}/g, value['u']));
    new_repeater.html(new_repeater.html().replace(/{PID}/g, value['p']));
    new_repeater.html(new_repeater.html().replace(/{AID}/g, value['av']));
    if(typeof pinger !== 'undefined' 
        && typeof pinger['notifications'] !== 'undefined' 
        && jQuery.inArray( value['p'], pinger['notifications'] ) != -1
      ){
      new_repeater.html(new_repeater.html().replace(/{NewImg}/g, $('#chatlist_repeater_new').html()));
    }
    new_repeater.html(new_repeater.html().replace(/{NewImg}/g, ''));
    $('#chatlist_display').append(new_repeater);
    new_repeater.show();
  });
  $.each(current_all_friends, function(key, value){
    if(jQuery.inArray( value['p'], diff ) != -1){
      var new_repeater = $('#chatlist_repeater_off').clone();
      new_repeater.attr('id', '');
      new_repeater.html(new_repeater.html().replace(/{User}/g, value['u']));
      new_repeater.html(new_repeater.html().replace(/{PID}/g, value['p']));
      new_repeater.html(new_repeater.html().replace(/{AID}/g, value['av']));
      if(typeof pinger !== 'undefined' 
          && typeof pinger['notifications'] !== 'undefined' 
          && jQuery.inArray( value['p'], pinger['notifications'] ) != -1
        ){
        new_repeater.html(new_repeater.html().replace(/{NewImg}/g, $('#chatlist_repeater_new').html()));
      }
      new_repeater.html(new_repeater.html().replace(/{NewImg}/g, ''));
      $('#chatlist_display').append(new_repeater);
      new_repeater.show();
    }
  });
  setTimeout('updateChatlistMenu();', 1000);
};

$(document).ready(function(){
  $.getJSON('/friend.php', {friends: ''}, function(data){
    current_all_friends = data;
  });
  updateChatlistMenu();
});
</script>
<? //editable below this line:
   //leave id names and "display: none;" ?>
<style>

</style>
<div style="width: 200px;height: 400px auto;" class="container">
  <div id='chatlist_msg_display'></div>
  <div id='chatlist_display'></div>
  <div id='chatlist_repeater_on' style='display: none;'>
    <div class="ui-widget-content ui-state-default ui-corner-all" pid="msg{PID}" onclick="openChatBoxInstance('{User}', '{PID}', '{AID}');" style="cursor: pointer;"><img height="10" width="10" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAJUlEQVQI12NkYGBgYPzP+58BCv4zfmZkRBaAASYGLACrICM2MwE9GQoUaURE9wAAAABJRU5ErkJggg==" alt="Green dot" /> {User} {NewImg}</div>
    
  </div>
  <div id='chatlist_repeater_off' style='display: none;'>
    <div class="ui-widget-content ui-state-default ui-corner-all" pid="msg{PID}" onclick="openChatBoxInstance('{User}', '{PID}', '{AID}');" style="cursor: pointer;"><img height="10" width="10" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4gUXARIzVJCLjQAAACVJREFUCNdjZGBgYNi2bdt/Bijw8vJiZEQWgAEmBiwAqyAjNjMBr9cLKbX1SDEAAAAASUVORK5CYII=" alt="Grey dot" /> {User} {NewImg}</div>
    
  </div>
  <div id='chatlist_repeater_new' style='display: none;'>
  <img height="10" width="10" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAMklEQVQI12NkYGBg+Psh+j8DEmBEFzhjfY+BCcaA0SZHlRAqYQIMDAwMjOhmMgssZQQA1rUXpv0giaQAAAAASUVORK5CYII=" alt="New Message" />
  </div>

 
</div>

<br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br>