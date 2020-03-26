<?php if(!defined('s7V9pz')) {die();}?>function gr_live(tms, typ, tls) {
    var turn = 'on';
    if (turn == 'on') {
        if (tms === undefined) {
            tms = 'now';
        }
        if (typ === undefined) {
            typ = 'now';
        }
        if (tls === undefined) {
            tls = 'now';
        }
        ajxclrtm['grlive'] = setTimeout(function() {
            var lastid = grlastid();
            var tab = [];
            tab['groups'] = $(".swr-grupo .lside > .tabs > ul > li[act='groups']");
            tab['pm'] = $(".swr-grupo .lside > .tabs > ul > li[act='pm']");
            tab['alerts'] = $(".swr-grupo .rside > .tabs > ul > li[act='alerts']");
            tab['complaints'] = $(".swr-grupo .rside > .tabs > ul > li[act='complaints']");
            var pm = 'on';
            var chat = 'on';
            if ($('.swr-grupo .panel > .textbox').hasClass('disabled')) {
                chat = 'off';
            }
            if ($(".swr-grupo .lside > .tabs > ul > li[act='pm']").text() == "") {
                pm = 'off';
            }
            var mtick = 'unread';
            var data = {
                act: 1,
                do: "liveupdate",
                gid: $('.swr-grupo .panel').attr('no'),
                lastid: lastid,
                unseen: tab['groups'].attr('unseen'),
                unread: tab['pm'].attr('unread'),
                chat: chat,
                pm: pm,
                tms: tms,
                tls: tls,
                mtick: mtick,
                typ: typ,
                ldt: $('.swr-grupo .panel').attr('ldt'),
            };
            ajxvar['grlive'] = $.ajax({
                type: 'POST',
                url: '',
                data: data,
                dataType: 'text',
                beforeSend: function() {
                    if (ajxvar['grlive'] !== null && ajxvar['grlive'] !== undefined) {
                        ajxvar['grlive'].abort();
                    }
                },
                success: function(data) {}
            }).done(function(data) {
                var data = $.parseJSON(data);
                if (Object.keys(data).length > 0) {
                    if (data[0].liveup == 'refresh') {
                        window.location.href = "";
                    } else {
                        if (!$('.swr-grupo .panel > .textbox').hasClass('disabled')) {
                            if (data[0].liveup == 'msgs' && $(".swr-grupo .panel").attr("no") == data[0].gid) {
                                if (grlastid() == lastid) {
                                    grtyping('');
                                    loadmsg(data);
                                }
                            }
                        }
                        if (data[0].liveup == 'unseen') {
                            if (data[0].typing == 1) {
                                typ = data[0].livetyptms;
                                var typing = '';
                                $(data[0].typers).each(function(inx, valz) {
                                    typing = typing+ '<li><span>'+valz.v3+'</span>is typing</li>';
                                });
                                grtyping(typing);
                            } else {
                                grtyping('');
                            }
                            if (data[0].lastseen !== null && data[0].lastseen !== undefined) {
                                grmsgread(data[0].lastseen);
                            }
                            if (data[0].livelstms !== null && data[0].livelstms !== undefined) {
                                tls = data[0].livelstms;
                            }
                            if (data[0].actunseen == 1) {
                                tms = data[0].liveuptms;
                                if (data[0].group == 0) {
                                    tab['groups'].find('i > i').remove();
                                } else {
                                    tab['groups'].find('i').html("<i>"+nformat(data[0].group)+"</i>");
                                }
                                if (data[0].alerts == 0) {
                                    $(".swr-grupo i.malert > i").remove();
                                    tab['alerts'].find('i > i').remove();
                                } else {
                                    $(".swr-grupo i.malert").html("<i>"+nformat(data[0].alerts)+"</i>");
                                    tab['alerts'].find('i').html("<i>"+nformat(data[0].alerts)+"</i>");
                                }
                                if (data[0].complaints == 0) {
                                    tab['complaints'].find('i > i').remove();
                                } else {
                                    tab['complaints'].find('i').html("<i>"+nformat(data[0].complaints)+"</i>");
                                }
                                if (pm == 'on') {
                                    if (data[0].pm == 0) {
                                        tab['pm'].find('i > i').remove();
                                    } else {
                                        tab['pm'].find('i').html("<i>"+nformat(data[0].pm)+"</i>");
                                    }
                                }
                            }
                        }
                    }
                }
                gr_live(tms, typ, tls);
            }) .fail(function(qXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    gr_live(tms, typ, tls);
                }, 4000);
            });
        }, $(".dumb .liveuptime").val());
    }
}