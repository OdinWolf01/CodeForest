<?php require_once 'includes/config.php';
if (!$user->is_logged_in()) {header('Location: /');exit();}
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php');
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0,">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="vendor/css/chatbx.css">
    <link rel="stylesheet" href="vendor/css/context-menu.css">

<link rel="stylesheet" href="<? require_once($_SERVER['DOCUMENT_ROOT'].'/theme.php'); ?>">

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>


<script src="context-menu.min.js"></script>
<script src="my-menu.js"></script>




<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>












<style>
.ui-dialog .ui-dialog-titlebar-minimize {
	position: absolute;
	right: 2.9em;
	top: 50%;
	width: 20px;
	margin: -10px 0 0 0;
	padding: 1px;
	height: 20px;
}

.ui-dialog .ui-dialog-titlebar-maximize {
	position: absolute;
	right: 1.6em;
	top: 50%;
	width: 20px;
	margin: -10px 0 0 0;
	padding: 1px;
	height: 20px;
}


//.ui-dialog-content ui-widget-content{
//  width: 600px;
//}
//
//.ui-dialog .ui-dialog-titlebar{
//  width: 600px;
//
//}
//
//.ui-dialog .ui-dialog-content{
//width: 600px;
//}

</style>
<script>
////////////////////////////////////////////////////////////////////
(function($) {
    $.fn.drags = function(opt) {
        opt = $.extend({handle:"",cursor:"move"}, opt);
        if(opt.handle === "") {
            var $el = this;
        } else {
            var $el = this.find(opt.handle);
        }
        return $el.css('cursor', opt.cursor).on("mousedown", function(e) {
            if(opt.handle === "") {
                var $drag = $(this).addClass('draggable');
            } else {
                var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
            }
            var z_idx = $drag.css('z-index'),
                drg_h = $drag.outerHeight(),
                drg_w = $drag.outerWidth(),
                pos_y = $drag.offset().top + drg_h - e.pageY,
                pos_x = $drag.offset().left + drg_w - e.pageX;
            $drag.css('z-index', 1000).parents().on("mousemove", function(e) {
                $('.draggable').offset({
                    top:e.pageY + pos_y - drg_h,
                    left:e.pageX + pos_x - drg_w
                }).on("mouseup", function() {
                    $(this).removeClass('draggable').css('z-index', z_idx);
                });
            });
            e.preventDefault(); // disable selection
        }).on("mouseup", function() {
            if(opt.handle === "") {
                $(this).removeClass('draggable');
            } else {
                $(this).removeClass('active-handle').parent().removeClass('draggable');
            }
        });

    }
})(jQuery);

$('#i').drags();

$(function() {
  $(".drag-me").draggable();
});

////////////////////////%%%%%%%%%%%%%%%%   minimize  attempt %%%%%%%%%%%%%%%%%%%  //////////////////////////











///////////////////////////////////////////////////////////////////////////////








///////////////////////////////////////////////////////////////////

function displayClock(){
  var gdate = new Date();
  var year = gdate.getFullYear();
  var month = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ][gdate.getMonth()];
  var weekday = [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ][gdate.getDay()];
  var day = gdate.getDate();
  var hour = gdate.getHours();
  var minute = gdate.getMinutes();
  var second = gdate.getSeconds();
  var suffix = (hour >= 12)?'PM':'AM';
  if (hour > 12)
    hour = hour - 12;
  else if (hour === 0)
    hour = 12;
  if (minute < 10)
    minute = '0'+minute;
  if (second < 10)
    second = '0'+second;
  var ctime = weekday + ' ' + hour + ':' + minute + ':' + second + ' ' + suffix;
  var cdate = month + ' ' + day + ', ' + year;
  $('#clock').html(ctime).attr('title', cdate);
  setTimeout("displayClock();", 1000);
}
////////////////////////////////////////////////////////////////////////////////////

var NewWindowClass = function(wnd_name, wnd_contents, image_loc, dlogw, dlogh){
  this.wnd = $(document.createElement('div'));
  this.applocli = $(document.createElement('li'));
  this.applocdiv = $(document.createElement('div'));
  this.applocimg = $(document.createElement('img'));
  this.applocinput = $(document.createElement('input'));
  this.applocismin = $(document.createElement('input'));
  this.applocismax = $(document.createElement('input'));
  this.applocw = $(document.createElement('input'));
  this.apploch = $(document.createElement('input'));
  this.applocposx = $(document.createElement('input'));
  this.applocposy = $(document.createElement('input'));
  this.applocminbtn = $(document.createElement('button'));
  this.applocmaxbtn = $(document.createElement('button'));
  this.uniqid = Math.floor(Math.random()*10**16).toString(16);

  this.wnd.attr('id', this.uniqid+'div');
  $('#app_location').append(this.applocli);
  this.applocli.css({'float': 'left', 'list-style-type': 'none'});
  this.applocli.attr({'id': this.uniqid+'li', 'uniqid': this.uniqid});
  this.applocimg.css('vertical-align', 'middle');
  this.applocli.append(this.applocdiv);
  this.applocimg.attr('src', image_loc);
  this.applocdiv.append(this.applocimg);
  this.applocdiv.append(wnd_name);
  this.applocdiv.css('border', 'solid');
  this.applocinput.attr({'type': 'hidden', 'id': 'currentncwindow', 'value': this.uniqid});
  this.applocismin.attr({'type': 'hidden', 'id': this.uniqid+'ismin', 'value': '0'});
  this.applocismax.attr({'type': 'hidden', 'id': this.uniqid+'ismax', 'value': '0'});
  this.applocw.attr({'type': 'hidden', 'id': this.uniqid+'w', 'value': '0'});
  this.apploch.attr({'type': 'hidden', 'id': this.uniqid+'h', 'value': '0'});
  this.applocposx.attr({'type': 'hidden', 'id': this.uniqid+'posx', 'value': '0'});
  this.applocposy.attr({'type': 'hidden', 'id': this.uniqid+'posy', 'value': '0'});
  this.applocdiv.append(this.applocinput);
  this.applocdiv.append(this.applocismin);
  this.applocdiv.append(this.applocismax);
  this.applocdiv.append(this.applocw);
  this.applocdiv.append(this.apploch);
  this.applocdiv.append(this.applocposx);
  this.applocdiv.append(this.applocposy);
  this.applocminbtn.attr({'id': this.uniqid+'minbtn', 'uniqid': this.uniqid});
  this.applocminbtn.addClass('ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-minimize');
  this.applocminbtn.append('<span class="ui-button-icon ui-icon ui-icon-minusthick"></span>');
  this.applocminbtn.append('<span class="ui-button-icon-space"> </span>');
  this.applocminbtn.append('Minimize');
  this.applocmaxbtn.attr({'id': this.uniqid+'maxbtn', 'uniqid': this.uniqid});
  this.applocmaxbtn.addClass('ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-maximize');
  this.applocmaxbtn.append('<span class="ui-button-icon ui-icon ui-icon-newwin"></span>');
  this.applocmaxbtn.append('<span class="ui-button-icon-space"> </span>');
  this.applocmaxbtn.append('Maximize');
  
  this.fini = function(event,ui){
    $('#'+$(this.parentNode).attr('id')+'li').remove();
    $('#'+$(this.parentNode).attr('id')+'div').remove();
    $(this.parentNode).remove();
  };

  $('body').prepend(this.wnd);
  $.get(wnd_contents, function(data){
    var idnum = $('#currentncwindow').attr('value');
    $('#currentncwindow').remove();
    $('#'+idnum+'div').append(data);
  });

  this.rsize = function(event, ui){
    var uniqid = $(this).parent().attr('id');
    $('#'+uniqid+'h').attr('value', event.target.clientHeight);
    $('#'+uniqid+'w').attr('value', event.target.clientWidth);
  };

  this.wnd.append(this.applocminbtn);
  this.wnddialog = this.wnd.dialog({	
    title: wnd_name,
    resizeStop: this.rsize,
    width: dlogw,
    height: dlogh,
    close: this.fini
  });
  this.applocminbtn.click(function(e){
    var uniqid = $(this).attr('uniqid');
    var state = $('#'+uniqid+'ismin').attr('value');
    if(state == '0'){
      $('#'+uniqid+'h').attr('value', $('#'+uniqid).height());
      $('#'+uniqid+'w').attr('value', $('#'+uniqid).width());
      $('#'+uniqid).hide();
      $('#'+uniqid+'ismin').attr('value', '1');
    }
  });
  this.applocmaxbtn.click(function(e){
    var uniqid = $(this).attr('uniqid');
    var state = $('#'+uniqid+'ismax').attr('value');
    if(state == '0'){
      $('#'+uniqid+'h').attr('value', $('#'+uniqid).height());
      $('#'+uniqid+'w').attr('value', $('#'+uniqid).width());
      $('#'+uniqid+'div').dialog({'width': '100%'});
      //$('#'+uniqid+'div').css('position', 'absolute'); //relative
      $('#'+uniqid).css({'top': '0px', 'left': '0px'});
      $('#'+uniqid).height('95%');
      $('#'+uniqid).width('100%');
      //$('#'+uniqid).position({ my: "left top", at: "left top", of: "body" });
      $('#'+uniqid+'ismax').attr('value', '1');
    }else{
      $('#'+uniqid+'div').dialog({'height': $('#'+uniqid+'h').attr('value'), 'width': $('#'+uniqid+'w').attr('value')});
      $('#'+uniqid+'div').css('position', 'relative');
      //$('#'+uniqid+'div').css('top', '0', 'left', '0');
      $('#'+uniqid+'ismax').attr('value', '0');
    }
  });
  this.applocli.click(function(){
    var minstate = $('#'+$(this).attr('uniqid')+'ismin').attr('value');
    var maxstate = $('#'+$(this).attr('uniqid')+'ismax').attr('value');
    if(minstate == '0' && maxstate == '0' ){
      $('#'+$(this).attr('uniqid')+'h').attr('value', $('#'+$(this).attr('uniqid')).height());
      $('#'+$(this).attr('uniqid')+'w').attr('value', $('#'+$(this).attr('uniqid')).width());
      $('#'+$(this).attr('uniqid')).hide();
      $('#'+$(this).attr('uniqid')+'ismin').attr('value', '1');
    }else if(minstate == '0' && maxstate == '1' ){
      $('#'+$(this).attr('uniqid')).hide();
      $('#'+$(this).attr('uniqid')+'ismin').attr('value', '1');
    }else if(minstate == '1' && maxstate == '1' ){
      $('#'+$(this).attr('uniqid')).show();
      $('#'+$(this).attr('uniqid')+'ismin').attr('value', '0');
    }else{ //minstate == '1' && maxstate == '0'
      $('#'+$(this).attr('uniqid')).show();
      $('#'+$(this).attr('uniqid')+'h').attr('value', $('#'+$(this).attr('uniqid')).height());
      $('#'+$(this).attr('uniqid')+'w').attr('value', $('#'+$(this).attr('uniqid')).width());
      $('#'+$(this).attr('uniqid')+'ismin').attr('value', '0');
    }
    //$('#'+$(this).attr('uniqid')).toggle('drop', 'down');
    //alert($('#'+$(this).attr('uniqid')).attr('display'));
  });
  this.applocminbtn.prependTo('.ui-dialog-titlebar');
  this.applocmaxbtn.prependTo('.ui-dialog-titlebar');
  this.wnd.parent().attr('id', this.uniqid);
  //this.wnd.css('background', '#111');
  //this.wnd.css('color', '#666');
  //this.wnd.prev(".ui-dialog-titlebar").css("color","#666");
  //this.wnd.prev(".ui-dialog-titlebar").css("background","#111");
};

function addMenuItem(element, name, nameid){
  var menuli = $(document.createElement('li'));
  element.append(menuli);
  var menudiv = $(document.createElement('div'));
  menuli.append(menudiv);
  menudiv.attr('id', nameid);
  menudiv.append(name);
}

function openStartbarItem(name, nameid, namefunc){
  $('#menu.right').removeClass('right');
  $('#menu').hide();
  eval(namefunc);
}

$(document).ready(function(){
  $('.minimize').on('click', function(){minimize();});
  $('.maximize').on('click', function(){maximize();});
});

function minimize(){
  $('body').addClass('minimized');
}

function maximize(){
  $('body').removeClass('minimized');
}

//////////////////////////////////////////////////////////////////////////////////

$(document).ready(function(){
  displayClock();
  $('#start_bar').click(function(){
    $('#menu').empty();
    $('#menu').menu({
      disabled: false,
      positionOptions: {
        my: "left bottom",
        at: "left bottom",
        offset: "flip flip"
      },
    }).hide();
    $.getJSON('./desktop/data/start_bar.json', function(data){
      $.each(data, function(key, value) {
        var itemidname = 'item_'+key;
        addMenuItem($('#menu'), value[0], itemidname);
        $('#'+itemidname).mousedown(function(){
          openStartbarItem(value[0], itemidname, value[1]);
        });
      });
      $('#menu').addClass('right');
      var menu_height = $('#menu').innerHeight();
      $('#menu').css('top', '-'+menu_height+'px');
      $('#menu').show();
    }).fail(function(data) {
      $.each(data, function(key, value) {
        console.log("json error "+key+" => "+value);
      });
    });
  });
  $('#menu').mouseleave(function(){
    $('#menu.right').removeClass('right');
    $('#menu').hide();
  });
});




</script>





<style>
@media only (max-width: 720px) {
    body {
    }
}

@media only (max-width: 700px) {
    body {
       
    }
}

@media only (max-width: 600px) {
    .body {
       
    }
}

@media only (max-width: 550px) {
    .body {
       
    }
}

@media only (max-width: 500px) {
    .body {
       
    }
}

@media only (max-width: 480px) {
    .body {
       
    }
}

@media only  (max-width: 320px) {
    .body {
       
    }
}

@media only screen and (max-width: 300px) {
    .body {
       
    }
}

/**********************************************/
@media only (max-width: 720px) {
    .body {
       
    }
}

@media only (max-width: 700px) {
    .body {
       
    }
}

@media only (max-width: 600px) {
    .html{
       
    }
}

@media only (max-width: 550px) {
    .html{
       
    }
}


@media only (max-width: 500px) {
    .html {
       
    }
}

@media only (max-width: 480px) {
    .html {
       
    }
}

@media only  (max-width: 320px) {
    .html {
       
    }
}

@media only screen and (max-width: 300px) {
    .html{
       
    }
}







}



* {
  cursor: default;
  text-decoration: none;
}

html,
body {
  height: 100%;
  overflow-x: hidden;
  overflow-y: hidden;
}

#background {
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  height: 95%;
  position: absolute !important;
  z-index: -100;
}

#main_area {
  z-index: 90;
}

#bottom_bar {
  overflow: visible;
  vertical-align: middle;
  font-size: 15px;
  line-height: 35px;
  height: 6%;
  min-height: 35px;
  position: absolute !important;
  top: auto;
  left: 0;
  right: 0;
  bottom: 0;
}

#tasktray{
  float: right;

}

#clock {
  float: right;
  padding: 10px
  font-size: 20px;
  margin-right: 20px;
}

#openchatdialog{
    font-size: 36px;
    padding: 4px;
    margin-right: 20px;
    border: 1px solid;
    mso-border-shadow: 1px 1px 1px black;
    border-radius: 50%;
    text-shadow: 3px 3px 3px black;
}

#start_bar {
  padding: 3px;
  float: left;
}

#start_bar:hover {
}


#start_bar_menu {
  visibility: hidden;
  border: 1px solid #aaa;
  float: left;

}

#menu {
  position: absolute;
  width: 200px;
  z-index: 100;
}

#menu li:hover{
  background-color: #2a2;
}



</style>
<script src="my-menu.js">
  
</script>
<title><?php echo $title; ?></title>
</head>
<body>
<div id="main_area" class="demo">
  <img id="background" src="./background.php" />

<div class="drag-me">

<img  style="float: right;width: 90px;height: 80px;top: 70px;margin: 400px 50px 0px;" src="trash.png" alt="trash">

</div>





<div style="padding: 35px;" class="container">


<p>
  <div class="drag-me">
 <a href="index.php"> <i style="color: white;font-size: 40px;" class="fa fa-home"></a></i>
</div>
</p>

  
<p>
  <div class="drag-me">
    <a href="/arcade/pacman/pacman_codelet.php">
<i style="color: white;font-size: 40px" class="fa fa-cloud"></i>
</a>

</div>
</p>
<br>
<p>
  <div>
    <div class="drag-me">
<i style="color: white;font-size: 40px;" class="fa fa-heart"></i>
</div>
</div>
</p>
<br>
<p>
  <div class="drag-me">
<i style="color: white;font-size: 40px;" class="fa fa-car"></i>
</div>
</p>
<br>
<p>
  <div class="drag-me">
<i style="color: white;font-size: 40px;" class="fa fa-file"></i>
</div>
</p>
<br>
<p>
  <div  class="drag-me">
<i style="color: white;font-size: 40px;" class="fa fa-bars"></i>
</div>
</p>
<br>
</div>





























</div>

<div id="bottom_bar" class="ui-widget-header">
  <div id="start_bar">START</div>
  <ul id="menu" class="menu-special"></ul>
  <div id="app_location"></div>
    <div id="tasktray">

    <i id="openchatdialog" class="fa fa-comments"></i>

    <span id="clock"></span>
</div>
</div>



<!-- ********** %%%%%%%%%%%%%%%%%%  friends  sidebar  right %%%%%%%%%%%%%%%%%%*****************  -->
<!--
<div class="chat-sidebar">
            <div class="sidebar-name">
                
                <a class="ui-dialog-title" href="javascript:register_popup('username', 'username');">
                    <img width="30" height="30" src="avatar.php?pic=<?/*
$aid = pdo_get_avatarID_from_username($_SESSION['username']); echo ($aid !== false)?$aid:''; ?>"/>
                    <span><?php echo htmlentities($_SESSION['username'], ENT_QUOTES); */?></span>
                </a>
              
            </div>






            <div class="sidebar-name">
                <a href="javascript:register_popup('username1', 'Username1');">
                    <img width="30" height="30" src="" />
                    <span>user 2 </span>
                </a>
            </div>








            <div class="sidebar-name">
                <a href="javascript:register_popup('goofball', 'Goofball');">
                    <img width="30" height="30" src="" />
                    <span>user 3 </span>
                </a>
            </div>









            <div class="sidebar-name">
                <a href="javascript:register_popup('dingleberry', 'Dingleberry');">
                    <img width="30" height="30" src="" />
                    <span> user 4 </span>
                </a>
            </div>








            <div class="sidebar-name">
                <a href="javascript:register_popup('peckerhead', 'Peckerhead');">
                    <img width="30" height="30" src="" />
                    <span>user  5</span>
                </a>
            </div>










            <div class="sidebar-name">
                <a href="javascript:register_popup('kdodge', 'Kdodge');">
                    <img width="30" height="30" src="" />
                    <span>user 6 </span>
                </a>
            </div>
        </div>
        






<script src="vendor/js/chatbx.js"></script>
<script>

    $(document).ready(function() {
        $("#dialog").dialog();
    });
</script>
-->

<!-- ***************************************************************************************************************  -->



</body>
</html>
