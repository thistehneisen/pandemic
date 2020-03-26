<?php if(!defined('s7V9pz')) {die();}?>URL = window.URL || window.webkitURL;
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext;
var recorder;
function startUserMedia(stream) {
    var input = audioContext.createMediaStreamSource(stream);

    recorder = new Recorder(input);
}
function startRecording(button) {
    var constraints = {
        audio: true, video: false
    };

    navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
        audioContext = new AudioContext();
        gumStream = stream;
        input = audioContext.createMediaStreamSource(stream);
        recorder = new Recorder(input, {
            numChannels: 1
        });
        recorder.record();

    }).catch(function(err) {
        alert("Unable to access microphone, please check browser settings");
        $('.gr-mic').removeClass('recrdng').fadeIn();
        recordButton.disabled = false;
        stopButton.disabled = true;
        pauseButton.disabled = true
    });

    button.disabled = true;
    button.nextElementSibling.disabled = false;
}
function stopRecording(button) {
    button.disabled = true;
    button.previousElementSibling.disabled = false;
    recorder.stop();
    gumStream.getAudioTracks()[0].stop();
    recorder.exportWAV(createDownloadLink);
}
function createDownloadLink(blob) {
    var url = URL.createObjectURL(blob);
    var filename = 'audiomsg'+ '.wav';
    var data = new FormData();
    data.append("act", 1);
    data.append("do", "group");
    data.append("type", "sendaudio");
    data.append("id", "sendaudio");
    data.append("audio_data", blob, filename);
    data.append("id", $('.swr-grupo .panel').attr('no'));
    data.append("ldt", $('.swr-grupo .panel').attr('ldt'));
    data.append("from", grlastid());
    $(".swr-grupo .panel > .room > .msgs").animate({
        scrollTop: $(".swr-grupo .panel > .room > .msgs").prop("scrollHeight")
    }, 500);
    var senid = rand(8);
    var moset = $(".dumb .gdefaults").find(".sndmsgalgn").text();
    var senmsg = $(".gphrases > .sending").text();
    var msg = '<li class="you animated fadeIn '+senid+' '+moset+'" no="0"> <div><span class="msg"><i>';
    msg = msg+'<span class="block" type="files"><span><span class="ptxt">'+(escapeHtml(senmsg))+'</span><span class="animated fadeInUp infinite">';
    msg = msg+'<i class="gi-upload"></i></span></span></span></i>';
    msg = msg+'</span></div></li>';
    $('.swr-grupo .panel > .room > .msgs').append(msg);
    scrollmsgs();
    $.ajax({
        url: '',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: 'post',
    }).done(function(data) {
        data = $.parseJSON(data);
        $("."+senid).remove();
        if ($(".swr-grupo .panel").attr("no") == data[0].gid) {
            loadmsg(data);
        }
    }).fail(function() {
        $(".swr-grupo .panel > .room > .msgs > li."+senid+" > div > .msg > i > span.block > span > span.ptxt").text($(".gphrases > .failed").text());
        $(".swr-grupo .panel > .room > .msgs > li."+senid+" > div > .msg > i > span.block > span > span > i").removeClass("gi-upload");
        $(".swr-grupo .panel > .room > .msgs > li."+senid+" > div > .msg > i > span.block > span > span").removeClass("animated");
        $(".swr-grupo .panel > .room > .msgs > li."+senid+" > div > .msg > i > span.block > span > span > i").addClass("gi-minus-circled-1");
        setTimeout(function() {
            $("."+senid).remove();
        }, 2000);
    })

}