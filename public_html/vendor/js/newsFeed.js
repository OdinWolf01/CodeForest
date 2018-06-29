$(document).ready(function(){
    //i grabbed this  from code pen just trying it out lol
	$.get("https://codepen.io/jlarson/activity/feed", function(data) {
        var $XML = $(data);
        $XML.find("item").each(function() {
            var $this = $(this),
                item = {
                    title:       $this.find("title").text(),
                    link:        $this.find("link").text(),
                    description: $this.find("description").html(),
                    pubDate:     $this.find("pubDate").text(),
                    author:      $this.find("author").text()
                };
            $('#content-div').append($('<div class="fauxevent"></div>').html(item.description));
            //etc...
        });
    });
});
$(document).ajaxComplete(function(){
    $('.fauxevent').each(function(){
        var $this,
        event = {
            author: $(this).find('.activity-name').text(),
            action: $(this).find('.activity-action').text().trim(),
            thing: $(this).find('.activity-thing').text(),
            thingURL: $(this).find('.activity-thing').attr('href'),
            date: $(this).find('.activity-date').text()
        };
        if (event.action == "hearted"){
            var whaticon = "heart red";
        } else if (event.action == "added"){
            var whaticon = "star yellow";
        }
        $('#content-div').append('<div class="ui blue segment"><div class="event"> <div class="label"> <i class=" icon '+ whaticon +'"></i> </div> <div class="content"> <div class="summary"> <div class="user"> <span>'+ event.author +'</span> '+ event.action +' your Pen <a class="thing" href="'+ event.thingURL +'">'+ event.thing +'</a> </div> </div> <div class="meta"> <div class="date"> '+ event.date +' </div> </div> </div> </div></div>');
    });
});