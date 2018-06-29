<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php');
if( $test_req === 1){
echo '</head>'.PHP_EOL;
echo '<script>$(document).ready(function(){  $("#btn").click(function(){ openChatBoxInstance("testuser", "5678", "1234"); }); });'.PHP_EOL;
echo '</script><button id="btn">CLICK</button>';
}
?>
<script>
function updateAllChatBoxInstances(){
  if(pinger['notifications']){
    $.each(pinger['notifications'], function(key, value){
      if($('#msg'+value).length == 1){
        $('#msg'+value).trigger('refresh'+value);
      }
    });
  }
  setTimeout('updateAllChatBoxInstances();', 1000);
}

function openChatBoxInstance(u, p, av){
  if($('#msg'+p).length == 0){
    var newdialog = $('#chatbox_repeater2').clone();
    newdialog.attr('id', 'msg'+p);
    newdialog.dialog({
      resizable: false,
      width: '25%',
      title: 'Chat - '+u,
      autoOpen: false,
      fluid: true,
      close: function(){
        $(this.parentNode).remove();
      },
    }).css({"overflow-y": "scroll", "overflow-x": "hidden"});
    newdialog.parent().attr('pid', p);
    var divfooter = $(document.createElement('div'));
    newdialog.parent().append(divfooter);
    divfooter.addClass('ui-corner-all ui-widget-header');
    divfooter.attr('align', 'center');
    var inpt = $(document.createElement('input'));
    inpt.attr('type', 'text');
    inpt.css('width', '55%');
    inpt.addClass('ui-button ui-state-default ui-corner-all');
    var cbtn = $(document.createElement('button'));
    cbtn.css('width', '35%');
    cbtn.append('SEND');
    cbtn.button();
    //inpt.css('height', cbtn.css('height'));
    divfooter.append(inpt);
    divfooter.append('&nbsp;');
    divfooter.append(cbtn);
    inpt.keypress(function(e){
      if(e.which === 13 && inpt.val() != '')
        cbtn.click();
    });
    newdialog.on('refresh'+p, function(e){
      $.post('/chat_status.php', {open: p}, function(data){
        $.post('/chat_status.php', {read: p});
        newdialog.empty();
        $.each(data, function(key, value){
          newdialog.prepend('<img class="img-circle" src="/avatar.php?pic='+value['a1']+'" height="25px" width="25px"> '+value['user']+': '+value['message']+'<hr>');
        });
      }, 'json');
    });
    newdialog.trigger('refresh'+p);
    cbtn.click(function(){
      if(inpt.val() != '')
        $.post('/chat_status.php', {send: p, message: inpt.val()}, function(data){
          inpt.val('');
          newdialog.empty();
          $.each(data, function(key, value){
//          
            newdialog.prepend('<img class="img-circle" src="/avatar.php?pic='+value['a1']+'" height="25px" width="25px"> '+value['user']+': '+value['message']+'<hr>');
          });
        }, 'json');
    });
    newdialog.show();
    newdialog.dialog("open").css("height", "300px");
  }
}
$(document).ready(function(){
  updateAllChatBoxInstances();
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>


<div id="chatbox_repeater2" class="ui-widget-content" style="display: none;">
  
</div>
