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
});
</script>
<? //editable below this line:
   //leave id names and "display: none;" ?>
   <!--
<style>
@media (max-width: 768px) {
  .ui-widget-header {
    padding-top: .425rem;
    padding-left: 0.75rem;
  }
  

@media (max-width: 767px) {
  .ui-widget-header {
    overflow: hidden;
    clear: both;
  }
}


nav-link {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    }

nav-link:hover {
    background-color: #ddd;
    color: black;
}

s
</style>
<script src="/vendor/js/jquery-mobile.min.js"></script>
<nav class="ui-tabs ui-corner-all ui-widget ui-widget-content"></nav>
-->

<style>
  a:hover{
    background-color: grey;
  }

@media (max-width: 767px) {
  .ui-widget-header {
    overflow: hidden;
    clear: both;
  }
}

</style>



<nav style="border: 1px solid white;"  class="ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header ">


    
    <!--<img class="img-circle" alt="avatar" src="/avatar.php?pic=<? echo $_SESSION['avatarID']; ?>" width="200px" height="200px">-->






 <ul style="justify-content: center" class="nav">
  <li  class="nav-item">
    <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/friends_search_codelet.php'); ?>
  </li>&nbsp;&nbsp;

   <a ><img class="img-circle" alt="avatar" src="/avatar.php?pic=<? echo $_SESSION['avatarID']; ?>" width="40px" height="40px"></a>
  <li  class="nav-item">
    
 <a  class="nav-link active" href="/index.php"><? echo $_SESSION['username']; ?>
   

   </a>
  </li>&nbsp;&nbsp;&nbsp;&nbsp;
 
  <li class="nav-item">
    <a href=""><? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/incomming_codelet.php'); ?></a>
  </li>&nbsp;&nbsp;
  <li class="nav-item">
   <a  class="nav-link" href="/logout.php"><i class="fa fa-power-off"></i>Logout</a>
  </li>&nbsp;&nbsp;
</ul>
</nav>






<script>
  

</script>