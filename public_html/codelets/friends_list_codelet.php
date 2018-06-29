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
  $('#friends_list_display').empty();
<?
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false){
  echo "  $.getJSON('/friend.php', {'friends': ".'"'.$_GET['id'].'"'."}, function(data){".PHP_EOL;
}else{
  echo "  $.getJSON('/friend.php', {'friends': ''}, function(data){".PHP_EOL;
}
?>
    $.each(data, function(key, value){
      var new_repeater = $('#friends_list_repeater').clone();
      new_repeater.attr('id', '');
      new_repeater.html(new_repeater.html().replace(/{User}/g, value['u']));
      new_repeater.html(new_repeater.html().replace(/{PID}/g, value['p']));
      new_repeater.html(new_repeater.html().replace(/{AID}/g, value['av']));
      $('#friends_list_display').append(new_repeater);
      new_repeater.show();
    });
  });
  $('#friends_list_display').show();
});
</script>
<? //editable below this line:
   //leave id names and "display: none;" ?>
<style>

</style>
<div id='friends_list_display' class="row" style='display: none;'>
</div>
<div id='friends_list_repeater' class="col-sm-4" style='display: none;'>
  <figure>
    <a href="/profile.php?id={PID}">
      <img style="margin: 20px 70px 40px;" class="img-circle" src="/avatar.php?pic={AID}" alt="avatar" width="100px" height="100px" >
      <p style="text-align: center;">{User}</p>
    </a>
    <div align="center">
      <figcaption>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn-primary">Message</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-danger">Unfriend</button></figcaption>
    </div>
  </figure>
</div>
