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
  $('#media_list_display').empty();
<?
if(isset($other_memberID) && isset($_GET['id']) && $other_memberID !== false && isset($other_profileID)){
  echo "  $.post('/media.php', {'id': ".'"'.$other_profileID.'"'."}, function(data){".PHP_EOL;
}else{
  echo "  $.post('/media.php', function(data){".PHP_EOL;
}
?>
    $.each(data, function(key, value){
      var new_repeater = $('#media_list_repeater').clone();
      new_repeater.attr('id', '');
      new_repeater.html(new_repeater.html().replace(/{Url}/g, value['url']));
      new_repeater.html(new_repeater.html().replace(/{Filename}/g, value['filename']));
      $('#media_list_display').append(new_repeater);
      new_repeater.show();
    });
  }, 'json');
  $('#media_list_display').show();
});
<? //editable below this line:
   //leave id names and "display: none;" ?>
</script>


<style type="text/css">
  li{
    list-style: none;
  }








<style>
* {
    box-sizing: border-box;
}



.row {
    display: -ms-flexbox; /* IE10 ughh microsuck lol */
    display: flex;
    -ms-flex-wrap: wrap; /* IE10 */
    flex-wrap: wrap;
    padding: 0 4px;
}


.column {
    -ms-flex: 25%; /* IE10 */
    flex: 25%;
    max-width: 25%;
    padding: 0 4px;
}

.column img {
    margin-top: 8px;
    vertical-align: middle;
}


@media screen and (max-width: 800px) {
    .column {
        -ms-flex: 50%;
        flex: 50%;
        max-width: 50%;
    }
}


@media screen and (max-width: 600px) {
    .column {
        -ms-flex: 100%;
        flex: 100%;
        max-width: 100%;
    }
}



@media screen and (max-width: 400px) {
    .column {
        -ms-flex: 100%;
        flex: 100%;
        max-width: 100%;
    }
}


@media screen and (max-width: 320px) {
    .column {
        -ms-flex: 100%;
        flex: 100%;
        max-width: 100%;
    }
}

@media screen and (max-width: 200px) {
    .column {
        -ms-flex: 100%;
        flex: 100%;
        max-width: 100%;
    }
}
</style>














</style>




<!-- Add fancyBox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>





<br><br><br>



        <div style="height: 550px;overflow: hidden;" class="container"> 
     
<div class="row" id='media_list_display' style='display: none;'></div>
 
<div class="col-xs " id='media_list_repeater' style='display: none;'>

  <ul>
    <li>
      <a style="width: 100px;height: 100px;" data-fancybox="mygallery" href="/media.php?view={Url}"><img style="width: 100px; height: 100px;" src="/media.php?view={Url}"></a>
    </li>
  </ul>
</div>
  </div>
<!--
<li><a data-fancybox="mygallery" href="/media.php?view={Url}"><img src="/media.php?view={Url}"></a></li>
<li><a data-fancybox="mygallery" href="/media.php?view={Url}"><img src="/media.php?view={Url}"></a></li>
...
-->
<br>
