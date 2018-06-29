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
