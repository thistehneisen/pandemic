<?php if(!defined('s7V9pz')) {die();}?>var alertitle;
var gruploader;
var webthumbnail = null;
$("body").on('click', '.swr-grupo .aside > .tabs > ul > li,.loadside', function(e) {
    loadlist($(this), e);
});
function loadlist(el, e) {
    el.attr('type', 'json');
    el.attr('spin', 'off');
    el.attr('process', '1');
    el.find('i').html('');
    $('.tooltip').remove();
    $('.swr-grupo .'+el.attr('side')+' .listloader').removeClass('error').fadeIn();
    $proc = $(".swr-grupo ."+el.attr('side')+" > .content > .list").parent().find('.grproceed');
    if (!el.hasClass("grproceed")) {
        $proc.addClass("loadside");
        $(".swr-grupo ."+el.attr('side')+" > .content > .list").scrollTop(0);
        $('.swr-grupo .'+el.attr('side')+' > .tabs > ul > li').removeClass("active");
        if (el.hasClass('loadside')) {
            $('.swr-grupo .'+el.attr('side')+' > .tabs > ul > li.xtra').html('<span>'+el.text()+'</span>');
            $('.swr-grupo .'+el.attr('side')+' > .tabs > ul > li.xtra').addClass('active');
            $('.swr-grupo .'+el.attr('side')+' > .tabs > ul > li.xtra').attr('side', el.attr('side'));
            $('.swr-grupo .'+el.attr('side')+' > .tabs > ul > li.xtra').attr('act', el.attr('act'));
            if (el.attr('srch') != undefined) {
                $('.swr-grupo .'+el.attr('side')+' > .tabs > ul > li.xtra').attr('srch', el.attr('srch'));
            }
            $('.swr-grupo .'+el.attr('side')+' > .tabs > ul > li.xtra').attr('zero', el.attr('zero'));
            $('.swr-grupo .'+el.attr('side')+' > .tabs > ul > li.xtra').attr('zval', el.attr('zval'));
        } else {
            el.addClass("active");
        }
    }
    $proc.attr('side', el.attr('side'));
    $proc.attr('act', el.attr('act'));
    $proc.text(el.text());
    var ofs = sofs = 0;
    if (el.hasClass("grproceed")) {
        ofs = $proc.attr('offset');
        sofs = $proc.attr('soffset');
    }
    var data = {
        act: 1,
        do: "list",
        type: el.attr('act'),
        gid: $('.swr-grupo .panel').attr('no'),
        ldt: $('.swr-grupo .panel').attr('ldt'),
        offset: ofs,
        soffset: sofs,
        search: el.attr('srch'),
        xtra: el.attr('xtra'),
        ex: el.data(),
    };
    var s = 'var soffst=offst="off";$(".swr-grupo .aside > .content > .list").removeClass();$(".swr-grupo .aside > .content > ul").addClass("list fh '+el.attr('act')+'");';
    s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .list").hide();';
    s = s+'offst=data[0].offset;';
    s = s+'soffst=data[0].soffset;';
    s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .addmore").removeClass("shw");';
    s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .addmore").addClass(data[0].shw);';
    s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .addmore > span").attr("mnu",data[0].mnu);';
    s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .addmore > span").attr("act",data[0].act);';
    s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .addmore > span").html("<i class="+data[0].icn+"></i>");';
    s = s+'var list="";$.each(data, function(k, v) {if (k !== 0) {';
    s = s+'list=list+"<li "+data[k].id+"> <div><span class='+"'"+'left lrmbg'+"'"+'><img class=lazyimg data-src="+data[k].img+">';
    s = s+'</span><span class=center><b><span data-toggle=tooltip title='+"'"+'"+htmlDecode(data[k].name)+"'+"'"+'>"+htmlDecode(data[k].name)+"</span></b><i class="+data[k].icon+"></i>";';
    s = s+'if(data[k].count!="0"){if(data[k].countag!="0"){list=list+"<u cnt="+data[k].count+">"+data[k].count+" "+data[k].countag+"</u>";}}';
    s = s+'list=list+"<span>"+data[k].sub+"</span></span><span class=right>';
    s = s+'<span class=opt "+data[k].rtag+"><i>"+data[k].right+"</i><ul>";';
    s = s+'if(data[k].oa!==0){list=list+"<li "+data[k].oat+">"+data[k].oa+"</li>";}';
    s = s+'if(data[k].ob!==0){list=list+"<li "+data[k].obt+">"+data[k].ob+"</li>";}';
    s = s+'if(data[k].oc!==0){list=list+"<li "+data[k].oct+">"+data[k].oc+"</li>";}';
    s = s+'list=list+"</ul></span></span></div></li>";';
    s = s+'}});if(data===null || data.length===1){';
    s = s+'list="<div class=zeroelem> <div> <span>'+el.attr('zero')+'<span>'+el.attr('zval')+'</span> </span> </div> </div>";';
    s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .grproceed").removeClass("loadside");';
    s = s+'}$(".swr-grupo .'+el.attr('side')+' > .tabs > ul > li.active > i").html("");';
    if (el.hasClass('appnd')) {
        s = s+'if(data!=null && data.length!=1){';
        s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .list").append(list);';
        s = s+'}';
    } else {
        s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .list").html(list);';
    }
    s = s+'grscroll($(".swr-grupo .'+el.attr('side')+' > .content > .list"),"resize");';
    s = s+'$("[data-toggle=tooltip]").tooltip();';
    s = s+'var sdr="'+el.attr('side')+'";if (sdr=="rside") {';
    s = s+'$(".swr-grupo .rside > .content .profile").hide();}';

    if (el.hasClass('dofirst')) {
        s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .list > li:first-child").trigger("click");';
        el.removeClass('dofirst');
    }

    if (el.attr('list') !== undefined) {
        s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .list > li[no='+el.attr('list')+']").trigger("click");';
        el.removeAttr('list');
    }

    if (el.attr('act') === 'groups' || el.attr('act') === 'pm') {
        s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .list > li[no="+$(".swr-grupo .panel").attr("no")+"]").addClass("active");';
        if (el.attr('openid') !== undefined) {
            s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .list > li[no='+el.attr('openid')+']").trigger("click");';
            el.removeAttr('openid');
        }
        if (el.attr('openfirstz') !== undefined && $(".dumb .gdefaults > .defload").attr('no') == undefined) {
            if ($(window).width() > 767.98) {
                s = s+'setTimeout(function() {$(".swr-grupo .'+el.attr('side')+' > .content > .list > li.paj:first-child").trigger("click");}, 500);';
            }
            el.removeAttr('openfirst');
        }
    }
    s = s+'if(offst!="off"){$(".swr-grupo .'+el.attr('side')+' > .content > .grproceed").attr("offset",offst);}';
    s = s+'if(soffst!="off"){$(".swr-grupo .'+el.attr('side')+' > .content > .grproceed").attr("soffset",soffst);}';
    s = s+'$(".swr-grupo .'+el.attr('side')+' .listloader").fadeOut();';
    s = s+'$(".swr-grupo .'+el.attr('side')+' > .content > .list").fadeIn();';
    var f = '$(".swr-grupo .'+el.attr('side')+' .listloader").addClass("error");';
    var ajv = 'loadlist'+el.attr('side');
    var grlv = 'gr_live();';
    s = s+grlv;
    f = f+grlv;
    ajxx(el, data, s, e, f, ajv);
}

$("body").on('mouseenter', '.swr-grupo .aside > .content .profile > .top > span.edit > span', function(e) {
    $(".swr-grupo .aside > .content .profile > .top > span.dp").fadeOut();
    $(".swr-grupo .aside > .content .profile > .top > span.name").fadeOut();
    $(".swr-grupo .aside > .content .profile > .top > span.role").fadeOut();
    $(".swr-grupo .aside > .content .profile > .top > span.coverpic > span").fadeOut();
});

$("body").on('mouseleave', '.swr-grupo .aside > .content .profile > .top > span.edit > span', function(e) {
    $(".swr-grupo .aside > .content .profile > .top > span.dp").fadeIn();
    $(".swr-grupo .aside > .content .profile > .top > span.name").fadeIn();
    $(".swr-grupo .aside > .content .profile > .top > span.role").fadeIn();
    $(".swr-grupo .aside > .content .profile > .top > span.coverpic > span").fadeIn();
});

$("body").on('click', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > .info > i.tick.recieved', function(e) {
    if ($('.swr-grupo .panel').attr('ldt') != 'user') {
        if ($(window).width() <= 767.98) {
            $('[data-toggle="tooltip"]').tooltip('hide');
            $(".swr-grupo .lside .opt > ul").hide();
            $('.swr-grupo .lside,.swr-grupo .panel').removeClass('abmob');
            $(".swr-grupo .lside,.swr-grupo .panel").addClass("bwmob");
            $('.swr-grupo .rside > .top > .left > .icon').attr('data-block', 'alerts');
            if (!$('.rside').hasClass('abmob')) {
                $(".swr-grupo .rside").css("margin-left", "800px");
                setTimeout(function() {
                    $(".swr-grupo .rside").removeClass("nomob");
                    $(".swr-grupo .rside").addClass("abmob");
                    $(".swr-grupo .rside").animate({
                        marginLeft: "0px"
                    }, 500);
                }, 200);
            }
        }
        $('.dumb .lastseenz').attr('srch', $(this).parents('li').attr('no'));
        $('.dumb .lastseenz').trigger('click');
    }
});

$("body").on('mouseenter', '.swr-grupo .panel > .room > .msgs > li', function(e) {
    $('.swr-grupo .msgopt > ul').hide();
    $(this).find('.msgopt i').hide();
    $(this).find('.msgopt ul').css('display', 'inline');
});

$("body").on('mouseleave', '.swr-grupo .panel > .room > .msgs > li', function(e) {
    $('.swr-grupo .msgopt > ul').hide();
});

$("body").on('mouseenter', '.swr-grupo .aside > .content > .list > li', function(e) {
    $('.swr-grupo .opt > ul').hide();
    if ($(window).width() > 767.98) {
        $('.swr-grupo .opt > i').show();
    }
    $(this).find('.opt > i').hide();
    $(this).find('.opt > ul').css('display', 'contents');
});

$("body").on('mouseleave', '.swr-grupo .aside > .content > .list > li', function(e) {
    if ($(window).width() > 767.98) {
        $('.swr-grupo .opt > i').show();
    }
    $('.swr-grupo .opt > ul').hide();
});
$('.swr-grupo').on('hover blur focus tap touchstart', function(e) {
    if (alertitle != undefined) {
        clearTimeout(alertitle);
        $(".dumb .newmsgalert").attr('alert', 'off');
        document.title = $(".dumb .webtitle").text();
    }
});
$('.swr-grupo').on('click tap touchstart', function(e) {
    if (!$(e.target).parent().parent().hasClass('swr-menu') && !$(e.target).hasClass('subnav')) {
        if (!$(e.target).parent().hasClass('langswitch')) {
            $('.swr-menu').hide();

        }
    }
    if (!$(e.target).hasClass('gr-gif') && !$(e.target).parents('.grgif').hasClass('grgif')) {
        $(".swr-grupo .panel > .room").css("padding-bottom", "80px");
        $(".grgif").hide();
    }
});

$('body').on('click', '.swr-grupo .aside > .content > .addmore > span', function(e) {
    var c = $(this).attr('mnu');
    var i = $(this).attr('act');
    if (i == 'uploadfile') {
        $('.swr-grupo .aside > .head > .icons > i.udolist .uploadfiles > input[type=file]').trigger('click');
    } else {
        menuclick(c, i);
    }
});

$('body').on('click', '.swr-grupo .panel > .room > .msgs > li .usrment', function(e) {
    if ($(this).attr("mention") != 0 && $('.swr-grupo .panel').attr('ldt') != 'user') {
        var ta = $(".swr-grupo .panel > .textbox > .box > textarea").data("emojioneArea");
        if ($('.emojionearea > .emojionearea-editor:contains("'+$(this).attr("mention")+'")').length == 0) {
            ta.setText('@'+$(this).attr("mention")+ta.getText());
            $('.emojionearea > .emojionearea-editor').focus();
            placeCaretAtEnd($(".emojionearea > .emojionearea-editor").data("emojioneArea").editor[0]);
        }
    }
});

$('body').on('mouseenter', ".swr-grupo .panel > .room > .msgs > li", function(e) {
    $(".msg span.opts").hide();
    $(this).find(".msg span.opts").css('display', 'contents');
});
$('body').on('mouseleave', ".swr-grupo .panel > .room > .msgs > li", function(e) {
    $(".msg span.opts").hide();
});
$("html").on("dragover", function(e) {
    e.preventDefault();
    e.stopPropagation();
});
$("html").on("click", function(e) {
    $(".swr-grupo .dragfile").hide();
    $('.tooltip').remove();
});
$("html").on("drop", function(e) {
    e.preventDefault(); e.stopPropagation();
    $(".swr-grupo .dragfile").hide();
});
$('.swr-grupo .panel').on('dragover', function (e) {
    if ($(".swr-grupo .panel").attr("no") != 0 && $('.gr-attach').is(":visible")) {
        if (!$(".swr-grupo .panel > .textbox").hasClass('slideOutDown')) {
            e.stopPropagation();
            e.preventDefault();
            $(".swr-grupo .dragfile").hide();
            $(".swr-grupo .panel .dragfile").show();
        }
    }
});

$('.swr-grupo .panel').on('drop', function (e) {
    if ($(".swr-grupo .panel").attr("no") != 0 && $('.gr-attach').is(":visible")) {
        if (!$(".swr-grupo .panel > .textbox").hasClass('slideOutDown')) {
            e.stopPropagation();
            e.preventDefault();
            $(".swr-grupo .panel .dragfile").hide();
            var file = e.originalEvent.dataTransfer.files;
            $('.swr-grupo .atchmsg .attachfile').prop('files', file);
            $('.swr-grupo .atchmsg .attachfile').trigger("change");
        }
    }
});

$('.swr-grupo .lside').on('dragover', function (e) {
    if ($('.uploadable').is(":visible")) {
        e.stopPropagation();
        e.preventDefault();
        $(".swr-grupo .dragfile").hide();
        $(".swr-grupo .lside .dragfile").show();
    }
});

$('.swr-grupo .lside').on('drop', function (e) {
    if ($('.uploadable').is(":visible")) {
        e.stopPropagation();
        e.preventDefault();
        $(".swr-grupo .lside .dragfile").hide();
        var file = e.originalEvent.dataTransfer.files;
        $('.swr-grupo .uploadfiles > input').prop('files', file);
        $('.swr-grupo .uploadfiles > input').trigger("change");
    }
});

$('.swr-grupo .gr-qrcode').on('click', function (e) {
    if ($(this).hasClass("active")) {
        $(this).removeClass("animated bounceIn infinite active");
    } else {
        $(this).addClass("animated bounceIn infinite active");
    }
    $('.emojionearea > .emojionearea-editor').focus();
    var el = $(".emojionearea > .emojionearea-editor")[0];
    var pos = $(".emojionearea > .emojionearea-editor").attr("inx");
    SetCaretPosition(el, pos);
});

$(document).on('paste', function(e) {
    var sharescreenshot = $.trim($(".dumb .gdefaults > .sharescreenshot").text());
    if (sharescreenshot == 1) {
        if (!$('.swr-grupo .panel > .textbox').hasClass('slideOutDown')) {
            var items = (e.clipboardData || e.originalEvent.clipboardData).items;
            var blob = null;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") === 0) {
                    blob = items[i].getAsFile();
                }
            }
            if (blob !== null) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var data = {
                        act: 1,
                        do: 'files',
                        type: 'pastescreen',
                        gid: $('.swr-grupo .panel').attr('no'),
                        ldt: $('.swr-grupo .panel').attr('ldt'),
                        from: grlastid(),
                        shot: event.target.result,
                    };
                    $('.pastescreen').attr('type', 'json');
                    $('.pastescreen').attr('load', $(".gphrases > .uploading").text());
                    $('.pastescreen').attr('lsub', $(".gphrases > .pleasewait").text());
                    var s = 'loadmsg(data);';
                    var f = grlv = 'gr_live();';
                    s = s+grlv;
                    ajxx($('.pastescreen'), data, s, e, f, 'screenshotz', 'grlive');
                };
                reader.readAsDataURL(blob);
            }
        }
    }
});


$('body').on('click', '.swr-grupo .panel .fullview', function(e) {
    if ($('.swr-grupo .aside').hasClass("fold")) {
        $('.swr-grupo .aside').removeClass("fold");
        $('.swr-grupo .panel').removeClass("full");
    } else {
        $('.swr-grupo .aside').addClass("fold");
        $('.swr-grupo .panel').addClass("full");
    }
    grscroll($(".swr-grupo .panel > .room > .msgs"), 'resize', 510);
});

function grscroll($el, $do, $xtra) {
    if ($do == undefined) {
        $do = 'scroll';
    }
    if ($xtra == undefined) {
        $xtra = '#d4d4d4';
    }
    if ($do == 'scroll') {
        $($el).niceScroll({
            cursorwidth: "8px",
            cursoropacitymin: 0,
            cursoropacitymax: 0.7,
            cursorcolor: $xtra,
            cursorborder: 'none',
            cursorborderradius: 4,
            autohidemode: 'leave',
            smoothscroll: true,
            horizrailenabled: false
        });
    } else if ($do == 'remove') {
        $($el).getNiceScroll().remove();
    } else if ($do == 'hide') {
        $($el).getNiceScroll().hide();
    } else if ($do == 'resize') {
        if ($xtra == '#d4d4d4') {
            $xtra = 200;
        }
        $($el).getNiceScroll().hide();
        setTimeout(function() {
            $($el).getNiceScroll().onResize();
            $($el).getNiceScroll().show();
        }, $xtra);
    }
}

$('body').on('click', '.swr-grupo .loadgroup,.dumb .loadgroup', function(e) {
    $('.swr-grupo .aside > .content > .list > li').removeClass("active");
    $(this).addClass("active");
    loadgroup($(this).attr('no'), $(this));
});
$('body').on('click', '.swr-grupo .aside > .content > .list > li', function(e) {
    if ($(window).width() <= 767.98 && !$(this).hasClass('loadgroup')) {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.swr-grupo .aside .opt > ul').hide();
        $(this).find('.opt > ul').css('display', 'contents');
    }
});
$('body').on('click', '.swr-grupo .panel > .room > .msgs > li', function(e) {
    if ($(window).width() <= 767.98) {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.swr-grupo .msgopt > ul').hide();
        $(this).find('.msgopt > ul').css('display', 'inline');
    }
});

$('body').on('click', '.swr-grupo .mbopen', function(e) {
    if ($(window).width() <= 767.98 && !$(this).hasClass('loadgroup')) {
        $('[data-toggle="tooltip"]').tooltip('hide');
        if ($(this).attr('data-block') == 'panel' && $('.swr-grupo .panel').attr('no') != 0) {
            $('.swr-grupo .lside').addClass('bwmob');
            $('.swr-grupo .panel').css('margin-left', '800px');
            setTimeout(function() {
                $('.swr-grupo .panel').removeClass('nomob');
                $('.swr-grupo .panel').addClass('abmob');
                $('.swr-grupo .panel').animate({
                    marginLeft: '0px'
                }, 500);
            }, 200);
        } else if ($(this).attr('data-block') == 'rside') {
            $('.swr-grupo .lside .opt > ul').hide();
            $('.swr-grupo .rside > .top > .left > .icon').attr('data-block', $(this).attr('data-block'));
            $('.swr-grupo .lside,.swr-grupo .panel').addClass('bwmob');
            $('.swr-grupo .rside').css('margin-left', '800px');
            $('.grtab').addClass('d-none');
            setTimeout(function() {
                $('.swr-grupo .rside').removeClass('nomob');
                $('.swr-grupo .rside').addClass('abmob');
                $('.swr-grupo .rside').animate({
                    marginLeft: '0px'
                }, 500);
            }, 200);
        }
    }
});

$('body').on('click', '.swr-grupo .standby', function() {
    $.when($('.swr-grupo > .window').fadeOut())
    .then(function() {
        $('.grupo-standby').fadeIn();
    });

});
$('body').on('click', '.grupo-standby', function() {
    $.when($('.grupo-standby').fadeOut())
    .then(function() {
        $('.swr-grupo > .window').fadeIn();
    });

});

$('body').on('click', '.swr-grupo .goback', function(e) {
    if ($(window).width() <= 767.98) {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.swr-grupo .lside .opt > ul').hide();

        var block = $(this).attr('data-block');
        if (block == 'alerts' || block == 'rside') {
            $('.swr-grupo .rside').animate({
                marginLeft: '800px'
            }, 200);
            setTimeout(function() {
                $('.swr-grupo .rside').addClass('nomob');
                $('.swr-grupo .rside').removeClass('abmob');
                $('.swr-grupo .lside').removeClass('bwmob');
            }, 600);
        } else if (block == 'crew' || block == 'palert') {
            $('.swr-grupo .rside').animate({
                marginLeft: '800px'
            }, 200);
            setTimeout(function() {
                $('.swr-grupo .rside').addClass('nomob');
                $('.swr-grupo .rside').removeClass('abmob');
                $('.swr-grupo .panel').removeClass('bwmob');
                $('.swr-grupo .panel').addClass('abmob');
            }, 500);
        } else {
            $(".swr-grupo .panel > .textbox").addClass('disabled');
            $('.swr-grupo .panel').animate({
                marginLeft: '800px'
            }, 200);
            setTimeout(function() {
                $('.swr-grupo .panel').addClass('nomob');
                $('.swr-grupo .panel').removeClass('abmob');
                $('.swr-grupo .lside').removeClass('bwmob');
            }, 500);
            if (block == 'files') {
                $('.swr-grupo .lside > .tabs > ul > li[act=files]').trigger('click');
            }
        }
    }
});


$(".swr-grupo .panel > .textbox > .box > textarea").blur(function() {
    if ($(window).width() <= 767.98) {
        $('[data-toggle="tooltip"]').tooltip('hide');
        setTimeout(function() {
            $('.swr-grupo .panel > .room > .msgsdd').animate({
                height: $('.swr-grupo .panel > .room').height()-160
            }, 200);
        }, 200);
    }
});
$('body').on('click', '.swr-grupo .goright', function(e) {
    $('.swr-grupo .lside .opt > ul').hide();
    $('.swr-grupo .rside > .top > .left > .icon').attr('data-block', $(this).attr('data-block'));
    $('.swr-grupo .lside,.swr-grupo .panel').addClass('bwmob');
    $('.swr-grupo .rside').css('margin-left', '800px');
    if ($(this).attr('data-block') == 'crew') {
        $('.swr-grupo .lside,.swr-grupo .panel').removeClass('abmob');
        $('.swr-grupo .rside > .tabs > ul > li').eq(1).trigger('click');
        $('.grtab').removeClass('d-none');
    } else if ($(this).attr('data-block') == 'palert') {
        $('.grtab').addClass('d-none');
        $(".swr-grupo i.malert").html("");
        $('.swr-grupo .lside,.swr-grupo .panel').removeClass('abmob');
        $('.swr-grupo .rside > .tabs > ul > li').eq(0).trigger('click');
    } else {
        $('.grtab').addClass('d-none');
        $(".swr-grupo i.malert").html("");
        $('.swr-grupo .rside > .tabs > ul > li').eq(0).trigger('click');
    }
    setTimeout(function() {
        $('.swr-grupo .rside').removeClass('nomob');
        $('.swr-grupo .rside').addClass('abmob');
        $('.swr-grupo .rside').animate({
            marginLeft: '0px'
        }, 500);
    }, 200);
});

$('.swr-grupo .aside > .head > .logo').on('click', function() {
    window.location.href = "";
});

jQuery(document).ready(function($) {

    if (window.history && window.history.pushState) {

        $(window).on('popstate', function() {
            var hashLocation = location.hash;
            var hashSplit = hashLocation.split("#!/");
            var hashName = hashSplit[1];

            if (hashName !== '') {
                var hash = window.location.hash;
                if (hash === '') {
                    if ($('.swr-grupo .panel > .room > .groupreload > i').is(':visible')) {
                        $('.swr-grupo .panel > .room > .groupreload > i').trigger('click');
                        window.history.pushState('forward', null, './#initiated');
                    } else {
                        if ($('.swr-grupo .panel').is(':visible') && !$('.swr-grupo .panel').hasClass('bwmob')) {
                            $('.swr-grupo .panel > .head > .icon.goback').trigger('click');
                        } else if ($('.swr-grupo .rside').is(':visible')) {
                            $('.swr-grupo .rside > .top > .left > .icon.goback').trigger('click');
                        }
                    }
                    if ($('.swr-grupo .lside').is(':visible') && $('.swr-grupo .lside').hasClass('bwmob')) {
                        window.history.pushState('forward', null, './#initiated');
                    }
                }
            }
        });

        window.history.pushState('forward', null, './#initiated');
    }

});
$('body').on('click', '.swr-grupo .opt > ul > li', function(e) {
    if (!$(this).hasClass('formpop') && !$(this).hasClass('paj') && !$(this).hasClass('vwp')) {
        $(this).attr('type', 'html');
        $(this).attr('spin', 'on');
        $(this).attr('load', $(".gphrases > .loading").text());
        $(this).attr('lsub', $(".gphrases > .pleasewait").text());
        var data = {
            act: 1,
            do: $(this).parent().parent().attr('type'),
            type: $(this).attr('act'),
            gid: $('.swr-grupo .panel').attr('no'),
            id: $(this).parent().parent().attr('no'),
            ldt: $('.swr-grupo .panel').attr('ldt'),
        };
        data = $.extend(data, $(this).data());
        var s = f = '';
        if (data['type'] === 'addgroupuser' && $('.swr-grupo .panel').attr('no') != 0) {
            if ($('.swr-grupo .panel').attr('ldt') != 'user') {
                $(this).attr('type', 'json');
                $(this).attr('spin', 'off');
                data['do'] = 'group';
                s = '$(".swr-grupo .lside > .tabs > ul > li.xtra").trigger("click");';
                s = s+'if($(".swr-grupo .panel").attr("no")==data[2].gid){loadmsg(data);}';
            } else {
                location.reload();
                return false;
            }
        }
        if (data['type'] === 'share') {
            if ($('.swr-grupo .panel').attr('no') != 0) {
                $(this).attr('type', 'json');
                $(this).attr('spin', 'off');
                var senid = rand(8);
                var moset = $(".dumb .gdefaults").find(".sndmsgalgn").text();
                $(".swr-grupo .panel > .room > .msgs").animate({
                    scrollTop: $(".swr-grupo .panel > .room > .msgs").prop("scrollHeight")
                }, 500);
                var senmsg = $(this).parent().parent().attr('no');
                senmsg = senmsg.split("-gr-")[1];
                var msg = '<li class="you animated fadeIn '+senid+' '+moset+'" no="0"> <div><span class="msg"><i>';
                msg = msg+'<span class="block" type="files"><span>'+(escapeHtml(senmsg))+'<span class="animated fadeInUp infinite">';
                msg = msg+'<i class="gi-upload"></i></span></span></span></i>';
                msg = msg+'</span></div></li>';
                $('.swr-grupo .panel > .room > .msgs').append(msg);
                scrollmsgs();
                s = '$(".'+senid+'").remove();if($(".swr-grupo .panel").attr("no")==data[2].gid){loadmsg(data);}';
                f = '$(".swr-grupo .panel > .room > .msgs > li.'+senid+' > div > .msg > i > span.block > span > span > i").removeClass("gi-upload");';
                f = f+'$(".swr-grupo .panel > .room > .msgs > li.'+senid+' > div > .msg > i > span.block > span > span").removeClass("animated");';
                f = f+'$(".swr-grupo .panel > .room > .msgs > li.'+senid+' > div > .msg > i > span.block > span > span > i").addClass("gi-minus-circled-1");';
                f = f+'setTimeout(function() {$(".'+senid+'").remove();}, 2000);';
            } else {
                s = 'eval(data);';
            }
        }
        if ($(this).hasClass('deval')) {
            s = 'eval(data);';
        }
        if (data['do'] === 'group' && data['type'] === 'msgs') {
            $(this).attr('type', 'json');
            s = 'loadmsg(data,1);';
        }
        data = $.extend(data, $(this).data());
        var ajv = 'listoptz'+data['type'];
        var grlv = 'gr_live();';
        s = s+grlv;
        f = f+grlv;
        ajxx($(this), data, s, e, f, ajv, 'grlive');
    }
});
function menuclick(c, i) {
    $('.'+c+' > .swr-menu > ul > li[act="'+i+'"]').trigger('click');
    $('.'+c+' > .swr-menu').hide();
}
function loadgroup($id, e, r) {
    if (r == undefined) {
        r = 0;
    }
    $('.swr-grupo .panel').attr('noscroll', 0);
    $('.swr-grupo li.xtra[act="lastseen"]').text("");
    if ($(window).width() <= 767.98 && r != 1) {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.swr-grupo .lside').addClass('bwmob');
        if (e.parents('.aside').hasClass('rside')) {
            $('.swr-grupo .rside').addClass('bwmob');
            $('.swr-grupo .rside').css('zIndex', 20);
            $('.swr-grupo .rside').removeClass('abmob');
            $('.swr-grupo .rside').animate({
                marginLeft: '800px'
            }, 500);
            setTimeout(function() {
                $('.swr-grupo .rside').addClass('nomob');
                $('.swr-grupo .rside').css('zIndex', 1);
            }, 800);
        } else {
            $('.swr-grupo .panel').css('margin-left', '800px');
        }
        setTimeout(function() {
            $('.swr-grupo .panel').removeClass('nomob');
            $('.swr-grupo .panel').addClass('abmob');
            $('.swr-grupo .panel').animate({
                marginLeft: '0px'
            }, 500);
        }, 200);
    }
    if ($id != $('.swr-grupo .panel').attr('no') || r == 1 || e.attr('msgload') != undefined) {
        $(".swr-grupo .panel > .room > .msgs").html('');
        e.find('div > .center > u').hide();
        $('.swr-grupo .panel > .textbox').addClass('disabled');
        $('.swr-grupo .panel').attr('no', e.attr('no'));
        $('.swr-grupo .panel').attr('ldt', e.attr('ldt'));
        if (e.attr('ldt') == 'user') {
            $('.swr-grupo .panel > .head > .left > span').addClass('vwp');
            $('.swr-grupo .panel > .head > .left > span').attr('no', e.attr('no'));
            $('.swr-grupo .panel > .head > .right > .gi-users').hide();
        } else {
            $('.swr-grupo .panel > .head > .left > span').removeClass('vwp');
            $('.swr-grupo .panel > .head > .right > .gi-users').show();
        }
        $(".swr-grupo .rside > .tabs > ul > li").eq(2).find('i').html("");
        $(".swr-grupo .rside > .tabs > ul > li").eq(2).attr('comp', 0);
        $("#graudio")[0].pause();
        $("#graudio > source").attr("src", "");
        $(".grupo-preview > div .prclose").trigger("click");
        $(".swr-grupo .msgloader").removeClass('error').fadeIn();
        e.attr('spin', 'off');
        e.attr('type', 'json');
        e.attr('turn', 'on');
        var ldt = e.attr('ldt');
        var data = {
            act: 1,
            do: "group",
            type: 'msgs',
            id: $id,
            ldt: ldt,
        };
        var typing = '<ul class=typing></ul>';
        var s = 'loadmsg(data,1);';
        s = s+'$(".swr-grupo .groupnav > .left > span > img").remove();';
        s = s+'$(".swr-grupo .groupnav > .left > span").prepend("<img class=lazyimg>");';
        s = s+'$(".swr-grupo .groupnav > .left > span > img").attr("data-src", data[0].pnimg);';
        s = s+'$(".swr-grupo .groupnav > .left > span > span").html(data[0].pntitle+"<span>"+data[0].pnsub+"</span>'+typing+'");';
        s = s+'if(data[0].blocked==1 || data[0].deactiv==1){$(".swr-grupo .panel > .textbox").addClass("animated slideOutDown");';
        s = s+'$(".swr-grupo .panel > .head > .left > span").removeClass("vwp");}else{';
        s = s+'$(".swr-grupo .panel > .textbox").removeClass("animated slideOutDown");}';
        s = s+'$(".swr-grupo .panel > .textbox").removeClass("disabled");';
        s = s+'$(".swr-grupo .panel .swr-menu > ul").html("");';
        s = s+'$.each(data[1], function(k, v) {';
        s = s+'$(".swr-grupo .panel .swr-menu > ul").append("<li "+v[1]+">"+v[0]+"</li>");';
        s = s+'});';
        if (e.attr('msgload') == undefined) {
            s = s+'if ($(window).width() > 767.98 && $(".swr-grupo .panel").attr("ldt")!="user") { $(".swr-grupo .rside > .tabs > ul > li").eq(1).trigger("click"); }';
            s = s+'if ($(window).width() > 767.98 && $(".swr-grupo .panel").attr("ldt")=="user") { $(".swr-grupo .rside > .tabs > ul > li").eq(0).trigger("click"); }';
        }
        s = s+'$(".emojionearea > .oldemojionearea-editor").focus();';
        var f = '$(".swr-grupo .msgloader").addClass("error");';
        var grlv = 'gr_live();';
        s = s+grlv;
        f = f+grlv;

        if (e.attr('msgload') != undefined) {
            data['msid'] = e.attr('msgload');
            s = s+'turn_chat()';
        }
        ajxx(e, data, s, e, f, 'loadgroup', 'grlive,searchmsgs');
        $('.groupreload').fadeOut();
        $('.swr-grupo .panel > .textbox,.swr-grupo .groupnav').removeClass('d-none');
        $('.grtab').addClass('d-none');
        if ($('.swr-grupo .panel').attr('ldt') != 'user') {
            $('.grtab').removeClass('d-none');
        }
    }
}
function grtyping(cnt) {
    if (cnt != undefined) {
        $('.swr-grupo .panel > .head > .left > span > span > .typing').html(cnt);
    }
    var elm = $('.swr-grupo .panel > .head > .left > span > span > .typing > li');
    if (elm.length != 0) {
        $('.swr-grupo .panel > .head > .left > span > span > span').hide();
        elm.eq(0).css('display', 'flex');
        if (elm.length > 1) {
            setTimeout(function() {
                elm.eq(0).hide().next().css('display', 'flex').end().appendTo(elm.parent());
                grtyping();
            }, 1200);
        }
    } else {
        $('.swr-grupo .panel > .head > .left > span > span > span').show();
    }
}
$('body').on('click', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > i.rply > i', function() {
    var id = $(this).attr('no');
    var el = $(".swr-grupo .panel > .room > .msgs > li[no="+id+"]");
    var scr = $(".swr-grupo .panel > .room > .msgs > li:nth-child("+el.index()+")")[0].offsetTop - $(".swr-grupo .panel > .room > .msgs")[0].offsetTop;
    $(".swr-grupo .panel > .room > .msgs").animate({
        scrollTop: scr
    }, 1000);
    el.addClass('highlight');
    setTimeout(function() {
        el.removeClass('highlight');
    }, 3000);
});

function escapeHtml(str) {
    return $('<grescp>').text(str).html();
}
function scrollmsgs($in, $tm) {
    if ($in == undefined) {
        $in = 500;
    }
    if ($tm == undefined) {
        $tm = 0;
    }
    var elem = $(".swr-grupo .panel > .room > .msgs");
    if ($(".swr-grupo .panel").attr('scrolldown') != 'off') {
        setTimeout(function() {
            $(".swr-grupo .panel > .room > .msgs").animate({
                scrollTop: $(".swr-grupo .panel > .room > .msgs").prop("scrollHeight")}, $in);
        }, $tm);
    }
}
$('.swr-grupo .sendbtn').on('click', function(e) {
    grsendmsg($(this), e);
});
function grsendmsg(el, e, gif, gfm, gfw, gfh) {
    if (gif == undefined) {
        gif = 0;
    }
    if (gfm == undefined) {
        gfm = 0;
    }
    if (gfw == undefined) {
        gfw = 0;
    }
    if (gfh == undefined) {
        gfh = 0;
    }
    var msgd = $(".swr-grupo .panel > .textbox > .box > textarea").data("emojioneArea").getText();
    var lmt = $(".dumb .gdefaults").find(".minmsglen").text();
    if (gif != 0 && gfm != 0 && gfw != 0 && gfh != 0 && !el.hasClass('na') || $.trim(msgd) != '' && !el.hasClass('na')) {
        if (lmt !== "" && gif == 0 && gfm == 0) {
            if (msgd.length < lmt) {
                say($(".gphrases > .minlenreq").text());
                return false;
            }
        }
        el.attr('spin', 'off');
        el.attr('type', 'json');
        el.attr('turn', 'on');
        var moset = $(".dumb .gdefaults").find(".sndmsgalgn").text();
        var qrcode = 0;
        if ($(".gr-qrcode").hasClass('active')) {
            qrcode = 1;
        }
        var senid = rand(8);
        var senmsg = $(".swr-grupo .panel > .textbox > .box > textarea").data("emojioneArea").getText();
        if (gif != 0 && gfm != 0) {
            prmsg = '<span class="preview image lrmbg"><span><img class="lazyimg tenor" gif="'+gfm+'" data-src="'+gif+'"/></span></span>';
            gif = senmsg = gif+"|"+gfw+"|"+gfh;
        } else {
            var prmsg = emojione.shortnameToImage(asciiemoji(url2link(escapeHtml(shwrdmre(senmsg)))));
        }
        var msg = '<li class="you animated fadeIn '+senid+' '+moset+'" no="0"> <div>';
        msg = msg+'<span class="msg"><i>'+prmsg;
        msg = msg+'<i class="info">'+$(".gphrases > .sending").text()+'<i class="tick recieved sending"><i></i><i></i></i></i>';
        msg = msg+'</i></span> </div> </li>';
        scrollmsgs(200, 0);
        $('.swr-grupo .panel > .room > .msgs').append(msg);
        $(".gr-qrcode").removeClass("animated bounceIn infinite active");
        $(".swr-grupo .panel > .room > .msgs").animate({
            scrollTop: $(".swr-grupo .panel > .room > .msgs").prop("scrollHeight")
        }, 500);
        var data = {
            act: 1,
            do: "group",
            type: 'sendmsg',
            gif: gif,
            gfm: gfm,
            msg: senmsg,
            qrcode: qrcode,
            rid: $('.swr-grupo .panel > .textbox .replyid').val(),
            id: $('.swr-grupo .panel').attr('no'),
            ldt: $('.swr-grupo .panel').attr('ldt'),
            from: grlastid(),
        };
        if (gif == 0 && gfm == 0) {
            $(".swr-grupo .panel > .textbox > .box > textarea").data("emojioneArea").setText('');
        }
        $(".swr-grupo .panel > .textbox .replyid").val(0);
        $(".swr-grupo .panel > .room > .msgs > li").removeClass("selected");
        var s = '$(".'+senid+'").remove();';
        s = s+'if($(".swr-grupo .panel").attr("no")==data[0].gid){loadmsg(data);}';
        var f = '$(".swr-grupo .panel > .room > .msgs > li.'+senid+' > div > .msg > i > .info").text("'+$(".gphrases > .failed").text()+'");';
        f = f+'setTimeout(function() {$(".'+senid+'").remove();}, 2000);';
        var grlv = 'gr_live();';
        s = s+grlv;
        f = f+grlv;
        ajxx(el, data, s, e, f, 'grsendmsg', 'grlive');
    }
    $('.emojionearea > .emojionearea-editor').trigger('click');
    $('.emojionearea > .emojionearea-editor').trigger('focus');
}
function grmsgexist(mid) {
    if (!$('.swr-grupo .panel > .room > .msgs > li[no='+mid+']').length) {
        return false;
    } else {
        return true;
    }
}
function loadmsg(d, n, fi) {
    if (n == undefined) {
        n = 0;
    }
    if (fi == undefined) {
        fi = 0;
    }
    $xptxt = 0;
    if (n == 1) {
        $(".swr-grupo .panel > .room > .msgs").html('');
    }
    var mntz = oldmsg = '';
    $.each(d, function(k, v) {
        if (k !== 0 && k !== 1) {
            var m = d[k];
            if (m.id === undefined) {
                m = d;
            }
            var trn = 0;
            if (grmsgexist(m.id) == false) {
                trn = 1;
            }
            if (trn == 1) {
                var vtid = rand(6);
                if (m.type == 'like') {
                    var lkcnt = "";
                    if (m.total != 0) {
                        lkcnt = "<i>"+nformat(m.total)+"</i>";
                    }
                    $(".swr-grupo .panel > .room > .msgs > li[no="+m.liked+"]").find(".lcount").html(lkcnt);
                    var msg = '<li class="like" no="'+m.id+'"> </li>';
                    $('.swr-grupo .panel > .room > .msgs').append(msg);
                } else {
                    var mntz = '';
                    var moset = $(".dumb .gdefaults").find(".rcvmsgalgn").text();
                    var bclass = m.send+' '+moset;
                    if (m.send == 'you') {
                        moset = $(".dumb .gdefaults").find(".sndmsgalgn").text();
                        bclass = m.send+' '+moset+' msgschk';
                    }
                    if (m.type == 'system') {
                        bclass = m.send;
                        if (m.domsg == 'created_group') {
                            bclass = m.send+' createdgroup';
                        }
                        if (n == 2) {
                            if (m.domsg == 'created_group') {
                                $('.swr-grupo .panel').attr('noscroll', 1);
                            }
                        } else if (n == 0) {
                            if (m.domsg == 'renamed_group') {
                                $(".swr-grupo .groupnav > .left > span > span").html(d[0].pntitle+"<span>"+d[0].pnsub+"</span>");
                            } else if (m.domsg == 'changed_group_icon') {
                                $(".swr-grupo .groupnav > .left > span > img").remove();
                                $(".swr-grupo .groupnav > .left > span").prepend("<img class=lazyimg>");
                                $(".swr-grupo .groupnav > .left > span > img").attr("data-src", d[0].pnimg);
                            } else if (m.domsg == 'changed_message_settings') {
                                if (d[0].deactiv == 1) {
                                    $(".swr-grupo .panel > .textbox").addClass("animated slideOutDown");
                                } else {
                                    $(".swr-grupo .panel > .textbox").removeClass("animated slideOutDown");
                                }
                            }
                        }
                    }
                    if (m.type == 'qrcode') {
                        bclass = bclass+' qrcode';
                    }
                    var msg = '<li class="'+bclass+' animated fadeIn" no="'+m.id+'"> <div>';
                    if (m.name != undefined) {
                        if (m.status == 'deactivated') {
                            mntz = '<i class="usrname">'+m.name+'</i>';
                        } else {
                            mntz = '<i class="usrname vwp" style="color:'+m.ncolor+'" no="'+m.userid+'">'+m.name+'</i>';
                        }
                    }
                    var moptz = '<span class="opts"><span>';
                    if (m.optb != 0) {
                        moptz += '<i '+m.optb+'></i>';
                    } else if (m.opta != 0) {
                        moptz += '<i '+m.opta+'></i>';
                    }
                    if (m.optc != 0) {
                        moptz += '<i '+m.optc+'></i>';
                    }
                    if (m.opte != 0) {
                        moptz += '<i '+m.opte+'></i>';
                    }
                    if (d[0]['likemsgs'] == 'enabled' && m.send != 'you') {
                        moptz += '<i class="gr-like '+m.lvc+'"></i>';
                    }
                    moptz += '</span></span><span class="lcount">';
                    if (m.lvn != 0 && $('.swr-grupo .panel').attr('ldt') == 'group' && d[0]['viewlike'] == 1) {
                        moptz += '<i>'+nformat(m.lvn)+'</i>';
                    }
                    moptz += '</span>';
                    msg = msg+'<span class="msg">';
                    if (moset === 'right' && m.send != 'system') {
                        msg = msg+moptz;
                    }
                    msg = msg+'<i>';
                    if (m.type === 'msg' || m.type === 'system' || m.type === 'qrcode') {
                        if (m.rid != 0) {
                            msg = msg+'<i class="rply"><i no="'+m.rid+'"><i>'+m.rusr+'</i>'+emojione.shortnameToImage(asciiemoji(shwrdmre(m.reply, 30)))+'</i></i>';
                        }
                        if (m.type === 'qrcode') {
                            msg = msg+mntz+'<span class="codeqr"><span>'+m.msg+'</span></span>';
                        } else {
                            msg = msg+mntz+emojione.shortnameToImage(asciiemoji(url2link(shwrdmre(m.msg))));
                        }
                    } else if (m.type === 'gifs') {
                        msg = msg+mntz;
                        msg = msg+'<span class="preview image lrmbg"><span><img class="lazyimg tenor" gif="'+m.xtra+'" data-src="'+m.msg+'" style="width:'+m.fwidth+'px;height:'+m.fheight+'px;"/></span></span>';
                    } else if (m.type === 'audio') {
                        msg = msg+mntz;
                        $ext = m.filext;
                        $xptxt = m.fetxtb;
                        if ($ext === 'audio/mpeg' || $ext === 'audio/ogg' || $ext === 'audio/wav' || $ext === 'audio/x-wav') {
                            msg = msg+'<span class="audioplay" mime="'+$ext+'" play="gem/ore/grupo/audiomsgs/'+m.msg+'">';
                            msg = msg+'<span class="play"><i></i></span>';
                            msg = msg+'<span class="seek">';
                            msg = msg+'<input id="seekslider" type="range" min="0" max="1" value="0" step=".001">';
                            msg = msg+'<i class="bar"><i></i></i><i class="duration"><i>00:00</i><i class="tot">00:00</i></i></span>';
                            msg = msg+'<span class="icon gi-mic"></span></span>';
                        }
                    } else if (m.type === 'file') {
                        msg = msg+mntz;
                        $ext = m.filext;
                        $xptxt = m.fetxtb;
                        if ($ext === 'image/jpeg' || $ext === 'image/png' || $ext === 'image/gif' || $ext === 'image/bmp') {
                            msg = msg+'<span class="preview image lrmbg" style="width:'+m.fwidth+'px;height:'+m.fheight+'px;"><span><img class="lazyimg" data-src="gem/ore/grupo/files/preview/'+m.msg+'"/></span></span>';
                        } else if ($ext === 'video/mp4' || $ext === 'video/ogg' || $ext === 'video/webm') {
                            msg = msg+'<span class="preview video lrmbg"><span mime="'+$ext+'" loadvideo="gem/ore/grupo/files/dumb/'+m.msg+'">';
                            msg = msg+'</span></span>';
                        } else if ($ext === 'audio/mpeg' || $ext === 'audio/ogg' || $ext === 'audio/wav' || $ext === 'audio/x-wav') {
                            msg = msg+'<span class="audioplay" mime="'+$ext+'" play="gem/ore/grupo/files/dumb/'+m.msg+'">';
                            msg = msg+'<span class="play"><i></i></span>';
                            msg = msg+'<span class="seek">';
                            msg = msg+'<input id="seekslider" type="range" min="0" max="1" value="0" step=".001">';
                            msg = msg+'<i class="bar"><i></i></i><i class="duration"><i>00:00</i><i class="tot">00:00</i></i></span>';
                            msg = msg+'<span class="icon gi-note-beamed"></span></span>';
                        } else {
                            var dwnb = 'gi-attach';
                            var dwnc = 'dwnldfile';
                            if ($ext === 'expired') {
                                dwnb = 'gi-block';
                                dwnc = 'noclick';
                            }
                            msg = msg+'<span class="block '+dwnc+'" type="files" act="download" no="'+m.msg+'">';
                            msg = msg+'<span><i class="'+dwnb+'"></i> '+m.sfile+'</span></span>';
                        }

                    }
                    msg = msg+'<i class="info" title="'+m.date+'" data-toggle="tooltip">'+m.time;
                    if (m.send == 'you') {
                        msg = msg+'<i class="tick recieved '+m.mseen+'"><i></i><i></i></i>';
                    }
                    msg = msg+'</i></i>';

                    if (moset != 'right' && m.send != 'system') {
                        msg = msg+moptz;
                    }
                    msg = msg+'</span></div> </li>';
                    if (n == 2) {
                        oldmsg = oldmsg+msg;
                    } else {
                        $('.swr-grupo .panel > .room > .msgs').append(msg);
                    }
                    if (d.length === undefined) {
                        return false;
                    }
                }
            }
        }
    });
    if (n == 2) {
        $(".swr-grupo .panel > .room > .msgs").prepend(oldmsg);
        $('.swr-grupo .panel > .room > .msgs').animate({
            scrollTop: $(".swr-grupo .panel > .room > .msgs > li[no="+fi+"]").offset().top-180
        }, 5);
    } else {
        if (!$(".swr-grupo .panel > .room > .msgs").hasClass('noscroll')) {
            $intr = 500;
            $tmr = 0;
            if (n == 1) {
                $intr = 200;
                $tmr = 0;
            }
            scrollmsgs($intr, $tmr);
            $(".swr-grupo .msgloader").fadeOut();
        }
    }
    if (!$('.swr-grupo .panel > .room > .msgs > li').last().hasClass('you') && !$('.swr-grupo .panel > .room > .msgs > li').last().hasClass('like')) {
        if (!$('.swr-grupo .panel > .textbox').hasClass('disabled')) {
            if (n != 1 && n != 2) {
                grnewalert(1);
                $("#gralert")[0].play();
            }
        }
    }
    $('[data-toggle="tooltip"]').tooltip();
    qrload();
    setTimeout(function() {
        lazyload();
    }, 2000);
}
function grnewalert(n) {
    if (n != undefined) {
        $(".dumb .newmsgalert").attr('alert', 'on');
        if (alertitle != undefined) {
            clearTimeout(alertitle);
        }
    }
    var oldTitle = $(".dumb .webtitle").text();
    var newTitle = $(".dumb .newmsgalert").text();
    alertitle = setTimeout(function() {
        if ($(".dumb .newmsgalert").attr('titles') == 1) {
            document.title = newTitle;
            $(".dumb .newmsgalert").attr('titles', 0);
        } else {
            $(".dumb .newmsgalert").attr('titles', 1);
            document.title = oldTitle;
        }
        if ($(".dumb .newmsgalert").attr('alert') == 'on') {
            grnewalert();
        }
    }, 700);
}
function qrload() {
    $(".swr-grupo .panel > .room > .msgs > li.qrcode").each(function() {
        if (!$(this).hasClass('qrdone')) {
            var txt = $(this).find('.codeqr > span');
            $(this).find('.codeqr').qrcode({
                width: 100, height: 100, text: txt.text()});
            txt.remove();
            $(this).addClass('qrdone');
        }
    });
}
function autotimez($elem, $txt) {
    if ($txt == undefined) {
        $txt = '0m 0s';
    }
    if ($elem == 'run') {
        $('.autotimering').each(function() {
            $(this).attr("timer", $(this).find("input").val());
            $(this).find("input").val("");
            autotimez($(this));
        });
    } else {
        if ($elem.attr("timer") != 0 && $elem.is(':visible')) {
            var countDownDate = new Date($elem.attr("timer")).getTime();
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            var outp = '';
            if (days != 0) {
                outp = outp+days+"d ";
            }
            if (hours != 0) {
                outp = outp+hours+"h ";
            }
            if (minutes != 0) {
                outp = outp+minutes+"m ";
            }
            if (seconds != 0) {
                outp = outp+seconds+"s";
            }
            if (distance < 0) {
                $elem.find("input").val($txt);
                $elem.attr("timer", 0);
            } else {
                $elem.find("input").val(outp);
            }
            setTimeout(function() {
                if (distance > 0) {
                    autotimez($elem, $txt);
                }
            }, 1000);
        }
    }
}

$(document).on('DOMNodeInserted', '.swr-grupo', function() {
    lazyload();
});
function lazyload() {
    $(".lazyimg").Lazy({
        effect: "fadeIn",
        effectTime: 1000,
        bind: "event",
        afterLoad: function(element) {
            element.parents('.lrmbg').addClass('imgld');
        },
        onFinishedAll: function(element) {}
    });
}
$('body').on('click', '.gr-prvlink > div > i.gi-cancel', function(e) {
    if (webthumbnail != null) {
        webthumbnail.abort();
    }
    $('.gr-prvlink').hide();
    $('.gr-prvlink > div > img').removeAttr("src");
});

$('body').on('click', '.gr-prvlink > div > i.submt', function(e) {
    if ($(this).hasClass("vidprev")) {
        var video = [];
        video['provider'] = $(this).attr('provider');
        video['id'] = $(this).attr('vid');
        var extra = 'allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen';
        if (video['provider'] === 'youtube') {
            link = 'https://www.youtube.com/embed/'+video['id']+'?autoplay=1';
        } else if (video['provider'] === 'dailymotion') {
            link = 'https://www.dailymotion.com/embed/video/'+video['id']+'?autoplay=1';
        } else if (video['provider'] === 'vimeo') {
            extra = 'webkitallowfullscreen mozallowfullscreen allowfullscreen';
            link = 'https://player.vimeo.com/video/'+video['id']+'?autoplay=1';
        }
        grpreview('embed', link, extra);
    } else {
        window.open($(this).attr("link"), '_blank');
    }
});
$('body').on('click', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > a.openlink', function(e) {
    e.preventDefault();
    $('.gr-prvlink > div > span > span.loading').removeClass('error');
    var ptop = $(this).offset().top+25;
    var pleft = $(this).offset().left;
    if (ptop+144 > $('.swr-grupo .panel').height()) {
        ptop = ptop-130;
    }
    if (pleft+256 > $('.swr-grupo .panel').width()) {
        pleft = pleft-200;
    }
    $('.gr-prvlink > div').css("top", ptop+"px");
    $('.gr-prvlink > div > span > span.loading').css("display", "block");
    $('.gr-prvlink > div').css("left", pleft+"px");
    var key = $(".dumb .gdefaults").find(".pagespeedapi").text();
    if (key != '') {
        key = '&key='+key;
    }
    var url = 'https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=' + $(this).attr("href") + '&screenshot=true'+key;
    var surl = '';
    $('.gr-prvlink > div > i.submt').attr("link", $(this).attr("href"));
    $('.gr-prvlink > div > i.submt').removeAttr('provider');
    $('.gr-prvlink > div > i.submt').removeAttr('vid');
    if ($(this).hasClass("embedvideo")) {
        $('.gr-prvlink > div > i.submt').addClass('vidprev');
        $('.gr-prvlink > div > i.submt').text($(".gphrases > .play").text());
        if (webthumbnail != null) {
            webthumbnail.abort();
        }
        var video = [];
        video['provider'] = $(this).find('i').attr('provider');
        video['id'] = $(this).find('i').attr('vid');
        $('.gr-prvlink > div > i.submt').attr('provider', video['provider']);
        $('.gr-prvlink > div > i.submt').attr('vid', video['id']);
        var link = '';
        if (video['provider'] === 'youtube') {
            link = 'https://img.youtube.com/vi/'+video['id']+'/mqdefault.jpg';
        } else if (video['provider'] === 'dailymotion') {
            link = 'https://www.dailymotion.com/thumbnail/video/'+video['id'];
        } else if (video['provider'] === 'vimeo') {
            $.getJSON('https://www.vimeo.com/api/v2/video/' + video['id'] + '.json?callback=?', {
                format: "json"
            }, function(data) {
                $('.gr-prvlink > div > img').attr('src', data[0].thumbnail_medium);
                $(".gr-prvlink > div > img").on('load', function() {
                    $('.gr-prvlink > div > span > span.loading').fadeOut();
                });
            }).fail(function() {
                $('.gr-prvlink > div > span > span.loading').addClass('error');
            });
        }
        if (video['provider'] != 'vimeo') {
            $('.gr-prvlink > div > img').attr('src', link);
            $(".gr-prvlink > div > img").on('load', function() {
                $('.gr-prvlink > div > span > span.loading').fadeOut();
            }).on('error', function() {
                $('.gr-prvlink > div > span > span.loading').addClass('error');
            });
        }
    } else {
        $('.gr-prvlink > div > i.submt').text($(".gphrases > .visit").text());
        $('.gr-prvlink > div > i.submt').removeClass('vidprev');
        webthumbnail = $.ajax({
            url: url,
            context: this,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                if (webthumbnail != null) {
                    webthumbnail.abort();
                }
            },
            success: function(data) {
                data = data.screenshot.data.replace(/_/g, '/').replace(/-/g, '+');
                $('.gr-prvlink > div > img').attr('src', 'data:image/jpeg;base64,' + data);
                $(".gr-prvlink > div > img").on('load', function() {
                    $('.gr-prvlink > div > span > span.loading').fadeOut();
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('.gr-prvlink > div > span > span.loading').addClass('error');
            }
        });
    }
    $('.gr-prvlink').show();
});

$('body').on('mouseleave', '.swr-grupo .panel > .room > .msgs > li > div > .xmsg > i > a', function(e) {
    $('.gr-prvlink').hide();
    $('.gr-prvlink > div > img').removeAttr("src");
});

$('body').on('click', '.swr-grupo .msgopt > ul > li.run', function(e) {
    $(this).attr('spin', 'off');
    $(this).attr('turn', 'on');
    var data = {
        act: 1,
        do: "group",
        type: $(this).attr('do'),
        mid: $(this).parents('li').attr('no'),
        id: $('.swr-grupo .panel').attr('no'),
        ldt: $('.swr-grupo .panel').attr('ldt'),
    };
    ajxx($(this), data, '', e, '', 'msgoptoz');
});


$('.swr-grupo .uploadfiles > input').change(function(e) {
    if ($(this).prop('files').length > 0) {
        var data = new FormData($(".swr-grupo .uploadfiles")[0]);
        var files = $(".swr-grupo .uploadfiles > input").get(0).files;
        for (var i = 0; i < files.length; i++) {
            data.append("ufiles["+i+"]", files[i]);
        }
        $('.gruploader').fadeIn();
        gruploader = $.ajax({
            url: '',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: 'post',
            beforeSend: function() {
                if (gruploader != undefined) {
                    gruploader.abort();
                }
            },
            success: function(data) {
                $('.gruploader').hide();
            }
        }).done(function(data) {
            eval(data);
        }) .fail(function(qXHR, textStatus, errorThrown) {
            $('.gruploader').hide();
            say($(".gphrases > .failed").text(), 'e');
        });
    }
});

$('.swr-grupo .attachfile').change(function(e) {
    if ($(this).prop('files').length > 0) {
        $('.swr-grupo .atchmsg').find('.gid').val($('.swr-grupo .panel').attr('no'));
        $(".swr-grupo .panel > .textbox .replyid").val(0);
        $('.swr-grupo .panel > .room > .msgs > li').removeClass('selected');
        var data = new FormData($(".swr-grupo .atchmsg")[0]);
        var files = $(".swr-grupo .atchmsg > input.attachfile").get(0).files[0];
        var senid = rand(8);
        var senmsg = files.name;
        var moset = $(".dumb .gdefaults").find(".sndmsgalgn").text();
        var msg = '<li class="you animated fadeIn '+senid+' '+moset+'" no="0"> <div><span class="msg"><i>';
        msg = msg+'<span class="block" type="files"><span><span class="ptxt">'+escapeHtml(senmsg)+'</span><span class="animated fadeInUp infinite">';
        msg = msg+'<i class="gi-upload"></i></span></span></span></i>';
        msg = msg+'</span></div></li>';
        $('.swr-grupo .panel > .room > .msgs').append(msg);
        $(".swr-grupo .panel > .room > .msgs").animate({
            scrollTop: $(".swr-grupo .panel > .room > .msgs").prop("scrollHeight")
        }, 500);
        data.append("attachfile", files);
        data.append("ldt", $('.swr-grupo .panel').attr('ldt'));
        data.append("from", grlastid());
        var f = '$(".swr-grupo .panel > .room > .msgs > li.'+senid+' > div > .msg > i > span.block > span > span > i").removeClass("gi-upload");';
        f = f+'$(".swr-grupo .panel > .room > .msgs > li.'+senid+' > div > .msg > i > span.block > span > span").removeClass("animated");';
        f = f+'$(".swr-grupo .panel > .room > .msgs > li.'+senid+' > div > .msg > i > span.block > span > span > i").addClass("gi-minus-circled-1");';
        f = f+'setTimeout(function() {$(".'+senid+'").remove();}, 2000);';
        $.ajax({
            url: '',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: 'post',
            success: function(data) {}
        }).done(function(data) {
            var data = $.parseJSON(data);
            $("."+senid).remove(); if ($(".swr-grupo .panel").attr("no") == data[0].gid) {
                loadmsg(data);
            }
        }) .fail(function(qXHR, textStatus, errorThrown) {
            eval(f);
            say($(".gphrases > .failed").text(), 'e');
        });
    }
});

function grmsgread(msid) {
    if (msid != undefined) {
        $('.swr-grupo .panel > .room > .msgs > li.you.msgschk').each(function() {
            if ($(this).attr('no') <= msid) {
                $(this).find('div > .msg > i > .info > i.tick.recieved').addClass('read');
                $(this).removeClass('msgschk');
            }
        });
    }
}

function grlastid() {
    var lastid = [];
    $('.swr-grupo .panel > .room > .msgs > li').each(function() {
        lastid.push($(this).attr('no'));
    });
    lastid.sort(function(a, b) {
        return b-a;
    });
    return lastid[0];
}

function grfirstid() {
    var firstid = [];
    $('.swr-grupo .panel > .room > .msgs > li').each(function() {
        firstid.push($(this).attr('no'));
    });
    firstid.sort(function(a, b) {
        return a-b;
    });
    return firstid[0];
}

$('.swr-grupo .panel > .textbox > .box > textarea').on('keypress', function(e) {
    if (e.which == 13) {
        if (!e.shiftKey) {
            e.preventDefault();
            $('.swr-grupo .sendbtn').trigger('click');
        }
    }
});

$('body').on('click keyup change', '.emojionearea-editor', function(e) {
    setTimeout(function() {
        $npd = parseInt($('.emojionearea > .emojionearea-editor').css("height"))+50;
        $(".swr-grupo .panel > .room").css("padding-bottom", $npd+"px");
        grscroll($(".swr-grupo .panel > .room > .msgs"), 'resize');
    }, 200);
});

$('body').on('click', '.swr-grupo .panel > .textbox > .mentions > ul > li', function() {
    var a = $(".swr-grupo .panel > .textbox > .mentions > input").val();
    var c = $(this).find('span > i').text();
    var el = $(".emojionearea-editor").get(0);
    var $txt = jQuery(".emojionearea-editor");
    var caretPos = $('.emojionearea-editor').attr('inx');
    var textAreaTxt = $txt.html();
    var chars = parseInt(caretPos)+parseInt(c.length);
    var str = textAreaTxt.substring(0, caretPos);
    var k = str.substring(0, str.length - a.length);
    var cpos = str.length - a.length;
    $txt.html(k + c + textAreaTxt.substring(caretPos));
    $(".swr-grupo .panel > .textbox > .mentions").hide();
    setcrtpost(el, cpos+c.length);
});

function createRange(node, chars, range) {
    if (!range) {
        range = document.createRange();
        range.selectNode(node);
        range.setStart(node, 0);
    }

    if (chars.count === 0) {
        range.setEnd(node, chars.count);
    } else if (node && chars.count > 0) {
        if (node.nodeType === Node.TEXT_NODE) {
            if (node.textContent.length < chars.count) {
                chars.count -= node.textContent.length;
            } else {
                range.setEnd(node, chars.count);
                chars.count = 0;
            }
        } else {
            for (var lp = 0; lp < node.childNodes.length; lp++) {
                range = createRange(node.childNodes[lp], chars, range);

                if (chars.count === 0) {
                    break;
                }
            }
        }
    }

    return range;
};


$('body').on('keypress', '.emojionearea-editor', function(e) {
    if (e.which == 13) {
        if (!e.shiftKey) {
            e.preventDefault();
            $('.swr-grupo .sendbtn').trigger('click');
        }
    }
});

$('.swr-grupo .subnav').on('click', function() {
    if ($(this).find(".swr-menu").is(':visible')) {
        $(this).find(".swr-menu").hide();
    } else {
        $('.swr-grupo .swr-menu').hide();
        $(this).addClass('active');
        $(this).find(".swr-menu").fadeIn();
    }
});

$('.grupo-pop > div > form > span.cancel').on('click', function(e) {
    $(".grupo-pop").fadeOut();
    if (ajxvar['subformpop'] != undefined) {
        ajxvar['subformpop'].abort();
    }
    gr_live();
});

$('body').on('click', '.grupo-pop > div > form > .fields > div > span.fileup > span', function() {
    $(this).parent().find('input').trigger('click');
});
$('body').on('change', '.grupo-pop > div > form > .fields > div > span.fileup > input[type=file]', function(e) {
    $(this).parent().find('span').text(e.target.files[0].name);
});

$('body').on('click', '.swr-grupo .panel > .room > .msgs > li.selected', function() {
    $('.swr-grupo .panel > .room > .msgs > li').removeClass('selected');
    $('.swr-grupo .panel > .textbox .replyid').val(0);
    $('.emojionearea > .emojionearea-editor').focus();
});

$('body').on('click', '.swr-grupo .msg span.opts > span > .gr-reply', function() {
    var id = $(this).parents('li').attr('no');
    $('.swr-grupo .panel > .room > .msgs > li').removeClass('selected');
    $(this).parents('li').addClass('selected');
    $('.swr-grupo .panel > .textbox .replyid').val(id);
    $('.emojionearea > .emojionearea-editor').focus();
});

$("body").on("contextmenu", "img", function(e) {
    return false;
});
$('body').on('click', '.grupo-pop > div > form > div > div > .imglist > li', function(e) {
    $('.grupo-pop > div > form > div > div > .imglist > li').removeClass('active');
    $(this).find('input').prop("checked", true);
    $(this).addClass('active');
});

$('body').on('change', '.grupo-pop .audselect > select', function(e) {
    $("#graudio > source").attr("src", $(this).val());
    $("#graudio > source").attr("type", "audio/mp3");
    $("#graudio")[0].pause();
    $("#graudio")[0].load();
    $("#graudio")[0].play();
});
$('body').on('click', '.grupo-pop > div > form > input[type="submit"]', function(e) {
    e.preventDefault();
    $(".grformspin").show();
    var data = new FormData($('.grform')[0]);
    ajxvar['subformpop'] = $.ajax({
        url: '',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: 'post',
        beforeSend: function() {
            if (ajxvar['grlive'] !== null && ajxvar['grlive'] !== undefined) {
                ajxvar['grlive'].abort();
            }
            if (ajxvar['subformpop'] != undefined) {
                ajxvar['subformpop'].abort();
            }
        },
        success: function(data) {}
    }).done(function(data) {
        eval(data);
        $(".grformspin").fadeOut();
        gr_live();
    }) .fail(function(qXHR, textStatus, errorThrown) {
        say($(".gphrases > .failed").text(), 'e');
        $(".grformspin").fadeOut();
        gr_live();
    });
});

$('body').on('click', '.formpop', function(e) {
    $(this).attr('type', 'json');
    $(".grformspin").fadeOut();
    $(this).attr('timeout', 0);
    $(this).attr('load', $(".gphrases > .loading").text());
    $(this).attr('lsub', $(".gphrases > .pleasewait").text());
    $(".grupo-pop > div > form > .search > input").val("");
    id = $(this).attr('no');
    if ($(this).attr('pn') == 1) {
        id = $('.swr-grupo .panel').attr('no');
    } else if ($(this).attr('pn') == 2) {
        id = $(this).parent().parent().attr('no');
    } else if ($(this).attr('pn') == 3) {
        id = $(this).parents('li').attr('no')
    }
    var data = {
        act: 1,
        do: "form",
        type: $(this).attr('do')+$(this).attr('act'),
        id: id,
        ldt: $('.swr-grupo .panel').attr('ldt'),
        xtid: $(this).attr('xtid'),
    };
    data = $.extend(data, $(this).data());
    $(".grupo-pop .head").text($(this).attr('title'));
    $(".grupo-pop .grsub").val($(this).attr('btn'));
    var s = '$(".grupo-pop").fadeIn();var fd="";';
    s = s+'if(Object.keys(data).length < 4 || data["fsearch"]=="off"){$(".grupo-pop > div > form > .search").hide();}';
    s = s+'else{$(".grupo-pop > div > form > .search").show();}';
    s = s+'$(".grupo-pop .grdo").val("'+$(this).attr('do')+'");';
    s = s+'$(".grupo-pop .grtype").val("'+$(this).attr('act')+'");';
    s = s+'$.each(data, function(k, v) {var ab=ac="";if(v[1]!=undefined && v[1].indexOf(":") != -1){ab=v[1].split(":")[1]; ac=v[1].split(":")[2]; v[1]=v[1].split(":")[0];}';
    s = s+'ab="'+"'"+'"+ab+"'+"'"+'";';
    s = s+'fd=fd+"<div class="+ab+ac+">";';
    s = s+'if(v[2]==="hidden"){fd=fd+"<input type="+v[2]+" value="+htmlDecode(v[3])+" name="+k+" autocomplete=dsb>"}';
    s = s+'else if(v[2]==="disabled" && v[1]==="textarea"){fd=fd+"<label>"+v[0]+"</label><textarea disabled name="+k+">"+htmlDecode(v[3])+"</textarea>"}';
    s = s+'else if(v[2]==="disabled"){fd=fd+"<label>"+v[0]+"</label><input type=text value="+htmlDecode(v[3])+" disabled name="+k+" autocomplete=dsb>"}';
    s = s+'else if(v[4]!==undefined && v[1]==="checkbox"){ fd=fd+"<label>"+v[0]+"</label><div class=checkbox>"; var ov=v[4].split(",");var ch=v[2].split(",");var cv=v[3].split(",");$.each(ch, function(ke, va) { fd=fd+"<span><input type="+v[1];if(jQuery.inArray(cv[ke], ov) != -1) {fd=fd+" checked ";}fd=fd+" name="+k+"[] value="+htmlDecode(cv[ke])+">"+va+"</span>"; }); fd=fd+"</div>";}';
    s = s+'else if(v[1]==="checkbox"){ fd=fd+"<label>"+v[0]+"</label><div class=checkbox>"; var ch=v[2].split(",");var cv=v[3].split(",");$.each(ch, function(ke, va) { fd=fd+"<span><input type="+v[1]+" name="+k+"[] value="+htmlDecode(cv[ke])+">"+va+"</span>"; }); fd=fd+"</div>";}';
    s = s+'else if(v[1]==="radio"){ fd=fd+"<label>"+v[0]+"</label><div class=checkbox>"; var ch=v[2].split(",");var cv=v[3].split(",");$.each(ch, function(ke, va) { fd=fd+"<span><input type="+v[1]+" name="+k+" value="+htmlDecode(cv[ke])+" >"+va+"</span>"; }); fd=fd+"</div>";}';
    s = s+'else if(v[2]==="file"){fd=fd+"<label>"+v[0]+"</label><span class=fileup><input type="+v[2]+" name="+k+" "+v[3]+" autocomplete=dsb><span>"+data["choosefiletxt"][0]+"</span></span>"}';
    s = s+'else if(v[4]!==undefined && v[1]==="input"){fd=fd+"<label>"+v[0]+"</label><input type="+v[2]+" placeholder="+v[4]+" name='+"'"+'"+k+"'+"'"+' autocomplete=dsb>"}';
    s = s+'else if(v[3]!==undefined && v[1]==="input" && v[2]==="colorpick"){fd=fd+"<label>"+v[0]+"</label><input type=text class=colorpick value="+v[3]+" name="+k+" autocomplete=dsb>"}';
    s = s+'else if(v[3]!==undefined && v[1]==="input"){fd=fd+"<label>"+v[0]+"</label><input type="+v[2]+" value="+htmlDecode(v[3])+" name="+k+" autocomplete=dsb>"}';
    s = s+'else if(v[3]!==undefined && v[1]==="textarea"){if(v[4]==undefined){v[4]="";}fd=fd+"<label>"+v[0]+"</label><textarea name="+k+" placeholder="+v[4]+">"+htmlDecode(v[3])+"</textarea>"}';
    s = s+'else if(v[3]!==undefined && v[1]==="span"){fd=fd+"<label>"+v[0]+"</label><span name="+k+" >"+v[3]+"</span>"}';
    s = s+'else if(v[1]==="textarea"){if(v[4]==undefined){v[4]="";}fd=fd+"<label>"+v[0]+"</label><textarea name="+k+" placeholder="+v[4]+"></textarea>"}';
    s = s+'else if(v[1]==="input"){fd=fd+"<label>"+v[0]+"</label><input type="+v[2]+" name="+k+" autocomplete=dsb>"}';
    s = s+'else if(v[1]==="select"){fd=fd+"<label>"+v[0]+"</label><select name="+k+" >";';
    s = s+'if(jQuery.type(v[2])=="object"){';
    s = s+'fd=fd+"<option value=0>------</option>";';
    s = s+'$.each(v[2] , function(index, val) {var sel="";if(index==v[3]){sel="selected";} fd=fd+"<option "+sel+" value="+index+">"+htmlDecode(val)+"</option>";});';
    s = s+'}else{';
    s = s+'for(i=2;i<v.length;i++){fd=fd+"<option value="+v[i]+">"+v[i+1]+"</option>";i=i+1;}}';
    s = s+'fd=fd+"</select>"}';
    s = s+'else if(v[1]==="tmz"){fd=fd+"<label>"+v[0]+"</label><select name="+k+" ><option value=0>------</option>";';
    s = s+'var tm=v[2].split(",");for(i=0;i<tm.length;i++){var sel="";if(tm[i]==v[3]){sel="selected";}fd=fd+"<option "+sel+" value="+tm[i]+">"+htmlDecode(tm[i])+"</option>";}';
    s = s+'fd=fd+"</select>"}';
    s = s+'else if(v[1]==="imglist"){fd=fd+"<label>"+v[0]+"</label><ul class=imglist>";';
    s = s+'if(jQuery.type(v[2])=="object"){';
    s = s+'$.each(v[2] , function(index, val) { fd=fd+"<li><input type=radio name="+k+" value="+index+"><img class=lazyimg data-src="+val+"/></li>";});}';
    s = s+'fd=fd+"</ul>";}';
    s = s+'fd=fd+"</div>";';
    s = s+'});';
    s = s+'$(".grupo-pop .fields").html(fd);textAreaAdjust($(".grupo-pop > div > form > div textarea"), 1300);';
    s = s+'$(".grupo-pop > div > form > .fields > div > span.fileup > input").hide();$(".colorpick").colorpicker();';
    s = s+'$(".grupo-pop > div > form > .search > input").focus();';
    s = s+'$(".grupo-pop > div > form > div").scrollTop(0);lazyload();autotimez("run");';
    var f = grlv = 'gr_live();';
    s = s+grlv;
    ajxx($(this), data, s, e, f, 'formpopup', 'grlive');

});

$(document).on('click', '.grupo-pop > div > form .selectinp > input', function() {
    this.setSelectionRange(0, this.value.length);
});
$(document).on('keypress', '.grupo-pop > div > form .selectinp > input', function(e) {
    e.preventDefault();
});
$("body").on("change", ".grupo-pop > div > form .shwopts input,.grupo-pop > div > form .shwopts select", function(e) {
    $pt = $(this).parents('.shwopts');
    if ($pt.attr("mtch") == $(this).val()) {
        $('.grupo-pop > div > form .hidopts.'+$pt.attr("shw")).show();
    } else {
        $('.grupo-pop > div > form .hidopts.'+$pt.attr("shw")).hide();
    }
    grscroll($(".grupo-pop > div > form > div"), "resize");
});

$(document).ready(function() {
    if ($('.lside .gi-list-add .swr-menu > ul > li').length === 0) {
        $('.lside .gi-list-add').hide();
    }
    $('[data-toggle="tooltip"]').tooltip();
    window.emojioneVersion = "4.5.0";
    $(".swr-grupo .panel > .textbox > .box > textarea").emojioneArea({
        pickerPosition: "top",
        tonesStyle: "radio",
        search: false,
        autocomplete: true,
        hidePickerOnBlur: true,
        saveEmojisAs: "shortname",
        events: {
            keyup: function (editor, event) {
                var txtenable = $.trim($(".dumb .gdefaults > .enabletextarea").text());
                if (txtenable != 1) {
                    this.setText('');
                    say($(".gphrases > .notxtmsg").text());
                } else {
                    grtyprec();
                    var lmt = $(".dumb .gdefaults").find(".maxmsglen").text();
                    var text = this.getText();
                    if (lmt !== "") {
                        if (text.length > lmt) {
                            this.setText(text.substring(0, lmt));
                            placeCaretAtEnd($(".emojionearea > .emojionearea-editor").data("emojioneArea").editor[0]);
                            say($(".gphrases > .exceededmsg").text());
                        }
                    }
                }
            }
        },

    });
    var d = new Date();
    var offset = -d.getTimezoneOffset() * 60;
    $.post("", {
        act: 1,
        do: "profile",
        type: "autotimezone",
        offset: offset,
    });
});

function grtyprec(rst) {
    var el = $('.emojionearea-editor');
    if (rst != undefined) {
        el.attr('typing', 0);
    } else if (el.attr('typing') != 1) {
        $.post("", {
            act: 1,
            do: "group",
            type: "typing",
            id: $('.swr-grupo .panel').attr('no'),
            ldt: $('.swr-grupo .panel').attr('ldt'),
        });
        el.attr('typing', 1);
        setTimeout(function() {
            grtyprec(1);
        }, 8000);
    }
}

$('.gr-mic').on('click', function () {
    $(this).hide();
    var elem = $(this);
    if ($(this).hasClass('recrdng')) {
        $(this).removeClass('recrdng').fadeIn();
    } else {
        $(this).addClass('recrdng').fadeIn();
    }
});


$("body").on("keyup", ".swr-grupo .aside > .search > input", function(e) {
    var search = $(this).val().toLowerCase();
    var aside = 'lside';
    if ($(this).parents('.aside').hasClass('rside')) {
        aside = 'rside';
    }
    search = search.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
    if (e.which == 13) {
        if (search.length > 2) {
            $(".dumb .srchbx").attr("srch", search);
            $(".dumb .srchbx").attr("side", aside);
            $(".dumb .srchbx").trigger('click');
        } else {
            say($(".gphrases > .searchmin").text());
        }
    }
});

$("body").on("click", ".swr-grupo .panel .searchmsgs", function(e) {
    if ($(".swr-grupo .panel > .searchbar").hasClass("slideInDown")) {
        $(".swr-grupo .panel > .searchbar").removeClass("animated slideInDown");
        $(".swr-grupo .panel > .searchbar").addClass("animated slideOutUp faster").show();
    } else {
        $(".swr-grupo .panel > .searchbar").removeClass("animated slideOutUp");
        $(".swr-grupo .panel > .searchbar").addClass("animated slideInDown faster").show();
        $(".swr-grupo .panel > .searchbar input").focus();
    }
});
$("body").on("click", ".swr-grupo .panel > .room", function(e) {
    if ($(".swr-grupo .panel > .searchbar").hasClass("slideInDown")) {
        $(".swr-grupo .panel .searchmsgs").trigger('click');
    }
});
$("body").on("keyup", ".swr-grupo .panel > .searchbar input", function(e) {
    if (e.which == 13) {
        $(".swr-grupo .panel .searchmsgs").trigger('click');
        var search = $(this).val();
        if (search != "") {
            turn_chat();
            $(this).attr('type', 'json');
            $(this).attr('turn', 'on');
            $(this).attr('spin', 'off');
            $(".swr-grupo .msgloader").removeClass("error").fadeIn();
            var data = {
                act: 1,
                do: "group",
                type: 'msgs',
                id: $('.swr-grupo .panel').attr('no'),
                search: $(this).val(),
                ldt: $('.swr-grupo .panel').attr('ldt'),
            };
            var s = '$(".swr-grupo .msgloader").fadeOut();if($(".swr-grupo .panel").attr("no")==data[0].gid){loadmsg(data,1);}';
            var f = '$(".swr-grupo .msgloader").addClass("error");';
            ajxx($(this), data, s, e, f, 'searchmsgs', 'grlive');
        }
    }
});
$("body").on("click", ".grupo-video > div > div > span", function(e) {
    $(".grupo-video").hide();
    $(".grupo-video > div > div > iframe").remove();
});
$("body").on("click", ".swr-grupo .panel > .room > .msgs > li a.olembedvideo", function(e) {
    e.preventDefault();
    var video = urlParser.parse($(this).attr('href')),
    link = '',
    extra = 'allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen';
    if (video['provider'] === 'youtube') {
        link = 'https://www.youtube.com/embed/'+video['id']+'?autoplay=1';
    } else if (video['provider'] === 'dailymotion') {
        link = 'https://www.dailymotion.com/embed/video/'+video['id']+'?autoplay=1';
    } else if (video['provider'] === 'vimeo') {
        extra = 'webkitallowfullscreen mozallowfullscreen allowfullscreen';
        link = 'https://player.vimeo.com/video/'+video['id']+'?autoplay=1';
    } else if (video['provider'] === 'twitch') {
        link = 'https://player.twitch.tv/?'+video['id']+'?autoplay=1';
    } else if (video['provider'] === 'youku') {
        link = 'http://player.youku.com/embed/'+video['id']+'?autoplay=1';
    }
    $(".grupo-video > div > div").append('<iframe src="'+link+'" '+extra+' frameborder="0" ></iframe>');
    $(".grupo-video").fadeIn();
});
$("body").on("click", ".turnchat", function(e) {
    var turn = $(this).attr('do');
    $(this).attr("ldt", $('.swr-grupo .panel').attr('ldt'));
    turn_chat(turn, $(this));
});
function turn_chat($d, el) {
    if ($d == undefined) {
        $d = 'off';
    }
    if ($d === 'on') {
        $('.groupreload').fadeOut();
        $('.swr-grupo .panel > .textbox').removeClass('animated slideOutDown disabled');
        $oldgid = $('.swr-grupo .panel').attr('no');
        loadgroup($oldgid, el, 1);
        $('.swr-grupo .panel > .textbox').addClass('animated slideInUp');
    } else {
        $('.groupreload').fadeIn();
        $('.swr-grupo .panel > .textbox').removeClass('animated slideInUp');
        $('.swr-grupo .panel > .textbox').addClass('animated slideOutDown disabled');
    }
}

$('.swr-grupo .aside > .content > .list').on('scroll', function(e) {
    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight-15) {
        if ($(this).parent().find('.grproceed').hasClass('loadside')) {
            $(this).parent().find('.grproceed').trigger('click');
        }
    }
});

$('.swr-grupo .panel > .room > .msgs').on('scroll', function(e) {
    if ($(".swr-grupo .panel > .room > .msgs > li").eq(0).hasClass('createdgroup')) {
        $('.swr-grupo .panel').attr('noscroll', 1);
    }
    if (!$(".swr-grupo .panel > .textbox").hasClass('disabled') && $('.swr-grupo .panel').attr('noscroll') != 1) {
        var scrollTop = $(this).scrollTop();
        if (scrollTop <= 0) {
            $(".swr-grupo .panel").attr('scrolldown', 'off');
            $(this).attr('type', 'json');
            $(this).attr('turn', 'on');
            $(this).attr('spin', 'off');
            var firstid = grfirstid();
            $(".swr-grupo .msgloader").removeClass("error").fadeIn();
            var data = {
                act: 1,
                do: "group",
                type: 'msgs',
                id: $('.swr-grupo .panel').attr('no'),
                to: firstid,
                ldt: $('.swr-grupo .panel').attr('ldt'),
            };
            var s = 'if($(".swr-grupo .panel").attr("no")==data[0].gid){loadmsg(data,2,'+firstid+');}$(".swr-grupo .msgloader").fadeOut();';
            var f = '$(".swr-grupo .msgloader").addClass("error");';
            f = f+'setTimeout(function() { $(".swr-grupo .msgloader").fadeOut(); }, 2000);';
            var grlv = 'gr_live();';
            s = s+grlv;
            f = f+grlv;
            ajxx($(this), data, s, e, f, 'scrollmsgs', 'grlive');
        }
    }
    if ($(this).scrollTop() + $(this).innerHeight()+50 >= $(this)[0].scrollHeight) {
        $(".swr-grupo .panel").attr('scrolldown', 'on');
    } else {
        $(".swr-grupo .panel").attr('scrolldown', 'off');
    }
});
function htmlDecode(input) {
    var e = document.createElement('div');
    e.innerHTML = input;
    if (e.childNodes[0] == undefined) {
        return input;
    } else {
        return e.childNodes[0].nodeValue;
    }
}

$(window).load(function() {
    var firstload = $('.dumb .firstload').find('span');
    $('.gr-preloader').fadeOut();
    $('.swr-grupo').fadeIn();
    $('.swr-grupo .lside > .tabs > ul > li').eq(0).trigger('click');
    if ($(window).width() > 767.98) {
        $('.swr-grupo .rside > .tabs > ul > li').eq(0).trigger('click');
    }
    if (firstload.text() != '') {
        setTimeout(function() {
            firstload.trigger('click');
        }, 500);
    }
    grscroll($(".swr-grupo .lside > .content > .list"));
    grscroll($(".swr-grupo .rside > .content > .list"));
    grscroll($(".swr-grupo .panel > .room > .msgs"));
    grscroll($(".grgif > div > div"));
    grscroll($(".swr-grupo .aside > .content .profile > .bottom > div > ul"));
    grscroll($(".grupo-pop > div > form > div"));
    var d = new Date();
    var offset = -d.getTimezoneOffset() * 60;
    $.post("", {
        act: 1,
        do: "profile",
        type: "autotimezone",
        offset: offset,
    });
});

function asciiemoji(str) {
    $emoji = 0;
    if ($emoji == 1) {
        var emojis = {
            "<3": ":heart:", "</3": ":broken_heart:", ":')": ":joy:", ":'-)": ":joy:", ":D": ":smiley:", ":-D": ":smiley:", "=D": ":smiley:",
            ":)": ":slight_smile:", ":-)": ":slight_smile:", "=]": ":slight_smile:", "=)": ":slight_smile:",
            ":]": ":slight_smile:", "':)": ":sweat_smile:", "':-)": ":sweat_smile:", "'=)": ":sweat_smile:", "':D": ":sweat_smile:",
            "':-D": ":sweat_smile:", ">:)": ":laughing:", ">;)": ":laughing:", ">:-)": ":laughing:", ">=)": ":laughing:",
            ";)": ":wink:", ";-)": ":wink:", "*-)": ":wink:", "*)": ":wink:", ";-]": ":wink:", ";]": ":wink:", ";D": ":wink:", ";^)": ":wink:",
            "':(": ":sweat:", "':-(": ":sweat:", "'=(": ":sweat:", ":*": ":kissing_heart:", ":-*": ":kissing_heart:", "=*": ":kissing_heart:",
            ":^*": ":kissing_heart:", ">:P": ":stuck_out_tongue_winking_eye:", "X-P": ":stuck_out_tongue_winking_eye:",
            "x-p": ":stuck_out_tongue_winking_eye:", ">:[": ":disappointed:", ":-(": ":disappointed:", ":(": ":disappointed:",
            ":-[": ":disappointed:", ":[": ":disappointed:", "=(": ":disappointed:", ">:(": ":angry:",
            ">:-(": ":angry:", ":@": ":angry:", ":'(": ":cry:", ":'-(": ":cry:", ";(": ":cry:", ";-(": ":cry:", ">.<": ":persevere:",
            "D:": ":fearful:", ":$": ":flushed:", "=$": ":flushed:", "#-)": ":dizzy_face:", "#)": ":dizzy_face:", "%-)": ":dizzy_face:",
            "%)": ":dizzy_face:", "X)": ":dizzy_face:", "X-)": ":dizzy_face:", "*\0/*": ":ok_woman:", "\0/": ":ok_woman:",
            "\O/": ":ok_woman:", "O:-)": ":innocent:", "0:-3": ":innocent:", "0:3": ":innocent:", "0:-)": ":innocent:",
            "0:)": ":innocent:", "0;^)": ":innocent:", "O:-)": ":innocent:", "O:)": ":innocent:", "O;-)": ":innocent:", "O=)": ":innocent:",
            "0;-)": ":innocent:", "O:-3": ":innocent:", "O:3": ":innocent:", "B-)": ":sunglasses:", "B)": ":sunglasses:", "8)": ":sunglasses:",
            "8-)": ":sunglasses:", "B-D": ":sunglasses:", "8-D": ":sunglasses:", "-_-": ":expressionless:", "-__-": ":expressionless:",
            "-___-": ":expressionless:", ">:/": ":confused:", ":-/": ":confused:", ":-.": ":confused:",
            "=/": ":confused:", ":L": ":confused:",
            ":P": ":stuck_out_tongue:", ":-P": ":stuck_out_tongue:", ":-p": ":stuck_out_tongue:",
            ":-ÃƒÆ’Ã…Â¾": ":stuck_out_tongue:", ":-O": ":open_mouth:", ":O": ":open_mouth:", ":-o": ":open_mouth:",
            "O_O": ":open_mouth:", ">:O": ":open_mouth:", ":-X": ":no_mouth:", ":X": ":no_mouth:", ":-#": ":no_mouth:",
            ":#": ":no_mouth:", ":x": ":no_mouth:", ":-x": ":no_mouth:",
        };
        for (var key in emojis) {
            if (emojis.hasOwnProperty(key)) {
                var rp = key.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                var re = new RegExp(rp, 'g');
                str = str.replace(re, emojis[key]);
            }
        }
    }
    return str;
}
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};
function url2link(text) {

    return (text || "").replace(
        /([^\S]|^)(((https?\:\/\/)|(www\.)|[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}))(\S+))/gi,
        function(match, space, url) {
            var email = hyperlink = url;
            var output;
            if (!hyperlink.match('^https?:\/\/')) {
                hyperlink = 'http://' + hyperlink;
            }
            var orh = hyperlink.split("<br");
            hyperlink = orh[0];
            var video = urlParser.parse(hyperlink);
            var em = 'openlink';
            if (video && video['provider'] === 'youtube' || video && video['provider'] === 'dailymotion' || video && video['provider'] === 'vimeo') {
                var a = document.createElement('a');
                a.href = hyperlink;
                em = 'openlink embedvideo';
                url = '<i class="gi-link" vid="'+video['id']+'" provider="'+video['provider']+'"></i>'+a.hostname;
            } else if (isValidEmailAddress(email)) {
                em = 'email';
                url = '<i class="gi-mail"></i>'+email;
                hyperlink = "mailto:"+email;
            } else {
                var a = document.createElement('a');
                a.href = hyperlink;
                url = '<i class="gi-link"></i>'+a.hostname;
            }

            output = '<a class="'+em+'" href="' + hyperlink + '" target="_blank">' + url + '</a>';
            if (orh[1] != undefined) {
                output = output+'<br';
            }
            return space + output;
        }
    );

};

function placeCaretAtEnd(el) {
    if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}
$('body').on('click', '.swr-grupo .aside > .content .profile > .middle > span.editprf', function(e) {
    $('.swr-grupo .aside > .content .profile > .top > span.edit > i').trigger('click');
});
$('body').one('click', '.emojionearea-editor', function(e) {
    grscroll($(".emojionearea-editor"));
});

$('body').on('click', '.swr-grupo .panel > .textbox > .box > .icon > .gr-emoji', function(e) {
    $('.emojionearea-button').trigger('click');
    $('.emojionearea > .emojionearea-editor').focus();
    var el = $(".emojionearea > .emojionearea-editor")[0];
    var pos = $(".emojionearea > .emojionearea-editor").attr("inx");
    SetCaretPosition(el, pos);
});

$('body').on('click', '.swr-grupo .vwp', function(e) {

    var kr = 3;
    var ths = $(this);
    var et = e;
    if ($(window).width() <= 767.98) {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $(".swr-grupo .lside .opt > ul").hide();
        $('.swr-grupo .lside,.swr-grupo .panel').removeClass('abmob');
        $(".swr-grupo .lside,.swr-grupo .panel").addClass("bwmob");
        $(".grtab").addClass("d-none");
        $('.swr-grupo .rside > .top > .left > .icon').attr('data-block', 'alerts');
        if (!$('.rside').hasClass('abmob')) {
            $(".swr-grupo .rside").css("margin-left", "800px");
            setTimeout(function() {
                $(".swr-grupo .rside").removeClass("nomob");
                $(".swr-grupo .rside").addClass("abmob");
                $(".swr-grupo .rside").animate({
                    marginLeft: "0px"
                }, 500);
            }, 200);
        }
    }
    setTimeout(function() {
        $('.swr-grupo .rside > .content > .list').hide();
        $('.swr-grupo .rside > .tabs > ul > li').removeClass('active');
        $(".swr-grupo .rside > .content .profile").fadeOut();
        ths.attr('type', 'json');
        ths.attr('spin', 'off');
        $('.swr-grupo .rside .listloader').removeClass("error").fadeIn();
        var data = {
            act: 1,
            do: "list",
            type: 'getuserinfo',
            id: ths.attr('no'),
            ldt: ths.attr('ldt'),
        };
        var s = '$(".swr-grupo .aside > .content .profile > .top > span.name").text(data[0].name);';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.dp > img").remove();';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.dp").prepend("<img class=lazyimg>");';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.dp > img").attr("data-src",data[0].img);';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.coverpic > img").remove();';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.coverpic").prepend("<img class=lazyimg>");';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.coverpic > img").attr("data-src",data[0].cp);';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.edit > span > i,.swr-grupo .aside > .content .profile > .top > span.coverpic").show();';
        s = s+'if(data[0].cp=="gem/ore/grupo/coverpic/users/default.png" || data[0].cp=="gem/ore/grupo/coverpic/groups/default.png"){';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.edit > span > i,.swr-grupo .aside > .content .profile > .top > span.coverpic").hide();}';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.role").text(data[0].uname);';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.refresh").attr("no",data[0].id);';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").attr("no",data[0].id);';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.edit > i").attr("xtid",data[0].id);';
        s = s+'$(".swr-grupo .aside > .content .profile > .top > span.edit > i").attr("data-no",data[0].id);';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.stats > span").eq(1).find("span").text(data[0].shares);';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.stats > span").eq(0).find("span").text(data[0].loves);';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").text(data[0].btn);';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.stats > span").eq(2).find("span").text(data[0].lastlg);';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.stats > span").eq(2).find("span").attr("data-toggle","tooltip");';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.stats > span").eq(2).find("span").attr("title",data[0].lastlgtm);';
        s = s+'if(data[0].edit==1){$(".swr-grupo .aside > .content .profile > .top > span.edit > i").show();';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").addClass("loadgroup");';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").removeClass("loadgroup");';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").removeClass("say");';
        s = s+'}if(data[0].msgoff==1){$(".swr-grupo .aside > .content .profile > .middle > span.pm").removeClass("loadgroup");';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").addClass("say");';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").attr("say",data[0].msgoffmsg);';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").attr("type","e");';
        s = s+'}';
        s = s+'else if(data[0].edit==2){$(".swr-grupo .aside > .content .profile > .top > span.edit > i").hide();';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").removeClass("loadgroup");';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").addClass("editprf");';
        s = s+'}';
        s = s+'else{if(data[0].edit!=1){$(".swr-grupo .aside > .content .profile > .top > span.edit > i").hide();}';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").addClass("loadgroup");';
        s = s+'$(".swr-grupo .aside > .content .profile > .middle > span.pm").removeClass("editprf");';
        s = s+'}';
        s = s+'$(".swr-grupo .aside > .content .profile > .bottom > div > ul").html("");';
        s = s+'var pbtm=$(".swr-grupo .aside > .content .profile > .bottom > div > ul");';
        s = s+'var pnent=$(".swr-grupo .aside > .content .profile > .bottom > div > div");';
        s = s+'if(data.length===1){pbtm.hide();pnent.show();}else{pnent.hide();pbtm.show();$.each(data, function(k, v) {if(k!=0){';
        s = s+'pbtm.append("<li><b>"+data[k].name+"</b><span>"+htmlDecode(data[k].cont)+"</span></li>");';
        s = s+'}});}$(".swr-grupo .rside > .content .profile").fadeIn();';
        s = s+'$(".swr-grupo .rside .listloader").fadeOut();$("[data-toggle=tooltip]").tooltip();';
        var f = '$(".swr-grupo .rside .listloader").addClass("error");';
        var grlv = 'gr_live();';
        s = s+grlv;
        f = f+grlv;
        ajxx(ths, data, s, et, f, 'loadprofile', 'grlive');
    }, 300);
});


$('body').on('keyup', '.grupo-pop > div > form > div > div > textarea', function(e) {
    textAreaAdjust($(this), 300, 100);
    grscroll($(".grupo-pop > div > form > div"), "resize");
});
function textAreaAdjust(o, m, k) {
    if (k == undefined) {
        o.css("height", "auto");
    }
    var hgh = o.prop('scrollHeight');
    o.css("height", (hgh)+"px");
}
$('body').on('click', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.block.dwnldfile', function(e) {
    $(this).parents('li').find('.gr-download').trigger("click");
});
$('body').on('click', '.swr-grupo .panel > .room > .msgs > li > div > .msg .gr-like', function(e) {
    var id = $(this).parents('li').attr('no');
    $(this).attr('type', 'json');
    $(this).attr('spin', 'off');
    var data = {
        act: 1,
        do: "love",
        type: 'lovedit',
        id: id,
    };
    var s = 'if(data[0].do=="remove"){$(".swr-grupo .panel > .room > .msgs > li[no="+data[0].id+"]").remove();}';
    s = s+'else if(data[0].do=="like"){$(".swr-grupo .panel > .room > .msgs > li[no="+data[0].id+"]").find(".gr-like").addClass("liked");}';
    s = s+'else{$(".swr-grupo .panel > .room > .msgs > li[no="+data[0].id+"]").find(".gr-like").removeClass("liked");}';
    s = s+'if(data[0].count==0){data[0].count="";}else{data[0].count="<i>"+data[0].count+"</i>";}';
    s = s+'$(".swr-grupo .panel > .room > .msgs > li[no="+data[0].id+"]").find(".lcount").html(data[0].count);';
    var f = grlv = 'gr_live();';
    s = s+grlv;
    ajxx($(this), data, s, e, f, 'likemsgs', 'grlive');
});

$(".grdrag").draggable({
    containment: 'window'
});

$('body').on('click', ".swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.preview.image > span > img", function(e) {
    if ($(this).hasClass('tenor')) {
        var url = $(this).attr("gif");
    } else {
        var url = $(this).attr("src");
        url = url.replace('/files/preview/', '/files/dumb/');
    }
    grpreview('img', url);
});

$('body').on('click', ".swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.preview.video", function(e) {
    var url = $(this).find("span").attr("loadvideo");
    var mime = $(this).find("span").attr("mime");
    grpreview('video', url, mime, $(this));
});

function grpreview(ty, url, mime, vd) {
    if (mime == undefined) {
        mime = 0;
    }
    if (vd == undefined) {
        vd = 0;
    }
    $(".grupo-preview > div > div").hide();
    $('.gr-prvlink').hide();
    $('.gr-prvlink > div > img').removeAttr("src");
    var loader = $(".grupo-preview > div > .loader");
    var elm = $(".grupo-preview > div > .img");
    $(".grupo-preview > div > .img > div > img").remove();
    $(".grupo-preview > div > .video > div > video > source").remove();
    $(".grupo-preview > div > .embed > div > iframe").remove();
    if (ty == 'img') {
        $(".grupo-preview > div > .img > div").append("<img>");
        $(".grupo-preview > div > .img > div > img").attr("ldsrc", url);
        $(".grupo-preview > div > .img").show();
        elm.find('div > img').css("max-width", $(window).width() - 150 + "px");
        elm.find('div > img').css("max-height", $(window).height() - 150 + "px");
        $(".grupo-preview > div > .img > div > img").Lazy({
            effect: "fadeIn",
            effectTime: 1000,
            bind: "event",
            attribute: "ldsrc",
            beforeLoad: function(element) {
                elm.css("opacity", 0);
                grcenter(loader);
                loader.fadeIn();
            },
            afterLoad: function(element) {
                loader.hide();
                setTimeout(function() {
                    grcenter(elm);
                    elm.css("opacity", 1);
                }, 200);
            }
        });
    } else if (ty == 'video') {
        var vdo = $(".grupo-preview > div > .video");
        vdo.find('div > video').append("<source>");
        grcenter(loader);
        loader.fadeIn();
        vdo.find('div > video > source').attr("src", url);
        vdo.find('div > video > source').attr("type", mime);
        vdo.find('div > video')[0].pause();
        vdo.find('div > video')[0].load();
        vdo.find('div > video').on('loadedmetadata', function() {
            vdo.find('div > video').css("max-width", $(window).width() - 150 + "px");
            vdo.find('div > video').css("max-height", $(window).height() - 150 + "px");
            grcenter(vdo);
            loader.hide();
            vdo.show();
            vdo.find('div > video')[0].play();
        });

    } else if (ty == 'embed') {
        var vdo = $(".grupo-preview > div > .embed");
        vdo.find('div').append('<iframe src="'+url+'" '+mime+' frameborder="0" allowfullscreen></iframe>');
        grcenter(loader);
        loader.fadeIn();
        vdo.find('div > iframe').on('load', function() {
            if ($(window).width() <= 767.98) {
                vdo.find('div > iframe').css("width", "290px");
                vdo.find('div > iframe').css("height", "166px");
            } else {
                vdo.find('div > iframe').css("width", "520px");
                vdo.find('div > iframe').css("height", "300px");
            }
            grcenter(vdo);
            loader.hide();
            vdo.show();
        });

    }
}
function videothumb(vidtot) {
    var tms = 0;
    for (i = 0; i < vidtot.length; i++) {
        var el = vidtot[i];
        var elem = $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.preview.video.'+el+' > span');
        var link = elem.attr('loadvideo');
        var mime = elem.attr('mime');
        tms = tms+4000;
        var video = document.getElementById('videothumbgen');
        var nid = rand(10);
        var thecanvas = document.getElementById('videothumbgencanvas');
        $("#videothumbgen").html("<source></source>");
        $("#videothumbgen > source").attr("src", link);
        $("#videothumbgen > source").attr("type", mime);
        $("#videothumbgen").on("loadstart", function() {
            var context = thecanvas.getContext('2d');
            context.drawImage(video, 0, 0, thecanvas.width, thecanvas.height);
            var dataURL = thecanvas.toDataURL("image/png");
            $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.preview.video.'+el+' > span > img').attr('src', dataURL);

        });
    }
}
function grcenter(el) {
    el.css("top", Math.max(0, (($(window).height() - el.outerHeight()) / 2) + $(window).scrollTop()) + "px");
    el.css("left", Math.max(0, (($(window).width() - el.outerWidth()) / 2) + $(window).scrollLeft()) + "px");
}
$('body').on('click tap touchstart', '.grupo-preview > div .prclose,.goback,.goright', function(e) {
    $(".grupo-preview > div > div").hide();
    $(".grupo-preview > div > .img > div > img").remove();
    if(!$(".grupo-preview > div > .video > div > video")[0].paused){
        $(".grupo-preview > div > .video > div > video")[0].pause();
    }
    $(".grupo-preview > div > .video > div > video").html("");
    $(".grupo-preview > div > .embed > div > iframe").remove();
    $('.gr-prvlink').hide();
    if (webthumbnail != null) {
        webthumbnail.abort();
    }
    $('.gr-prvlink > div > img').removeAttr("src");
});

$('body').on('click', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.play', function(e) {
    var pr = $(this).parent();
    if ($(this).hasClass('pause')) {
        $(this).removeClass('pause');
        $(this).addClass('continue');
        $("#graudio")[0].pause();
    } else if ($(this).hasClass('continue')) {
        $(this).removeClass('continue');
        $(this).addClass('pause');
        $("#graudio")[0].play();
    } else {
        $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.play').removeClass('pause');
        $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.seek > i.duration').css('opacity', 0);
        $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.play').removeClass('continue');
        $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay').removeClass('current');
        $(this).parent().addClass('current');
        $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.seek > i.bar').css('padding-left', '0px');
        var source = $(this).parent().attr("play");
        var mime = $(this).parent().attr("mime");
        $(this).addClass('pause');
        $("#graudio > source").attr("src", source);
        $("#graudio > source").attr("type", mime);
        $("#graudio")[0].pause();
        $("#graudio")[0].load();
        $("#graudio")[0].play();
        $(this).parent().find('.duration').css('opacity', 1);
    }
});

var graudprv = $("#graudio").bind("timeupdate", function() {
    var elemt = $(".swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay.current");
    var widthOfProgressBar = Math.floor((100 / this.duration) * this.currentTime);
    elemt.find('.duration > i.tot').text(seconvert(this.duration));
    elemt.find('.duration > i:first-child').text(seconvert(this.currentTime));
    $(".swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay.current #seekslider").val(graudprv.currentTime/graudprv.duration);
    $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay.current').find('span.seek > i.bar').stop(true, true).css('padding-left', widthOfProgressBar+'%');
})[0];
$("#graudio").bind("ended", function() {
    $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.seek > i.duration').css('opacity', 0);
    $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.play').removeClass('pause');
    $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.play').removeClass('continue');
    $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay').removeClass('current');
    setTimeout(function() {
        $('.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.seek > i.bar').css('padding-left', '0%');
    }, 300);
});
$("body").on("input", ".swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay #seekslider", function(e) {
    if ($(this).parent().parent().hasClass('current')) {
        graudprv.currentTime = this.value * graudprv.duration;
    } else {
        $olv = this.value;
        $(this).parent().parent().find('span.play').trigger('click');
        setTimeout(function() {
            graudprv.currentTime = $olv * graudprv.duration;
        }, 200);
    }
});
$("body").on("keyup", ".grupo-pop > div > form > .search > input", function() {

    var search = $(this).val();
    var elem = ".grupo-pop > div > form > div > div > label";
    var elemb = ".grupo-pop > div > form > div > div > input";
    $(elem).parent().show();
    if (search != "") {
        search = search.toLowerCase();
        $(elem).parent().hide();
        $(elem).each(function() {
            var str = $(this).text();
            if (str.toLowerCase().indexOf(search) >= 0) {
                $(this).parent().show();
            }
        });
        $(elemb).each(function() {
            var str = $(this).val();
            if (str.toLowerCase().indexOf(search) >= 0) {
                $(this).parent().show();
            }
        });
        $(".grupo-pop > div > form > div").animate({
            scrollTop: 0
        }, 500);
    }
});

$('body').on('click', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > i.readmore', function(e) {
    $(this).hide();
    $(this).parent().find('.shortmsg').hide();
    $(this).parent().find('.moretext').fadeIn();
    grscroll($(".swr-grupo .panel > .room > .msgs"), 'resize');
});

function seconvert(s) {
    var h = Math.floor(s/3600);
    s -= h*3600;
    var m = Math.floor(s/60);
    s -= m*60;
    s = Math.floor(s);
    if (h != 0) {
        return h+":"+(m < 10 ? '0'+m: m)+":"+(s < 10 ? '0'+s: s);
    } else {
        return (m < 10 ? '0'+m: m)+":"+(s < 10 ? '0'+s: s);
    }
}
function gradur(el) {
    setTimeout(function() {
        $(el).parent().find('.duration > i:last-child').text();
        $(el).parent().find('.duration > i:first-child').text();
        $(el).parent().find('.seek > i.bar > i').css('margin-left', '%');
        gradur(el);
    }, 1000);
}
function nformat(value) {
    var newValue = value;
    if (value >= 1000) {
        var suffixes = ["", "K", "M", "B", "T"];
        var suffixNum = Math.floor((""+value).length/3);
        var shortValue = '';
        for (var precision = 2; precision >= 1; precision--) {
            shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000, suffixNum)): value).toPrecision(precision));
            var dotLessShortValue = (shortValue + '').replace(/[^a-zA-Z 0-9]+/g, '');
            if (dotLessShortValue.length <= 2) {
                break;
            }
        }
        if (shortValue % 1 != 0)  shortValue = shortValue.toFixed(1);
        newValue = shortValue+suffixes[suffixNum];
    }
    return newValue;
}
function shwrdmre(str, len) {
    if (len == undefined) {
        len = 0;
    }
    $shrt = str;
    var maxLength = $(".dumb .gdefaults").find(".rdmre").text();
    if (len != 0) {
        maxLength = len;
    }
    if (maxLength !== "") {
        if ($.trim(str).length > maxLength) {
            var div = document.createElement("div");
            div.innerHTML = str;
            $shrt = div.innerText;
            var newStr = $shrt.substring(0, maxLength);
            var removedStr = str.substring(maxLength, $.trim(str).length);
            $shrt = newStr;
            if (len == 0) {
                $shrt = $shrt.replace(/(?:\r\n|\r|\n)/g, '<br>');
                $shrt = '<i class="shortmsg">'+$shrt+'</i><i class="readmore">'+$(".gphrases > .readmore").text()+'</i>';
                $shrt = $shrt+'<i class="moretext">' + str + '</i>';
            }
        }
    }
    return $shrt;
}