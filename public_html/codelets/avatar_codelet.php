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
  $('#avtr_photo').show();
});



$(window).scroll(function(event){
    didScroll = true;
});

var height = $("#avtr_photo").height() - $("#avtr_photo").height();

        $(window).scroll(function(){
            
            if($(this).scrollTop() > height) {
                $("#avtr_photo").css({'display': 'none'});
            }
        });


//$(window).scroll(function(){
           // if($(this).scrollTop() > 100 {

               // $('#avtr_photo').hide();
         //   }
       // });




</script>
<? //editable below this line:
   //leave id names and "display: none;" ?>
<style>

.image2 {
  position: absolute;
  margin:auto;
  top:55%;
  right:88%;
  bottom:auto;
  left:5%;
  display: flex;
  flex: 1;
  z-index: 100;
}

.img-circle {
  border-radius: 50%;
  border: 1px dotted white;
}
</style>
 
<div id='avtr_photo' class='image2' style='display: none;height:200px;width:200px;'>
<img class="img-circle"  alt="avatar" width="200px" height="200px" src="/avatar.php?pic=<?
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false ){
  if(isset($other_avatarID) && $other_avatarID !== false)
    echo $other_avatarID;
}else if(isset($_SESSION['username'])){
  $aid = pdo_get_avatarID_from_username($_SESSION['username']);
  if($aid !== false){
    echo $aid;
  }
}
?>" >
</div>