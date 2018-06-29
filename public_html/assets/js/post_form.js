$("#searchForm").submit(function(e){
	e.preventDefault();
	var t=$(this).find("textarea[name='mssg_body']").val();
	$.post("/comments.php",{mssg_body:t}).done(function(e){
		$("#result").empty().append(e)
	})
}),
$.get("/comments.php",function(e){
	$("#result").empty().append(e)
});

var files;

$('input[type=file]#avtr').on('change', prepareUpload);
function prepareUpload(e){
  files = e.target.files;
}
$('input[type=file]#bgrnd').on('change', prepareUpload);
function prepareUpload(e){
  files = e.target.files;
}

$('#avatarupload').submit(function(e){
    e.preventDefault();
    var data = new FormData();
    $.each(files, function(key, value){
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
        success: function(data, textStatus, jqXHR){
            if(typeof data.error === 'undefined'){
                $('div#upload_result').empty().append(data);
            }
        },
    });
});

$('#backgroundupload').submit(function(e){
    e.preventDefault();
    var data = new FormData();
    $.each(files, function(key, value){
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
        success: function(data, textStatus, jqXHR){
            if(typeof data.error === 'undefined'){
                $('div#upload_result').empty().append(data);
            }
        },
    });
});

function myFunction(){
window.location.href = '/';
//window.location.reload(true);
//location.reload()
}



