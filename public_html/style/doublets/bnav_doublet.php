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
<?
//if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false){
//  echo "  $.getJSON('/profile_info.php', {'id': ".'"'.$_GET['id'].'"'."}, function(data){".PHP_EOL;
//}else{
//  echo "  $.getJSON('/profile_info.php', function(data){".PHP_EOL;
//}
?>
  $("#bnav_display").tabs();
  $("#ui-id-6").off('click');
  $("#ui-id-6").click(function(){ window.location.href = '/my_desktop.php'; });
  $("#bnav_display").show();
});
<? //editable below this line:
   //leave id names and "display: none;" ?>

</script>








<style>
* {
    box-sizing: border-box;
}


.column {
    float: left;
    width: 33.33%;
    padding: 10px;
    height: 300px; /* Should be removed. Only for testing  */
    
}


.row:after {
    content: "";
    display: table;
    clear: both;
}
</style>




<div class="row">
  <div class="column" style="border: 1px solid red;width: 200px;">
    <br>

    
    
   
  
  </div>





  <div class="column" style="border: 1px solid red;">
    
  </div>



  <div class="column" style="border: 1px solid red;width: 200px;">
    
  </div>
</div>








<!--  testing -->



<p>
  <p>
<br>
<div class="row">
  <div class="column" style="border: 1px solid red;margin: 1px;width: 200px;">
    <br>

    
    
    
  
  </div>





  <div class="column" style="border: 1px solid red;margin: 1px;">
    
  </div>



  <div class="column" style="border: 1px solid red;width: 200px;">
    
  </div>
</div>

</p>
</p>











<br>
<br><br><br><br>
<br>
<br><br><br><br>
<br>
<br><br><br><br>
<br>
<br><br><br><br>
<br>
<br><br><br><br>
<br>
<br><br><br><br>
<br>
<br><br><br><br>
<br>
<br><br><br><br>