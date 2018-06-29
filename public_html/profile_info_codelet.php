<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<style>
#prof_info {
  list-style: none;
  border: 1px solid;
}
</style>
<script>
function monthToChar(num){
if(num==0) return 'Jan'; else if(num==1) return 'Feb'; else if(num==2) return 'Mar'; else if(num==3) return 'Apr'; else if(num==4) return 'May'; else if(num==5) return 'Jun'; else if(num==6) return 'Jul'; else if(num==7) return 'Aug'; else if(num==8) return 'Sep'; else if(num==9)
  return 'Oct'; else if(num==10) return 'Nov'; else if(num==11) return 'Dec';
}
$(document).ready(function(){
<?
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false){
  echo "  $.getJSON('/profile_info.php', {'id': ".'"'.$_GET['id'].'"'."}, function(data){".PHP_EOL;
}else{
  echo "  $.getJSON('/profile_info.php', function(data){".PHP_EOL;
}
?>
    var ts = new Date(data['acctCreate']*1000);
    ts = monthToChar(ts.getMonth())+' '+ts.getDate()+', '+ts.getFullYear()
    var myhtml = $('#prof_info').html();
    $('#prof_info').html(myhtml.replace(/{FullName}/, data['fullname']));
    myhtml = $('#prof_info').html();
    $('#prof_info').html(myhtml.replace(/{Location}/, data['location']));
    myhtml = $('#prof_info').html();
    $('#prof_info').html(myhtml.replace(/{Schooling}/, data['schooling']));
    myhtml = $('#prof_info').html();
    $('#prof_info').html(myhtml.replace(/{Profession}/, data['profession']));
    myhtml = $('#prof_info').html();
    $('#prof_info').html(myhtml.replace(/{Company}/, data['company']));
    myhtml = $('#prof_info').html();
    $('#prof_info').html(myhtml.replace(/{Hobbies}/, data['hobbies']));
    myhtml = $('#prof_info').html();
    $('#prof_info').html(myhtml.replace(/{AboutMe}/, data['aboutme']));
    myhtml = $('#prof_info').html();
    $('#prof_info').html(myhtml.replace(/{StartDate}/, ts));
    if(data['relationshipstatus'])
    $('#relstat').val(data['relationshipstatus']);
    else
    $('#relstat').val('a');
    $('#prof_info').show();
  });
});
</script>
<div id='prof_info' class="card-contenet" style='display: none;'>
  <span>Member since php {StartDate} </span>
  <ul>
    <li>
      <span>{FullName}</span>
    </li>
    <li>
      <span>{Location}</span>
    </li>
    <li>
      <span>{Schooling}</span>
    </li>
    <li>
      <span>{Profession}</span>
    </li>
    <li>
      <span>{Company}</span>
    </li>
    <li>
      <span>{Hobbies}</span>
    </li>
    <li>
      <span>{AboutMe}</span>
    </li>
    <select id="relstat" disabled>
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
  </ul>
</div>
