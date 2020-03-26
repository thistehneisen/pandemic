<?php if(!defined('s7V9pz')) {die();}?>function httpGetAsync(theUrl, callback) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            callback(xmlHttp.responseText);
        }
    };
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);

    return;
}
function tenorCallback_search(responsetext) {
    var response_objects = JSON.parse(responsetext);

    grgifs = response_objects["results"];
    var rs = '';
    $.each(grgifs, function(k, v) {
        var nano = grgifs[k]["media"][0]["nanogif"]["url"];
        var share = grgifs[k]["media"][0]["tinygif"]["url"];
        rs = rs+"<li gif='"+share+"'><img class='lazygif' data-src='"+nano+"'/></li>";
    });
    $(".grgif .grgifconts").html(rs);
    $(".lazygif").Lazy({
        effect: "fadeIn",
        effectTime: 1000,
        bind: "event",
        onFinishedAll: function(element) {
            $(".grgif .loading").hide();
            grscroll($(".grgif > .wrap > div"), "resize");
        }
    });
    return;

}


function grab_data(term) {
    $(".grgif .loading").show();
    var apikey = $(".dumb .gdefaults").find(".tenorapi").text();
    var lmt = $(".dumb .gdefaults").find(".tenorlimit").text();
    if (term == undefined) {
        var srch = "trending?";
    } else {
        var srch = "search?tag=" + term;
    }
    var search_url = "https://api.tenor.com/v1/"+srch+"&key="+apikey+"&limit=" +lmt;
    httpGetAsync(search_url, tenorCallback_search);
    return;
}
$("body").on('click', '.gr-gif', function(e) {
    if ($(".grgif").is(':visible')) {
        $(".swr-grupo .panel > .room").css("padding-bottom", "80px");
        $(".grgif").hide();
        grscroll($(".swr-grupo .panel > .room > .msgs"), 'resize');
    } else {
        if (!$(this).hasClass('opnd')) {
            grab_data();
        }
        $(this).addClass('opnd');
        $(".swr-grupo .panel > .room").css("padding-bottom", "334px");
        grscroll($(".swr-grupo .panel > .room > .msgs"), 'resize');
        scrollmsgs();
        $(".emojionearea > .emojionearea-editor").css("height", "20px");
        $(".grgif").addClass('animated fadeInUp fastest').show();
    }
});

$("body").on('click', '.grgif > .wrap > div > .grgifconts > li', function(e) {
    var gfm = $(this).attr('gif');
    var gif = $(this).find('img').attr('src');
    var gfw = $(this).find('img').get(0).naturalWidth;
    var gfh = $(this).find('img').get(0).naturalHeight;
    grsendmsg($(this), e, gif, gfm, gfw, gfh);
});
$('.grgif > div > .search > input').on('keypress', function(e) {
    if (e.which == 13) {
        grab_data($(this).val());
    }
});