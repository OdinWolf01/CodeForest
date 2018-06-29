



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./assets/css/context-menu.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="context-menu.min.css">
<script src="context-menu.min.js"></script>

<script src="my-menu.js"></script>













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

$('p').drags();

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





var NewWindowClass = function(wnd_name, wnd_contents, image_loc){
  this.wnd = $(document.createElement('div'));
  this.applocli = $(document.createElement('li'));
  this.applocdiv = $(document.createElement('div'));
  this.applocimg = $(document.createElement('img'));
  this.uniqid = Math.floor(Math.random()*10**16).toString(16);

  this.wnd.attr('id', this.uniqid+'div');
  $('#app_location').append(this.applocli);
  this.applocli.css('float', 'left');
  this.applocli.attr('id', this.uniqid+'li');
  this.applocimg.css('vertical-align', 'middle');
  this.applocli.append(this.applocdiv);
  this.applocimg.attr('src', image_loc);
  this.applocdiv.append(this.applocimg);
  this.applocdiv.append(wnd_name);
  this.applocdiv.css('border', 'solid');

  this.fini = function(event,ui){
    $('#'+$(this.parentNode).attr('id')+'li').remove();
    $('#'+$(this.parentNode).attr('id')+'div').remove();
    $(this.parentNode).remove();
  };

  $('body').prepend(this.wnd);
  this.wnd.append(wnd_contents);
  this.wnd.dialog({
    title: wnd_name,
    close: this.fini,
    buttons: [
      {
        text: "Minimize",
        icon: "ui-icon-minimize",
        click: function( e ) {
        //function
        }
      },
      {
        text: "Maximize",
        icon: "ui-icon-maximize",
        click: function( e ) {
        //function
        }
      }
    ],
    create: function( event, ui ) {
      $('.ui-dialog-buttonset').prependTo('.ui-dialog-titlebar');
    }
  });
  this.wnd.parent().attr('id', this.uniqid);
  this.wnd.css('background', '#111');
  this.wnd.css('color', '#666');
  this.wnd.prev(".ui-dialog-titlebar").css("color","#666");
  this.wnd.prev(".ui-dialog-titlebar").css("background","#111");
};

function addMenuItem(element, name, nameid){
  var menuli = $(document.createElement('li'));
  element.append(menuli);
  var menudiv = $(document.createElement('div'));
  menuli.append(menudiv);
  menudiv.attr('id', nameid);
  //menudiv.css('color', '#afafaf');
  menudiv.append(name);
}

function openStartbarItem(name, nameid, namefunc){
  $('#menu.right').removeClass('right');
  $('#menu').hide();
  eval(namefunc);
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
    $.getJSON('./data/start_bar.json', function(data){
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
  background: black;
  border-top: 1px solid grey;
  color: #fff;
  overflow: visible;
  vertical-align: middle;
  font-weight: bold;
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

#clock {
  float: right;
  padding: 10px
  font-size: 20px;
  margin-right: 20px;
}

#start_bar {
  border: 1px solid grey;
  border-radius: 25%;
  padding: 3px;
  font-weight: bold;
  color: #888;
  background: #111; 
  float: left;
}

#start_bar:hover {
      background-color:  grey;
}


#start_bar_menu {
  visibility: hidden;
  border: 1px solid #aaa;
  font-weight: bold;
  color: #666;
  float: left;

}

#menu {
  position: absolute;
  width: 200px;
  color: #fff;
  background: #111; 
  z-index: 100;
}

#menu li:hover{
  background-color: green;
}

/******************************************/

/****************************************/
</style>
<title>Open Desktop</title>
</head>
<body>
<div id="main_area" class="demo">
  <img id="background" src="assets/images/background.jpg" />



<div style="padding: 35px;" class="container">
<p>
<i style="color: white;font-size: 40px" class="fa fa-cloud"></i>
</p>
<br>
<p>
  <div>
<i style="color: white;font-size: 40px;" class="fa fa-heart"></i>
</div>
</p>
<br>
<p>
<i style="color: white;font-size: 40px;" class="fa fa-car"></i>
</p>
<br>
<p>
<i style="color: white;font-size: 40px;" class="fa fa-file"></i>
</p>
<br>
<p>
<i style="color: white;font-size: 40px;" class="fa fa-bars"></i>
</p>
<br>
</div>

</div>
<div id="bottom_bar">
  <div id="start_bar">START</div>
  <ul id="menu" class="menu-special"></ul>
  <div id="app_location"></div>
  <span id="clock"></span>
</div>








<script>
    


   </script>













</body>
</html>
