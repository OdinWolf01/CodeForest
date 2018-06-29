<?php 

include_once ('includes/config.php');
if (!$user->is_logged_in()) {header('Location: login.php');exit();}

/*
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" crossorigin="anonymous"></script>
<script>
var files;

$('input[type=file]#avtr').on('change', prepareUpload);

function prepareUpload(e) {
  files = e.target.files;
}
$('input[type=file]#bgrnd').on('change', prepareUpload);

function prepareUpload(e) {
  files = e.target.files;
}

$('#avatarupload').submit(function(){
  e.preventDefault();
  var data = new FormData();
  $.each(files, function(key, value) {
    data.append(key, value);
  });
  $.post("avatar.php", data, function(data){
    if (typeof data.error === 'undefined') {
      $('div#upload_result').empty().append(data);
    }
  }, 'html');
});
</script>
*/
?>

<div style="text-align:center;">
<button class="btn btn-primary" id="myBtn">Change Profile Settings</button>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">


  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>change profile and cover photo here </p>
    <span>Change your profile picture</span>
<form id="avatarupload">
  <input type="file" id="avtr">
  <input type="hidden" name="loaded">
  <input id="avataruploadbtn" type="button" value="Upload Avatar">
</form>

<br><br>
<span>Change your background</span>
<form id="backgroundupload">
  <input type="file" id="bgrnd">
  <input type="hidden" name="loaded">
  <input  type="submit" value="Upload Background">
</form>



<script>

// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>

  </div>

</div>
<br>
<br>
<div class="container">
<h3>Edit Profile</h3>

<script>
$(document).ready(function(){
  $('#theme_menu').selectmenu({
    select: function(event, ui){
      event.preventDefault();
      
      $.post('/theme.php', {theme: event.currentTarget.innerText}, function(){
      	alert('theme changed to: '+event.currentTarget.innerText+'. refresh page to view results.');
      });
    }
  });
});
</script>
<section>
<label for="profileinfotheme">Theme: </label>
<select id="theme_menu">
  <option>base</option>
  <option>black-tie</option>
  <option>blitzer</option>
  <option>cupertino</option>
  <option>dark-hive</option>
  <option>dot-luv</option>
  <option>eggplant</option>
  <option>excite-bike</option>
  <option>flick</option>
  <option>hot-sneaks</option>
  <option>humanity</option>
  <option>le-frog</option>
  <option>mint-choc</option>
  <option>overcast</option>
  <option>pepper-grinder</option>
  <option>redmond</option>
  <option>smoothness</option>
  <option>south-street</option>
  <option>start</option>
  <option>sunny</option>
  <option>swanky-purse</option>
  <option>trontastic</option>
  <option>ui-darkness</option>
  <option>ui-lightness</option>
  <option>vader</option>
</select>
</section>
<br />

  <label for="profileinfofullname">Full Name: </label><input class="form-control" type="text" id="profileinfofullname" name="profileinfofullname" value="">
  <label for="profileinfolocation">Location: </label><input class="form-control" type="text" id="profileinfolocation" name="profileinfolocation" value="">
  <label for="profileinfoschooling">Schooling: </label><input class="form-control" type="text" id="profileinfoschooling" name="profileinfoschooling" value="">
  <label for="profileinfoprofession">Profession: </label><input class="form-control" type="text" id="profileinfoprofession" name="profileinfoprofession" value="">
  <label for="profileinfocompany">Company: </label><input class="form-control" type="text" id="profileinfocompany" name="profileinfocompany" value="">
  <label for="profileinfohobbies">Hobbies: </label><input class="form-control" type="text" id="profileinfohobbies" name="profileinfohobbies" value="">
  <label for="profileinfoaboutme">About Me: </label><input class="form-control" type="text" id="profileinfoaboutme" name="profileinfoaboutme" value="">
  <label for="profileinforelationshipstatus">Relationship Status: </label>
  <select class="form-control" id="profileinforelationshipstatus" name="profileinforelationshipstatus">
    <option value="a">None</option>
    <option value="b">Single And Looking</option>
    <option value="c">Single And Not Looking</option>
    <option value="d">In A Relationship</option>
    <option value="e">Married</option>
    <option value="f">Divorced</option>
    <option value="g">It&apos;s Complicated</option>
    <option value="h">It&apos;s Really Complicated</option>
    <option value="i">It&apos;s Really, Really Complicated</option>
    <option value="j">It&apos;s Really, Really, Really Complicated</option>
  </select>
  <input class="btn btn-success" type="button" id="profileinfosave" value="Save">

</div>





<?php require "layout/footer.php"?>