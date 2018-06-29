<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>
<script>
function updatePostDisplay(){
  $('#post_list_display').empty();
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
      new_repeater.html(new_repeater.html().replace(/{Likes}/g, value['likes']));
      new_repeater.html(new_repeater.html().replace(/{Dislikes}/g, value['dislikes']));
      $('#post_list_display').append(new_repeater);
      $('#post'+value['pid']).click(function(){ $.post('/comments.php', {delete: $(this).attr('postid')}, function(){ }); });
      new_repeater.show();
    });
  });
  $('#post_list_display').show();
}

function postsDisplayCheckLoop(){
  if(pinger['require_post_update'] === true){
    updatePostDisplay();
    pinger['require_post_update'] = 'waiting';
  }
  setTimeout('postsDisplayCheckLoop();', 1000);
};

$(document).ready(function(){
  updatePostDisplay();
  postsDisplayCheckLoop();
  $('#post_list_base').html($('#post_list_base').html().replace(/{PrimaryUser}/, '<? echo $_SESSION['username']; ?>'));
  $('#post_list_base').html($('#post_list_base').html().replace(/{PrimaryAID}/, '<? $aid = pdo_get_avatarID_from_username($_SESSION['username']); if($aid !== false) echo $aid; ?>'));
  $('#post_list_base').show();
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>
<style>

/*
.speech-bubble {
	position: relative;
	background: #00aabb;
	border-radius: .3em;
}

.speech-bubble:after {
	content: '';
	position: absolute;
	left: 0;
	top: 50%;
	width: 0;
	height: 0;
	border: 19px solid transparent;
	border-right-color: #00aabb;
	border-left: 0;
	border-top: 0;
	margin-top: -9.5px;
	margin-left: -19px;
}
*/


 
  ::-webkit-scrollbar {
    width: 10px;
}


::-webkit-scrollbar-track {
    background: #f1f1f1; 
}
 

::-webkit-scrollbar-thumb {
    background: #888;/*black; */
}


::-webkit-scrollbar-thumb:hover {
    background: #555; 
}


</style>











<div id='post_list_base'  style='display: none;height: 5%;'>
  
    
  </div>
 
    <div style="padding: 10px;height: 435px; overflow: scroll; overflow-x: hidden;" class="postresult">
    
      
      <div  class="comments-container"></div>
    
     
      <h1>..... <a href="#">.....</a></h1>
       <div class="list-group">
      <ul  id="comments-list" class="comments-list"></ul>
         </div>
      <div id='post_list_display' style='display: none;'></div> 
      <div id='post_list_repeater' style='display: none;'>
     
        <p>
        </p>
        <div class="list-group"> 
        <div class="singlecomment">
        </div>
        <h6><a href="/profile.php?id={ProID}"><img class="img-circle" width="60px" height="60px" src="/avatar.php?pic={AID}"> {User}:</a> {SecondsAgo}:</h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{Message} <span class="text-danger" id='post{PID}' postid='{PID}' style="cursor: pointer;" onclick=>…</span>
        </div>
            Likes: {Likes}, Dislikes: {Dislikes}
            <button class="btn btn-outline-success" onclick="$.post('/likes.php', {r: '{PID}', t: 'like', s: 'post'}); pinger['require_post_update'] = true;">Like</button>
            <button class="btn btn-outline-success" onclick="$.post('/likes.php', {r: '{PID}', t: 'dislike', s: 'post'}); pinger['require_post_update'] = true;">Dislike</button>
            <button class="btn btn-outline-success" onclick="$('#reply{PID}').show()">Reply</button>
            <br><br>

            <input type="text" id="reply{PID}" class="form-control" onblur="$(this).hide();" placeholder="comment" style="display: none;">
            <? require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/emojis/emoji.php'); ?>

            <hr>
          </div>
        </div>