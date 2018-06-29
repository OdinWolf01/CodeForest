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
  $('#posts_send').show();
  $('#posts_send_btn').click(function(){
<?
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false){
?>
    $.post('/comments.php', {'mssg_body': $('#posts_send_msg').val(), 'target': '<? echo $_GET['id']; ?>'}, function(){
<?
}else{
?>
    $.post('/comments.php', {'mssg_body': $('#posts_send_msg').val()}, function(){
<?
}
?>
      $('#posts_send_msg').val('');
      updatePostDisplay();
    });
  });
  $("#posts_send_msg").keypress(function(e) {
    if(13 === e.which)
      $("#posts_send_btn").click();
  });
  //$('#posts_send_msg').click(function(){ highlight(); });
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>



<!--    ////////////////////////////START/////////////////////////////////////////  -->

<?php
function uploadFile ($file_field = null, $check_image = false, $random_name = false) {

$path = 'uploads/'; 
$max_size = 1000000;/// kdodge  idk  what the file size should be lol
// and maybe im over steping here  you may already have something in place 4  this
// but  if  so just comment out or  delete this php  code man lol 
//  i tried hahaha  lmao  but i was wanting to try to post a photo
// idk  if i need another  db table or if you have something in place 4 this 
// or not  just look  over this code  tell me  what you think brother ty :)//

$whitelist_ext = array('jpeg','jpg','png','gif');

$whitelist_type = array('image/jpeg', 'image/jpg', 'image/png','image/gif');


$out = array('error'=>null);

if (!$file_field) {
  $out['error'][] = "Please specify a valid form field name";           
}

if (!$path) {
  $out['error'][] = "Please specify a valid upload path";               
}

if (count($out['error'])>0) {
  return $out;
}

// i think i did this right  to make sure file is  there ??  lol
if((!empty($_FILES[$file_field])) && ($_FILES[$file_field]['error'] == 0)) {

// get filename
$file_info = pathinfo($_FILES[$file_field]['name']);
$name = $file_info['filename'];
$ext = $file_info['extension'];

          
if (!in_array($ext, $whitelist_ext)) {
  $out['error'][] = "Invalid file Extension";
}


if (!in_array($_FILES[$file_field]["type"], $whitelist_type)) {
  $out['error'][] = "Invalid file Type";
}


if ($_FILES[$file_field]["size"] > $max_size) {
  $out['error'][] = "File is too big";
}


if ($check_image) {
  if (!getimagesize($_FILES[$file_field]['tmp_name'])) {
    $out['error'][] = "Uploaded file is not a valid image";
  }
}


if ($random_name) {
  
  $tmp = str_replace(array('.',' '), array('',''), microtime());

  if (!$tmp || $tmp == '') {
    $out['error'][] = "File must have a name";
  }     
  $newname = $tmp.'.'.$ext;                                
} else {
    $newname = $name.'.'.$ext;
}


if (file_exists($path.$newname)) {
  $out['error'][] = "A file with this name already exists";
}

if (count($out['error'])>0) {
  
  return $out;
} 

if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $path.$newname)) {
  
  $out['filepath'] = $path;
  $out['filename'] = $newname;
  return $out;
} else {
  $out['error'][] = "Server Error!";
}

 } else {
  $out['error'][] = "No file uploaded";
  return $out;
 }      
}


if (isset($_POST['submit'])) {
 $file = uploadFile('file', true, true);
 if (is_array($file['error'])) {
  $message = '';
  foreach ($file['error'] as $msg) {
  $message .= '<p>'.$msg.'</p>';    
 }
} else {
 $message = "File uploaded successfully".$newname;
}
 echo $message;
}



?>



<!--  ////////////////////////////////END///////////////////////////////////// -->


<style>
</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">




<div id="status-overlay" style="display: none"></div>
<div id='posts_send' align='center' class="form-group" style='display: none;'>
  <textarea id='posts_send_msg' name="postText" class="ui-widget ui-state-default ui-corner-all" cols="10" rows="3" placeholder="Got Something To Say ?">

  </textarea>
   <p>
<nav style="line-height: 35px;" class="ui-tabs ui-corner-all ui-widget ui-widget-content">
  <button><i style="color: black;" class="fa fa-upload"></i></button>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<input name="file" type="file" id="imagee" />
<input name="submit" type="submit" value="Upload" />
</form>








  <button></button>
  <button></button>
  <button></button>
  <button></button>
  <button></button>
   <input style="float: right;" id='posts_send_btn' class="ui-button ui-corner-all" type="button" value="Post">
</nav>


 </p>
 
</div>


<!--
<div id='posts_send' style='display: none;'>
  <input id='posts_send_msg' type='text' placeholder='Got Something To Say?'></input>
  <input type='button' value='Post'></input>
</div>
-->