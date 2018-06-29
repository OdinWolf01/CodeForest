<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>


<?php 
/*
var audio = new Audio('/path/to/audio/file.mp3');
audio.play();
*/

?>



<script>
/*
document.getElementById('yourAudioTag').play();
*/
</script>

<script>
function openIncommingDisplay(){
  var divtemp = $('#incomming_template').clone();
  divtemp.attr('id','');
  if(typeof pinger !== 'undefined' && typeof pinger['notifications'] !== 'undefined' ){
    divtemp.html(divtemp.html().replace(/{MessageCount}/g, ''+pinger['notifications'].length));
  }
  divtemp.html(divtemp.html().replace(/{MessageCount}/g, ''));
  $('#incomming_display').empty();
  $('#incomming_display').append(divtemp);
  divtemp.show();
  setTimeout('openIncommingDisplay()', 1000);
}

$(document).ready(function(){
  openIncommingDisplay();
});
</script>

<style>
	.badge-danger{
		color: ;
		
		height: 18px;
		width: 18px;
		border-radius: 50%;
		text-align: center;
		opacity: 0.9;
		clear: both;
		top: 5px;
		left: 640px;
		font-size: 18px;
		padding: 2px;
	}
	i{
		z-index: -3;
	}







.dropbtn {
    
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}



.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: ;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}









</style>

<div id='incomming_display'></div>
<div id='incomming_template' style='display: none;'>
<i onclick="dropFunction()" style="font-size: 28px;color:black ;" class="fa fa-bell  dropbtn"></i> 

<div id="Dropdown" class="dropdown-content">
    <a href="#home">who </a>
    <a href="#about">sent</a>
    <a href="#contact">the mssg or friend request?</a>
  </div>

<div class="badge badge-danger" style="position: relative; left: -15px; top: -6px;">{MessageCount}</div>
</div>







<script>

function dropFunction() {
    document.getElementById("Dropdown").classList.toggle("show");
}


window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>