! function(n) {
    n.fn.scrollFeedPagination = function(t) {
        var a = n.extend(n.fn.scrollFeedPagination.defaults, t),
            l = a.scrollTarget;
        return null == l && (l = obj), a.scrollTarget = l, this.each(function() { n.fn.scrollFeedPagination.init(n(this), a) })
    }, n.fn.stopScrollPagination = function() { return this.each(function() { n(this).attr("scrollPagination", "disabled") }) }, n.fn.scrollFeedPagination.loadContent = function(t, a) {
        var l = a.scrollTarget;
        n(l)[0].scrollHeight - n(l).scrollTop() == n(l).height() && (null != a.beforeLoad && a.beforeLoad(), n(t).children().attr("rel", "loaded"), n.ajax({
            type: "POST",
            url: a.contentPage,
            data: a.contentData,
            success: function(e) {
                var o = l.selector,
                    r = n(e).find(o).children();
                n(t).append(r);
                var i = n(t).children("[rel!=loaded]");
                null != a.afterLoad && a.afterLoad(i)
            },
            dataType: "html"
        }))
    }, n.fn.scrollFeedPagination.init = function(t, a) {
        var l = a.scrollTarget;
        n(t).attr("scrollPagination", "enabled"), n(l).scroll(function(l) { "enabled" == n(t).attr("scrollPagination") ? n.fn.scrollFeedPagination.loadContent(t, a) : l.stopPropagation() }), n.fn.scrollFeedPagination.loadContent(t, a)
    }, n.fn.scrollFeedPagination.defaults = { contentPage: null, contentData: {}, beforeLoad: null, afterLoad: null, scrollTarget: null, heightOffset: 0 }
}(jQuery);