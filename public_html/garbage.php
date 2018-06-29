<?php
header('Location: /');
exit();
?>
//Reference: https://api.jquery.com/jQuery.post/

/*
// Attach a submit handler to the form
$( "#searchForm" ).submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the page:
  var $form = $( this ),
    term = $form.find( "input[name='mssg_body']" ).val(),
    url = $form.attr( "action" );
 
  // Send the data using post
  var posting = $.post( url, { mssg_body: term } );
 
  // Put the results in a div
  posting.done(function( data ) {
    var content = $( data ).find( "#content" );
    $( "#result" ).empty().append( content );
  });
});


/*
var request;
$("#handler").submit(function(event){
event.preventDefault();
if (request) {
request.abort();
}
var $form = $(this);
var $inputs = $form.find("input, select, button, textarea");
var serializedData = $form.serialize();
$inputs.prop("disabled", true);
request = $.ajax({
url: "/memberspage.php",
type: "post",
data: serializedData
});
request.done(function (response, textStatus, jqXHR){
console.log("Hooray, it worked!");
});
request.fail(function (jqXHR, textStatus, errorThrown){
console.error(
"The following error occurred: "+
textStatus, errorThrown
);
});
request.always(function () {
$inputs.prop("disabled", false);
});

});
*/


      /*  .img {
    border-radius: 50%;
    border: solid  blue;
}

temporarely removing circle image just to test  lol i will change it back later
i added onclick function bc  image wouldnt show til the page was refreshed  lol idk
if that was the best way to do this or not  but feel free to change it back i hope i didnt mess it up 4 you
:) ty and i was looking at avatar.php  i was like  wow !  great job man */

                 <!--<table>
                <?
                $comments_array = pdo_comments_from_database($_SESSION['memberID'], 5);
                foreach($comments_array as $cmt){
                echo '<tr><td class="border border-primary">'.$cmt.'</td></tr>'.PHP_EOL;
                }
                ?>
                </table>-->
<!--<form id="avatarupload">
  <input type="file" id="avtr">
  <input type="hidden" name="loaded">
  <input  type="submit" onclick="myFunction()" value="Upload Avatar">
</form>



<form id="backgroundupload">
  <input type="file" id="bgrnd">
  <input type="hidden" name="loaded">
  <input  type="submit" onclick="myFunction()" value="Upload Background">
</form>-->
   <!-- <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">-->
                         <!--  lol i need to add an x button to close the image hahah but anyways  i like your avatar code :) -->


			<!--<a href="avatar.php?pic=<?
//$aid = pdo_get_avatarID_from_username($_SESSION['username']);
//echo ($aid !== false)?$aid:'';
?>" alt="avatar" >

<img src="avatar.php?pic=<?
//$aid = pdo_get_avatarID_from_username($_SESSION['username']);
//echo ($aid !== false)?$aid:'';
?>" alt="avatar" > </a>-->

<!-- width="110px" height="110px"> -->




				<!--<h2>Welcome <?php echo htmlentities($_SESSION['username'], ENT_QUOTES);?></h2>-->
				<!--<p><a href='logout.php'>Logout</a></p>-->
				                                <!--id=handler action="memberpage.php" method="POST"
                                <button class="btn btn-primary" type=submit>Comment</button>-->
