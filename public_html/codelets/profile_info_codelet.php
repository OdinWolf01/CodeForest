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
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false){
  echo "  $.getJSON('/profile_info.php', {'id': ".'"'.$_GET['id'].'"'."}, function(data){".PHP_EOL;
}else{
  echo "  $.getJSON('/profile_info.php', function(data){".PHP_EOL;
}
?>
    var ts = new Date(data['acctCreate']*1000);
    ts = monthName(ts.getMonth())+' '+ts.getDate()+', '+ts.getFullYear()
    $('#prof_info').html($('#prof_info').html().replace(/{User}/g, data['username']));
    $('#prof_info').html($('#prof_info').html().replace(/{FullName}/g, data['fullname']));
    $('#prof_info').html($('#prof_info').html().replace(/{Location}/g, data['location']));
    $('#prof_info').html($('#prof_info').html().replace(/{Schooling}/g, data['schooling']));
    $('#prof_info').html($('#prof_info').html().replace(/{Profession}/g, data['profession']));
    $('#prof_info').html($('#prof_info').html().replace(/{Company}/g, data['company']));
    $('#prof_info').html($('#prof_info').html().replace(/{Hobbies}/g, data['hobbies']));
    $('#prof_info').html($('#prof_info').html().replace(/{AboutMe}/g, data['aboutme']));
    $('#prof_info').html($('#prof_info').html().replace(/{StartDate}/g, ts));
    if(data['relationshipstatus']){
      if(data['relationshipstatus'] == 'a'){
        $('#prof_info').html($('#prof_info').html().replace(/{RelationshipStatus}/g, 'Not Applicable'));
      }else if(data['relationshipstatus'] == 'b'){
        $('#prof_info').html($('#prof_info').html().replace(/{RelationshipStatus}/g, 'Single And Looking'));
      }else if(data['relationshipstatus'] == 'c'){
        $('#prof_info').html($('#prof_info').html().replace(/{RelationshipStatus}/g, 'Single And Not Looking'));
      }else if(data['relationshipstatus'] == 'd'){
        $('#prof_info').html($('#prof_info').html().replace(/{RelationshipStatus}/g, 'In A Relationship'));
      }else if(data['relationshipstatus'] == 'e'){
        $('#prof_info').html($('#prof_info').html().replace(/{RelationshipStatus}/g, 'Married'));
      }else if(data['relationshipstatus'] == 'f'){
        $('#prof_info').html($('#prof_info').html().replace(/{RelationshipStatus}/g, 'Divorced'));
      }else if(data['relationshipstatus'] == 'g'){
        $('#prof_info').html($('#prof_info').html().replace(/{RelationshipStatus}/g, 'It&apos;s Complicated'));
      }
      $('#relstat').val(data['relationshipstatus']);
    }else{
      $('#relstat').val('a');
    }
    $('#prof_info').html($('#prof_info').html().replace(/{RelationshipStatus}/g, ''));
    $('#prof_info').show();
  });
});
</script>
<? //editable below this line:
   //leave id names and "display: none;" ?>
  
<style>
#prof_info ul li {
  list-style: none;
  list-style-type: none;
}
#prof_info select {
  width: 15em;
}


code {
    font-family: Consolas, Monaco, Courier New, Courier, monospace;
    font-size: 28px;
    background-color: grey;
    border: 1px solid ;
    border-radius: 10%;
    display: block;
    margin: 14px 0 14px 0;
    padding: 12px 10px 12px 10px;
  }


</style>
<br>
<br>
<br>
<br>
<div class="card-header"><label class="control-label">Profile Info</label></div>
<br>
<br>
<div  id='prof_info' style='display: none;'>
<ul>
<li>
  <p> {User}
    <label class="control-label" for="{StartDate}">Member Since:</label>
<span > {StartDate}</span>
</p>
</li>
  <br>
    <li >
     
      
         <p>
          <label class="control-label" for="{FullName}">Name:</label>
      <span > &nbsp; {FullName} </span>
      </p>
    
    </li>
    <br>
      
      <li>
         <p>
          <label class="control-label" for="{Location}">Where:</label>
      <span> {Location}</span>
    </p>
    
    </li>
    <br>
    <li>
      
      <p>
        <label class="control-label" for="{Schooling}">School:</label>
      <span> {Schooling}</span>
  </p>
    
    </li>
    <br>
    <li>
      
      <p>
        <label class="control-label" for="{Profession}">Job:</label>
      <span> {Profession}</span>
  </p>
    
    </li>
    <br>
    <li>
      
      <p>
        <label class="control-label" for="{Company}">Company:</label>
      <span> {Company}</span>
  </p>
   
    </li>
    <br>
    <li>
      
      <p>
        <label class="control-label" for="{Hobbies}">Hobby:</label>
      <span> {Hobbies}</span>
  </p>
    
    </li>
    <br>
    <li>
      
      <p>
        <label class="control-label" for="{AboutMe}">About:</label>
      <span> {AboutMe}</span>
  </p>
   
    </li>
    <br>
    <li>
      
      <p>
        <label class="control-label" for="{RelationshipStatus}">Relationship:</label>
      <span> {RelationshipStatus}</span>
  </p>
   
    </li>
    <br>
  </ul>
</div>
<div class="card-footer" width="200px"><img src="/wave.php" alt="gif" width="250px" height="30px"></div>