<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
var aimgfiles;
var bimgfiles;

function prepImgULa(e) {
  aimgfiles = e.target.files;
}

function prepImgULb(e) {
  bimgfiles = e.target.files;
}

$(document).ready(function(){
  $('#setrelstat').selectmenu();
  $("#edit_settings_btn").button();
  $('#theme_menu').selectmenu();
  $('#theme_menu').val('<? $theme = pdo_get_theme($_SESSION['memberID']); if($theme !== false){ echo $theme; }else{ echo 'base'; } ?>');
  $('#theme_menu').selectmenu('refresh');
  $('#theme_menu').keypress(function(){
    alert('button');
  });
  $('#avr_upload_file').change(prepImgULa);
  $('#bg_upload_file').change(prepImgULb);
  $.getJSON('/profile_info.php', function(data){
    $('#edit_settings').html($('#edit_settings').html().replace(/{FullName}/, data['fullname']));
    $('#edit_settings').html($('#edit_settings').html().replace(/{Location}/, data['location']));
    $('#edit_settings').html($('#edit_settings').html().replace(/{Schooling}/, data['schooling']));
    $('#edit_settings').html($('#edit_settings').html().replace(/{Profession}/, data['profession']));
    $('#edit_settings').html($('#edit_settings').html().replace(/{Company}/, data['company']));
    $('#edit_settings').html($('#edit_settings').html().replace(/{Hobbies}/, data['hobbies']));
    $('#edit_settings').html($('#edit_settings').html().replace(/{AboutMe}/, data['aboutme']));
    if(data['relationshipstatus'])
      $('#setrelstat').val(data['relationshipstatus']);
    else
      $('#setrelstat').val('a');
    $('#setrelstat').selectmenu("refresh");
    $('#edit_settings').show();
    $('#relstatul').show();
    $("#edit_settings_btn").show();
  });
  $("#edit_settings_btn").click(function(){
    $.post('/profile_info.php', {'relationshipstatus': $.trim($('#setrelstat').val())});
    $.post('/theme.php', {'theme': $.trim($('#theme_menu').val())});
    $.post('/profile_info.php', {'fullname': $('#edit_settings').find('input[name="fullname"]').val()});
    $.post('/profile_info.php', {'location': $('#edit_settings').find('input[name="location"]').val()});
    $.post('/profile_info.php', {'schooling': $('#edit_settings').find('input[name="schooling"]').val()});
    $.post('/profile_info.php', {'profession': $('#edit_settings').find('input[name="profession"]').val()});
    $.post('/profile_info.php', {'company': $('#edit_settings').find('input[name="company"]').val()});
    $.post('/profile_info.php', {'hobbies': $('#edit_settings').find('input[name="hobbies"]').val()});
    $.post('/profile_info.php', {'aboutme': $('#edit_settings').find('input[name="aboutme"]').val()});
    var dataa = new FormData();
    $.each(aimgfiles, function(i, file) {
      dataa.append(''+i, file);
    });
    $.ajax({
      url: '/avatar.php',
      data: dataa,
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      type: 'POST',
      success: function(){ }
    });
    var datab = new FormData();
    $.each(bimgfiles, function(i, file) {
      datab.append(''+i, file);
    });
    $.ajax({
      url: '/background.php',
      data: datab,
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      type: 'POST',
      success: function(){ }
    });
    setTimeout('location.reload();', 2000);
  });
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>
<style>
#edit_settings ul li {
  list-style: none;
  list-style-type: none;
}
#edit_settings select {
  width: 11em;
}

</style>
  <ul class="form-group" id="relstatul" style="list-style: none; display: none;">
    <li>
      Relationship: <p></p><select id="setrelstat">
        <option value="a">Not Applicable</option>
        <option value="b">Single And Looking</option>
        <option value="c">Single And Not Looking</option>
        <option value="d">In A Relationship</option>
        <option value="e">Married</option>
        <option value="f">Divorced</option>
        <option value="g">It&apos;s Complicated</option>
      </select>
    </li>
    <li>
      Theme: <p></p><select id="theme_menu">
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
    </li>
  </ul>
<div id='edit_settings' style='display: none;'>
  <ul class="form-group">
    <li>
      Name: <input class="form-control ui-widget ui-state-default ui-corner-all" type="text" name="fullname" value="{FullName}" ></input>
    </li>
    <li>
      Where: <input class="form-control ui-widget ui-state-default ui-corner-all" type="text" name="location" value="{Location}"></input>
    </li>
    <li>
      School: <input class="form-control ui-widget ui-state-default ui-corner-all" type="text" name="schooling" value="{Schooling}"></input>
    </li>
    <li>
      Job: <input class="form-control ui-widget ui-state-default ui-corner-all" type="text" name="profession" value="{Profession}"></input>
    </li>
    <li>
      Company: <input class="form-control ui-widget ui-state-default ui-corner-all" type="text" name="company" value="{Company}"></input>
    </li>
    <li>
      Hobby: <input class="form-control ui-widget ui-state-default ui-corner-all" type="text" name="hobbies" value="{Hobbies}"></input>
    </li>
    <li>
      About: <input class="form-control ui-widget ui-state-default ui-corner-all" type="text" name="aboutme" value="{AboutMe}"></input>
    </li>
  </ul>
</div>
<ul class="form-group" style="list-style: none; ">
  <li>
    Avatar: <input class='ui-button ui-corner-all' id='avr_upload_file' type="file" /> 
  </li>
  <li>
    <hr>
  </li>
  <li>
    Background: <input class='ui-button ui-corner-all' id='bg_upload_file' type="file" />
  </li>
  <li>
    <p></p><button class="ui-button  ui-corner-all" id="edit_settings_btn" style="display: none;">SAVE</button>
  </li>
</ul>