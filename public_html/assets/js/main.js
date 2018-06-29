$(document).ready(function() {
    //Place all js code in ./assets/js/main.js

    //////////////////////////////DEMO CODE HERE////////////////////////////////////
$('#postsform').keypress(function(ev){
    if (ev.which === 13)
        $('#postsformbtn').click();
});




$(function(){
    $("#addClass").click(function (e) {
        e.preventDefault();
        $('#qnimate').addClass('popup-box-on');
    });
    $("#removeClass").click(function () {
        $('#qnimate').removeClass('popup-box-on');
    });
});







    //////////////////////////////END  DEMO CODE////////////////////////////////////

    var commentsindexcount = 0;
    //var pform = $('#postsform');
    //var tarea = pform.find("textarea[name='mssg_body']");
    var tarea = $('#postformtext');

    var commentsviewid = pform.find("input[name='view']").val();
    if(!commentsviewid)
        commentsviewid = '';

    function displaySearchFriendsResults(data){
        $('#searchfriendsformresults').empty();
        $.each(data, function(key, value) {
            $('#searchfriendsformresults').append("<div class='searchfriendsresults'><a href='profile.php?id="+value[1]+"'><img src='avatar.php?pic="+value[2]+"'>"+value[0]+"</a></div><br />\n");
        });
    };
    
    $('#searchfriendsformbtn').click(function() {
    	var sform = $('#searchfriendsform');
    	var qinput = sform.find("input[name='q']");
    	var srchret = qinput.val();
    	$.post("/search.php", {
            q: srchret
        }, function(data) {
            displaySearchFriendsResults(data);
        }, 'json');
        qinput.val("");
    });
    
    function displayCommentsResults(data){
        //return comments to be displayed
        $('#postsresult').empty();
        $.each(data, function(key, value) {
            var gdate = new Date(value[0]*1000);
            var hrs = (gdate.getHours()>12)?gdate.getHours()-12:gdate.getHours();
            if(hrs==0) hrs=12;
            if((""+hrs).length<2) hrs='0'+hrs;
            var ampm = (gdate.getHours()<11)?'AM':'PM';
            var mins = gdate.getMinutes();
            if((""+mins).length<2) mins='0'+mins;
            $('#postsresult').append("<div class='postresults'>"+value[2]+" "+gdate.getFullYear()+"/"+((gdate.getMonth()<9)?'0':'')+(gdate.getMonth()+1)+"/"+gdate.getDate()+" "+hrs+":"+mins+ampm+": "+value[1]+"</div>\n");
        });
    }

    $('#postsformupbtn').click(function() {
        if(commentsindexcount > 0)
            commentsindexcount--;
        $.get("/comments.php", {view: commentsviewid, index: commentsindexcount}, function(data) { displayCommentsResults(data); }, 'json')
         .fail(function() {
            commentsindexcount = 0;
        });
    });
    
    $('#postsformdownbtn').click(function() {
        commentsindexcount++;
        $.get("/comments.php", {view: commentsviewid, index: commentsindexcount}, function(data){ displayCommentsResults(data); }, 'json')
        .fail(function() {
            commentsindexcount--;
        });
    
    });

    function statusChecking(){
        document.write('BREAK ');
    }

    //statusChecking();
    //setInterval(statusChecking, 2000);
    
    //Send Comments to comments.php and DB
    $('#postsformbtn').click(function() {
	var mbody = tarea.val();
        $.post("/comments.php", {
            mssg_body: mbody,
            target: commentsviewid
        }, function(data) {
            displayCommentsResults(data);
        }, 'json');
        tarea.val("");
    });

    //this loads at the page load time
    $.get("/comments.php", {view: commentsviewid, index: 0}, function(data) {
        displayCommentsResults(data);
	tarea.val("");
    }, 'json');

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    if(btn)
        btn.onclick = function() {
            modal.style.display = "block";
        }

    // When the user clicks on <span> (x), close the modal
    if(span)
        span.onclick = function() {
            modal.style.display = "none";
        }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var files;

    $('input[type=file]#avtr').on('change', prepareUpload);

    function prepareUpload(e) {
        files = e.target.files;
    }
    $('input[type=file]#bgrnd').on('change', prepareUpload);

    function prepareUpload(e) {
        files = e.target.files;
    }

    $('#avatarupload').submit(function(e) {
        e.preventDefault();
        var data = new FormData();
        $.each(files, function(key, value) {
            console.log('Key: ' + key);
            console.log('Value: ' + value);
            data.append(key, value);
        });
        $.ajax({
            url: 'avatar.php',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'html',
            processData: false,
            contentType: false,
            success: function(data, textStatus, jqXHR) {
                if (typeof data.error === 'undefined') {
                    $('div#upload_result').empty().append(data);
                }
            },
        });
    });

    $('#backgroundupload').submit(function(e) {
        e.preventDefault();
        var data = new FormData();
        $.each(files, function(key, value) {
            console.log('Key: ' + key);
            console.log('Value: ' + value);
            data.append(key, value);
        });
        $.ajax({
            url: 'background.php',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'html',
            processData: false,
            contentType: false,
            success: function(data, textStatus, jqXHR) {
                if (typeof data.error === 'undefined') {
                    $('div#upload_result').empty().append(data);
                }
            },
        });
    });
    



    
});