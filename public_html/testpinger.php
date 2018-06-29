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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/dot-luv/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<title>Pinger</title>
<? require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php'); ?>
<script>
function readerLoop(){
  $('#f1').empty();
  $('#f2').empty();
  $('#f1').append(pinger['online_friends']);
  $('#f2').append(pinger['notifications']);
  setTimeout('readerLoop();', 1000);
};
$(document).ready(readerLoop());
</script>
</head>
<body>
<div><h3>friends_online</h3><div id='f1'></div></div>
<div><h3>notifications</h3><div id='f2'></div></div>
</body>
</html>