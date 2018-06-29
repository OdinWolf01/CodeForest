<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
require_once($_SERVER['DOCUMENT_ROOT'].'/halflets/chatbox_halflet.php');
?>
<script>
function updateContactsMenu(){
  $('#contacts_display').empty();
  $.each(pinger['online_friends'], function(key, value){
    var new_repeater = $('#contacts_repeater').clone();
    new_repeater.attr('id', '');
    new_repeater.html(new_repeater.html().replace(/{User}/g, value['u']));
    new_repeater.html(new_repeater.html().replace(/{PID}/g, value['p']));
    new_repeater.html(new_repeater.html().replace(/{AID}/g, value['av']));
    if(typeof pinger !== 'undefined' 
        && typeof pinger['notifications'] !== 'undefined' 
        && jQuery.inArray( value['p'], pinger['notifications'] ) != -1
      ){
      new_repeater.html(new_repeater.html().replace(/{NewImg}/g, $('#contacts_repeater_new').html()));
    }
    new_repeater.html(new_repeater.html().replace(/{NewImg}/g, ''));
    $('#contacts_display').append(new_repeater);
    new_repeater.show();
  });
  setTimeout('updateContactsMenu();', 1000);
};

$(document).ready(function(){
  updateContactsMenu();
});
</script>
<? //editable below this line:
   //leave id names and "display: none;" ?>
<style>

</style>
 
<div style="width: 200px;height: 400px auto;" class="container">
  
  <div id='contacts_msg_display' style='border: 1px solid blue;'></div>

  <div id='contacts_display'></div>

  <div id='contacts_repeater' style='display: none; cursor: pointer;'>
    <div onclick="openChatBoxInstance('{User}', '{PID}', '{AID}');">
    <div class="ui-widget-content ui-state-default ui-corner-all"><img height="10" width="10" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAJUlEQVQI12NkYGBgYPzP+58BCv4zfmZkRBaAASYGLACrICM2MwE9GQoUaURE9wAAAABJRU5ErkJggg==" alt="Green dot" /> {User} {NewImg}</div>



   
    
  </div>
  </div>
  <div id='contacts_repeater_new' style='display: none;'>
  <img height="10" width="10" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAMklEQVQI12NkYGBg+Psh+j8DEmBEFzhjfY+BCcaA0SZHlRAqYQIMDAwMjOhmMgssZQQA1rUXpv0giaQAAAAASUVORK5CYII=" alt="New Message" />


  </div>
 
</div>
