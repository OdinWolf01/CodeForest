$(document).ready(function() {
    $(function() { $("#addClass").click(function(e) { e.preventDefault(), $("#qnimate").addClass("popup-box-on") }), $("#removeClass").click(function() { $("#qnimate").removeClass("popup-box-on") }) });
    var e = 0,
        n = $("#postformtext"),
        o = 0,
        t = $("#postformview").val();

    function i(e) { e[0] && ($("#profileinfofullname").val(e[0]), $("#profileinfofullnamex").html(e[0])), e[1] && ($("#profileinfolocation").val(e[1]), $("#profileinfolocationx").html(e[1])), e[2] && ($("#profileinfoschooling").val(e[2]), $("#profileinfoschoolingx").html(e[2])), e[3] && ($("#profileinfoprofession").val(e[3]), $("#profileinfoprofessionx").html(e[3])), e[4] && ($("#profileinfocompany").val(e[4]), $("#profileinfocompanyx").html(e[4])), e[5] && ($("#profileinfohobbies").val(e[5]), $("#profileinfohobbiesx").html(e[5])), e[6] && ($("#profileinfoaboutme").val(e[6]), $("#profileinfoaboutmex").html(e[6])), e[7] && $("#profileinforelationshipstatus").val(e[7]) }

    function a(e) { $("#postsresult").empty(), $("#postsresult").append('<div class="comments-container">'), $("#postsresult").append('<h1>..... <a href="#">.....</a></h1>'), $("#postsresult").append('<ul id="comments-list" class="comments-list">'), $.each(e, function(e, n) { $("#postsresult").append("<p><div class='singlecomment'><h6>" + n[2] + " " + p(n[0]) + ":</h6>" + n[1] + " <a class='text-danger' href='#'>…</a></div></p>\n") }), $("#postsresult").append("</ul>"), $("#postsresult").append("</div>") }

    function p(e) {
        var n = Math.floor((new Date).getTime() / 1e3 - e),
            o = Math.floor(n / 31536e3);
        return o > 0 ? 1 == o ? "1 year ago" : o + " years ago" : (o = Math.floor(n / 2628e3)) > 0 ? 1 == o ? "1 month ago" : o + " months ago" : (o = Math.floor(n / 86400)) > 0 ? 1 == o ? "1 day ago" : o + " days ago" : (o = Math.floor(n / 3600)) > 0 ? 1 == o ? "1 hour ago" : o + " hours ago" : (o = Math.floor(n / 60)) > 0 ? 1 == o ? "1 minute ago" : o + " minutes ago" : Math.floor(n) + " seconds ago"
    }
    t || (t = ""), $("#profileinfoedit").click(function() { window.location.href = "/profile_settings.php" }), $("#profileinfosave").click(function() { $.post("/profile_info.php", { fullname: $("#profileinfofullname").val() }), $.post("/profile_info.php", { location: $("#profileinfolocation").val() }), $.post("/profile_info.php", { schooling: $("#profileinfoschooling").val() }), $.post("/profile_info.php", { profession: $("#profileinfoprofession").val() }), $.post("/profile_info.php", { company: $("#profileinfocompany").val() }), $.post("/profile_info.php", { hobbies: $("#profileinfohobbies").val() }), $.post("/profile_info.php", { aboutme: $("#profileinfoaboutme").val() }), $.post("/profile_info.php", { relationshipstatus: $("#profileinforelationshipstatus").val() }), window.location.href = "/" }), $("#searchfriendsformbtn").click(function() {
            var e = $("#searchfriendsform").find("input[name='q']"),
                n = e.val();
            $.post("/search.php", { q: n }, function(e) {
                var n;
                n = e, $("#searchfriendsformresults").empty(), $.each(n, function(e, n) { $("#searchfriendsformresults").append("<div class='searchfriendsresults'><a href='profile.php?id=" + n[1] + "'><img src='avatar.php?pic=" + n[2] + "'>" + n[0] + "</a></div><br />\n") })
            }, "json"), e.val("")
        }), $("#postsformupbtn").click(function() { e > 0 && e--, $.get("/comments.php", { view: t, index: e }, function(e) { a(e) }, "json").fail(function() { e = 0 }) }), $("#postsformdownbtn").click(function() { e++, $.get("/comments.php", { view: t, index: e }, function(e) { a(e) }, "json").fail(function() { e-- }) }),
        function e() { 100 === o ? o = 0 : o++, $("#displaynotify").html(p(1521824399)), setTimeout(e, 2e3) }(), $("#postsformbtn").click(function() {
            var e = n.val();
            $.post("/comments.php", { mssg_body: e, target: t }, function(e) { a(e) }, "json"), n.val("")
        }), $("#postformtext").keypress(function(e) { 13 === e.which && $("#postsformbtn").click() }), $.get("/comments.php", { view: t, index: 0 }, function(e) { a(e), n.val("") }, "json"), $.get("/friend.php", { friends: "" }, function(e) {
            var n;
            n = e, $("#friendsresults").empty(), $("#friendsresults").append("<h4>friends</h4><ul>"), $.each(n, function(e, n) { $("#friendsresults").append("<li><a style='color: white;' class='btn btn-primary' href='profile.php?id=" + n[1] + "'>" + n[0] + "</a> <a style='color: white' class='btn btn-danger' onclick=\"$.post('/friend.php', {del: '" + n[1] + "'}); window.location.href = '/'; \">Unfriend</a></li>\n") }), $("#friendsresults").append("</ul>")
        }, "json"), $.get("/friend.php", { inc_requests: "" }, function(e) {
            var n;
            n = e, $("#friendsrequestsresults").empty(), $("#friendsrequestsresults").append("<h4>friend requests</h4><ul>"), $.each(n, function(e, n) { $("#friendsrequestsresults").append("<li><a href='profile.php?id=" + n[1] + "'>" + n[0] + "</a> <a class='text-info' onclick=\"$.post('/friend.php', {add: '" + n[1] + "'}); window.location.href = '/'; \">[friend me]</a> <a class='text-danger' onclick=\"$.post('/friend.php', {decline: '" + n[1] + "'}); window.location.href = '/'; \">[decline]</a></li>\n") }), $("#friendsrequestsresults").append("</ul>")
        }, "json"), t ? $.get("/profile_info.php", { id: t }, function(e) { i(e) }, "json") : $.get("/profile_info.php", function(e) { i(e) }, "json");
    var s, l = document.getElementById("myModal"),
        r = document.getElementById("myBtn"),
        c = document.getElementsByClassName("close")[0];

    function f(e) { s = e.target.files }

    function f(e) { s = e.target.files }
    r && (r.onclick = function() { l.style.display = "block" }), c && (c.onclick = function() { l.style.display = "none" }), window.onclick = function(e) { e.target == l && (l.style.display = "none") }, $("input[type=file]#avtr").on("change", f), $("input[type=file]#bgrnd").on("change", f), $("#avataruploadbtn").click(function(e) {
        e.preventDefault();
        var n = new FormData;
        $.each(s, function(e, o) { console.log("Key: " + e), console.log("Value: " + o), n.append(e, o) }), $.ajax({ url: "avatar.php", type: "POST", data: n, cache: !1, dataType: "html", processData: !1, contentType: !1, success: function(e, n, o) { void 0 === e.error && $("div#upload_result").empty().append(e), window.location.href = "/" } })
    }), $("#backgroundupload").submit(function(e) {
        e.preventDefault();
        var n = new FormData;
        $.each(s, function(e, o) { console.log("Key: " + e), console.log("Value: " + o), n.append(e, o) }), $.ajax({ url: "background.php", type: "POST", data: n, cache: !1, dataType: "html", processData: !1, contentType: !1, success: function(e, n, o) { void 0 === e.error && $("div#upload_result").empty().append(e) } })
    }), $.get("/friend.php", { friends: "" }, function(e) {
        $("#friendstab").empty(), $.each(e, function(e, n) {
            var o = $(document.createElement("figure"));
            $("#friendstab").append(o);
            var t = $(document.createElement("img"));
            t.css("margin", "20px 70px 40px"), t.addClass("img-circle"), t.attr("src", "avatar.php?pic=" + n[2]), t.alt = "avatar=" + n[2], t.width = "100px", t.height = "100px", o.append(t);
            var i = $(document.createElement("figcaption")),
                a = $(document.createElement("button"));
            a.append("Message");
            var p = $(document.createElement("button"));
            p.append("Unfriend"), i.append(n[0]), i.append(a), i.append("&nbsp;"), i.append(p), o.click(function() { popup.open($(this)) }), $(document).on("click", ".popup img", function() { return !1 }).on("click", ".popup", function() { popup.close() }), $("#friendstab").append(i)
        })
    }, "json"), $("#chatopenbtn").click(function() {
        $.post("/chat_status.php", { open: t }, function(e) {
            ! function e(n) {
                $("#chatresults").empty(), $.each(n, function(e, n) { $("#chatresults").append(n.user + ": " + n.message + "<br />") });
                var o = $(document.createElement("input"));
                o.attr("type", "text"), o.attr("id", "sendmsg"), o.attr("name", "send");
                var i = $(document.createElement("input"));
                i.attr("type", "button"), i.attr("id", "sendmsgbtn"), i.attr("value", "send");
                var a = $(document.createElement("input"));
                a.attr("type", "button"), a.attr("id", "clearbtn"), a.attr("value", "clear"), $("#chatresults").append(o), $("#chatresults").append(i), $("#chatresults").append(a), $("#sendmsgbtn").click(function() {
                    var n = $("#sendmsg").val();
                    $.post("/chat_status.php", { send: t, message: n }, function(n) { e(n) }, "json")
                }), $("#clearbtn").click(function() { $.post("/chat_status.php", { clear: t }, function(n) { e(n) }, "json") })
            }(e)
        }, "json")
    })
});