<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {exit();}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<? require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php'); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/dot-luv/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<title>Document</title>
<script>
var current_friends_list = [];

function updateContactsMenu(){
  $('#testfriendsajax').empty();
  $.each(current_friends_list, function(key, value){
    var thisimg = img_gray;
    $.each(pinger['online_friends'], function(key2, value2){
      if(value2['u'] == value['u']){
        thisimg = img_green;
        //break;
      }
    });
    
    $('#testfriendsajax').append('<div class="ui-widget-content">'+ thisimg + value['u'] + '</div>');
  });
  setTimeout('updateContactsMenu();', 1000);
};

function var_dump(a){
var acc = []
$.each(a, function(index, value) {
    acc.push(index + ': ' + value);
});
alert(JSON.stringify(acc));
};

var img_green = '<img height="10" width="10" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAJUlEQVQI12NkYGBgYPzP+58BCv4zfmZkRBaAASYGLACrICM2MwE9GQoUaURE9wAAAABJRU5ErkJggg==" alt="Green dot" /> ';
var img_gray = '<img height="10" width="10" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAJUlEQVQI12NkYGBgqK+v/88ABY2NjYyMyAIwwMSABWAVZMRmJgBrhQqEIJUxWAAAAABJRU5ErkJggg==" alt="Gray dot" /> ';
$(document).ready(function() {
    $.getJSON('/friend.php', {
      'friends': ''
    }, function(data) {
      current_friends_list = data;
    });
    
    updateContactsMenu();
});
</script>
</head>
<body>
   <!-- <div style="width: 200px;height: 400px auto;" class="container">-->
       <!-- <h3 class="card-header ui-widget-header">Friends</h3>-->
        <div id='testfriendsajax' >
        </div>
   <!-- </div>  removed class="card" to above div -->
</body>

</html>