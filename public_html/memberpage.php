<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {header('Location: /');exit();}

$title = 'Social :)';

require_once($_SERVER['DOCUMENT_ROOT'].'/layout/header_min.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/doublets/tnav_doublet.php');
?>

<style>
	

	html { width:100%; }

@media only screen and (max-width:  320px){

       html { width:320px;padding: 10px; }

}


@media only screen and (max-width:800px) {
  
  .html {
    width: 80%;
    padding: 0;
  
    width: 100%;
  }
}
@media only screen and (max-width:500px) {
  
  .html, .body,  {
    width: 100%;
    padding: 0;
  }
</style>



<script>
$(document).ready(function(){
  var bodybgcolor = $(document.createElement('div'));
  bodybgcolor.addClass('ui-button');
  $('body').prepend(bodybgcolor);
  $('body').css('background-color', bodybgcolor.css('background-color'));
  $('body').css('color', bodybgcolor.css('color'));
  $('body').css('font-family', bodybgcolor.css('font-family'));
  $('body').css('font-size', bodybgcolor.css('font-size'));
  $('body').css('font-weight', bodybgcolor.css('font-weight'));
  $('body').css('line-height', bodybgcolor.css('line-height'));
  $('body').css('margin-right', bodybgcolor.css('margin-right'));
  $('html').css('background-color', bodybgcolor.css('background-color'));
  $('html').css('color', bodybgcolor.css('color'));
  $('html').css('font-family', bodybgcolor.css('font-family'));
  $('html').css('font-size', bodybgcolor.css('font-size'));
  $('html').css('font-weight', bodybgcolor.css('font-weight'));
  $('html').css('line-height', bodybgcolor.css('line-height'));
  $('html').css('margin-right', bodybgcolor.css('margin-right'));
  bodybgcolor.remove();
});
$(window).resize(function(){     

       if ($('html').width() == 320 ){

              // is a mobile device

       }

});
</script>



<? require_once($_SERVER['DOCUMENT_ROOT'].'/doublets/background_doublet.php'); ?>
<? require_once($_SERVER['DOCUMENT_ROOT'].'/triplets/bnav_triplet.php'); ?>
</body>
</html>
