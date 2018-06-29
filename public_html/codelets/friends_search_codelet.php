<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/halflets/fr_display_halflet.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
$(document).ready(function(){
  $('#friends_searchbar').show();
  $('#friends_searchbar_btn').click(function(event){
    $.post('/search.php', {'q': $('#friends_searchbar_text').val()}, function(data){
      $('#friends_searchbar_text').val('');
      openFrDisplayPulldownMenu(event, data);
    }, 'json');
  });
  $("#friends_searchbar_text").keypress(function(e) {
    if(13 === e.which)
      $("#friends_searchbar_btn").click();
  });
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>
<td>
<div id='friends_searchbar' style='display: none;'>
<input style="border-radius: 6%;line-height: 25px;margin-top: 4px;margin-bottom: 4px;position: relative; " type='text' id='friends_searchbar_text' class='ui-widget-content ui-state-default ui-corners-all  ' placeholder="Find Friends">
<button style="border-radius: 8%;line-height: 15px;margin-top: 3px;margin-bottom: 3px;position: relative;" type='button' id='friends_searchbar_btn' class='#ui-button ui-state-default ui-corners-all  btn btn-outline-success'>SEARCH</button>
</div>
</td>
</div>

