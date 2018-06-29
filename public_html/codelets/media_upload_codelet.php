<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
var mediafiles;

function prepMediaUL(e) {
  mediafiles = e.target.files;
}

$(document).ready(function(){
  $('#media_level').selectmenu();
  $('#media_upload_file').change(prepMediaUL);
  $('#media_upload').show();
  $('#media_upload_btn').click(function(e){
    e.preventDefault();
    var data = new FormData();
    $.each(mediafiles, function(i, file) {
      data.append(''+i, file);
    });
    data.append('level', $('#media_level').val());
<?
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false){
?>
    data.append('target', '<? echo $_GET['id']; ?>');
<?
}
?>
    $.ajax({
      url: '/media.php',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      type: 'POST',
      success: function(){
        $('#media_upload_file').val('');
      }
    });
  });
  //$('#media_level').selectmenu({'width': '130px'});
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
   
</script>
<style>
#select{
  width: 130px;
}
</style>
<div  id='media_upload' style='display: none;'>
  <input class='ui-button ui-corner-all' id='media_upload_file' type="file" />
  <input id='media_upload_btn' class='ui-button ui-corner-all' type='button' value='Add' />
  <select class="select" id='media_level'>
    <option value="0">Private</option>
    <option value="1">Friends</option>
    <option value="all">Public</option>
  </select>
</div>
