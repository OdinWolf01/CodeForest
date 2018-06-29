var files;

function prepareUpload(e) { files = e.target.files }

function prepareUpload(e) { files = e.target.files }

function myFunction() { window.location.href = "/" }
$("#searchForm").submit(function(e) {
    e.preventDefault();
    var a = $(this).find("textarea[name='mssg_body']").val();
    $.post("/comments.php", { mssg_body: a }).done(function(e) { $("#result").empty().append(e) })
}), $.get("/comments.php", function(e) { $("#result").empty().append(e) }), $("input[type=file]#avtr").on("change", prepareUpload), $("input[type=file]#bgrnd").on("change", prepareUpload), $("#avatarupload").submit(function(e) {
    e.preventDefault();
    var a = new FormData;
    $.each(files, function(e, t) { console.log("Key: " + e), console.log("Value: " + t), a.append(e, t) }), $.ajax({ url: "avatar.php", type: "POST", data: a, cache: !1, dataType: "html", processData: !1, contentType: !1, success: function(e, a, t) { void 0 === e.error && $("div#upload_result").empty().append(e) } })
}), $("#backgroundupload").submit(function(e) {
    e.preventDefault();
    var a = new FormData;
    $.each(files, function(e, t) { console.log("Key: " + e), console.log("Value: " + t), a.append(e, t) }), $.ajax({ url: "background.php", type: "POST", data: a, cache: !1, dataType: "html", processData: !1, contentType: !1, success: function(e, a, t) { void 0 === e.error && $("div#upload_result").empty().append(e) } })
});