



<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
function monthName(num){
if(num==0) return 'Jan'; else if(num==1) return 'Feb'; else if(num==2) return 'Mar'; else if(num==3) return 'Apr'; else if(num==4) return 'May'; else if(num==5) return 'Jun'; else if(num==6) return 'Jul'; else if(num==7) return 'Aug'; else if(num==8) return 'Sep'; else if(num==9) return 'Oct'; else if(num==10) return 'Nov'; else if(num==11) return 'Dec';
}
function getSecAgo(e) {
  var n = Math.floor((new Date).getTime() / 1e3 - e),
    o = Math.floor(n / 31536e3);
  return o > 0 ? 1 == o ? "1 year ago" : o + " years ago" : (o = Math.floor(n / 2628e3)) > 0 ? 1 == o ? "1 month ago" : o + " months ago" : (o = Math.floor(n / 86400)) > 0 ? 1 == o ? "1 day ago" : o + " days ago" : (o = Math.floor(n / 3600)) > 0 ? 1 == o ? "1 hour ago" : o + " hours ago" : (o = Math.floor(n / 60)) > 0 ? 1 == o ? "1 minute ago" : o + " minutes ago" : Math.floor(n) + " seconds ago"
}
function getAMorPM(num){
  return (num<12)?'AM':'PM';
}
function get12hour(num){
  return (num==0)?'12':(num>12)?''+(num-12):''+num;
}
function fixZeros(str){
  return ((''+str).length==1)?'0'+str:''+str;
}
$(document).ready(function(){
<?
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false){
  echo "  $.getJSON('/comments.php', {'view': ".'"'.$_GET['id'].'"'."}, function(data){".PHP_EOL;
}else{
  echo "  $.getJSON('/comments.php', {'view': ''}, function(data){".PHP_EOL;
}
?>
    $.each(data, function(key, value){
      var new_repeater = $('#post_list_repeater').clone();
      new_repeater.attr('id', '');
      var ts = new Date(value['ts']*1000);
      var ts1 = monthName(ts.getMonth())+' '+ts.getDate()+', '+ts.getFullYear();
      var ts2 = fixZeros(get12hour(ts.getHours()))+':'+fixZeros(ts.getMinutes())+':'+fixZeros(ts.getSeconds())+getAMorPM(ts.getHours());
      new_repeater.html(new_repeater.html().replace(/{TimeStamp}/g, value['ts']));
      new_repeater.html(new_repeater.html().replace(/{SecondsAgo}/g, getSecAgo(value['ts'])));
      new_repeater.html(new_repeater.html().replace(/{DateOnly}/g, ts1));
      new_repeater.html(new_repeater.html().replace(/{TimeOnly}/g, ts2));
      new_repeater.html(new_repeater.html().replace(/{Message}/g, value['text']));
      new_repeater.html(new_repeater.html().replace(/{User}/g, value['user']));
      new_repeater.html(new_repeater.html().replace(/{ProID}/g, value['proid']));
      new_repeater.html(new_repeater.html().replace(/{PID}/g, value['pid']));
      new_repeater.html(new_repeater.html().replace(/{AID}/g, value['aid']));
      $('#post_list_repeater').parent().append(new_repeater);
      $('#post'+value['pid']).click(function(){ $.post('/comments.php', {delete: $(this).attr('postid')}, function(){ alert($(this).attr('postid')); }); });
      new_repeater.show();
    });
  });
  $('#post_list_base').html($('#post_list_base').html().replace(/{PrimaryUser}/, '<? echo $_SESSION['username']; ?>'));
  $('#post_list_base').html($('#post_list_base').html().replace(/{PrimaryAID}/, '<? $aid = pdo_get_avatarID_from_username($_SESSION['username']); if($aid !== false) echo $aid; ?>'));
  $('#post_list_base').show();
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>
<style>
</style>
<div id='post_list_base' class='card' style='display: none;'>
  <div class="card-header">
    <h5><i class="fas fa-sticky-note"></i>&nbsp;{PrimaryUser}</h5>
  </div>
  <div class="card-body">
   <!-- <img class="img-circle" src="/avatar.php?pic={PrimaryAID}" alt="avatar" width="50px" height="50px">-->
    <div class="postresult">
      <div class="comments-container"></div>
      <h1>..... <a href="#">.....</a></h1>
      <ul id="comments-list" class="comments-list"></ul>
      <div id='post_list_repeater' style='display: none;'>
        <p>
        </p>
        <div class="singlecomment">
        <h6><a href="/profile.php?id={ProID}"><img class="img-circle" width="60px" height="60px" src="/avatar.php?pic={AID}"> {User}:</a> {SecondsAgo}:</h6>{Message} <span class="text-danger" id='post{PID}' postid='{PID}' style="cursor: pointer;">…</span>
        </div>
        <p>
        </p>
      </div>
    </div>
  </div>
</div>