/***
    Interested in the code? We're looking for teammates & partnerships.
    info@pandemic.lv
***/

settings                        = {};
settings.refreshRate            = 3000;
settings.service                = {};
settings.service.data           = true;
settings.service.people         = true;
settings.service.places         = true;
settings.service.chatbox        = true;
settings.chat                   = {}
settings.chat.rooms             = {};
settings.chat.refreshRate       = 500;

pandemic                        = {};
pandemic.debug                  = true;
pandemic.init                   = ['data', 'places', 'people', 'chat'];
pandemic.loaded                 = [];
pandemic.markers                = [];

var xhr                         = 'library/ajax.php';

function pandemicSettings(action, sub, data) {
    if (action === 'toggle') {
        if (typeof settings.service[sub] !== 'undefined') {
            settings.service[sub] = !settings.service[sub];
            data.find('span strong').html(settings.service[sub] ? '&#10004;' : '&#10060;');
        }
    }
}

function req(postData, cb) {
    var a = postData.a,
        m = postData.m;

    $.ajax({
        url         : xhr,
        method      : 'POST',
        dataType    : 'json',
        async       : false,
        data        : postData,
        success     : function (res) {
                        if (typeof cb === 'function') cb.call(this,res);
                        if (m === 'fetch') {
                            if (typeof pandemic.loaded[a] === 'undefined' &&
                                pandemic.loaded.length < pandemic.init.length &&
                                pandemic.init.includes(a)) {
                                $('#preload-status strong').text(a);
                                pandemic.loaded.push(a);
                            }
                            if (pandemic.loaded.length === pandemic.init.length) {
                                dismissPreloader();
                            }
                        }
                        },
        fail        : function (reason, xhr) { if (pandemic.debug === true) { toastr.error(reason + ' XHR: ' + xhr, m + ': ' + a);  } }
    });

}

function pandemicData(action, sub, data) {
    /* Fetching data to front-end */
    if (action === 'fetch') {
        if (sub === 'people' && settings.service.people === true) {
            req({a:sub,m:action,c:category}, function(res) {
                var items = [],
                    markerData = [];
                if (res.locations.length > 0) {
                    items = res.locations;
                    for (var i = 0; i < items.length; i++) {
                        var item = items[i];

                        if (typeof item.latitude !== 'undefined' &&
                            typeof item.longitude !== 'undefined') {
                            markerData.push({
                                id          : item.id,
                                title       : strip(item.name),
                                subtitle    : item.status ? item.status : '',
                                description : '<img src="'+item.img+'" alt="'+strip(item.name)+'" style="width: 50px; height: 50px;">',
                                lat         : item.latitude,
                                lng         : item.longitude,
                                icon        : getIcon('00ff54'),
                                name        : item.name,
                                status      : item.status,
                                category    : item.category,
                                url         : fullAddress + '?p=' + item.id
                            });
                        }
                    }
                }

                //pandemic.markers = map.addMarkers(markerData);
            });
        } else if (sub === 'data' && settings.service.data === true) {
            req({a:sub,m:action}, function(res) {
                const randomDisplacement = () => Math.round(Math.random() * 1000 - 500) / 100000;
                const markers = res.data.map(item => ({
                    id          : item.id,
                    lat         : item.selfCooLat * 1 + randomDisplacement(),
                    lng         : item.selfCooLng * 1 + randomDisplacement(),
                    title       : item.label,
                    icon        : getIcon('ff0000'),
                    description : '<strong>Notes:</strong></br>'+item.descriptionTitle+'<br/><strong>First contact in Latvia:</strong> '+item.dateOfFirstContactWithLatvia+'<br/><strong>Broadcasted:</strong> '+item.dateOfDiagnosisBroadcast+'<br/><strong>Sources:</strong><ol><li><a href="'+item.link+'" target="_blank">'+item.link+'</a></li>'+(item.extraLink1 ? '<li><a href="'+item.extraLink1+'" target="_blank">'+item.extraLink1+'</a></li>' : '')+''+(item.extraLink2 ? '<li><a href="'+item.extraLink2+'" target="_blank">'+item.extraLink2+'</a></li>' : '')+''+(item.extraLink3 ? '<li><a href="'+item.extraLink3+'" target="_blank">'+item.extraLink3+'</a></li>' : '')+'</ol>',
                    subtitle: item.origin,
                    url         : fullAddress + '?d=' + item.id
                }));
        
                //pandemic.markers = pandemic.markers.concat(map.addMarkers(markers));
            });
        } else if (sub === 'places' && settings.service.places === true) {
            req({a:sub,m:action,c:category}, function(res) {
                var items = [], markerData = [];
                if (typeof res.places !== 'undefined' && res.places.length > 0) {
                    items = res.places;
                    for (var i = 0; i < items.length; i++) {
                        var item = items[i];
        
                        if (typeof item.latitude !== 'undefined' &&
                            typeof item.longitude !== 'undefined') {
                            markerData.push({
                                id          : item.id,
                                lat         : item.latitude,
                                lng         : item.longitude,
                                title       : item.title,
                                icon        : getIcon(),
                                description : item.description,
                                gallery     : item.gallery,
                                subtitle    : item.subtitle,
                                url         : fullAddress + '?i=' + item.id
                            });
                        }
                    }
                }

                //pandemic.markers = map.addMarkers(markerData);
            });
        } else if (sub === 'chat' && settings.service.chatbox === true) {
            req({a:sub,m:action}, function(res) {
                // res.msgs coming out here
            });
        }
    }

    /* Chat XHR */
    else if (action === 'chat') {
        if (sub === 'send') {
            req({a:action,m:sub,t:data.t,r:data.r,msg:data.m}, function(res) {
                //
            });
        } else if (sub === 'ping') {
            req({a:action,m:sub}, function(res) {
                // PONG
            });
        }
    }
}

Dropzone.autoDiscover = false;

$(document).ready(function() {
    // Initialising
    pandemic.init.forEach(service => pandemicData('fetch', service));

    // Chatbox
    $('input#chatbox').on("keypress", function(e) {
        var elem = $(this);

        if (e.keyCode == 13) { // Enter
            e.preventDefault();
            if (typeof fbId === 'undefined') {
                toastr.error('To use the chat and see available channels, you need to authorize with Facebook.', 'Please authorize');
                $('.login-fb').click();
                return false;
            } else if (elem.val().length > 0) {
                /*var r = pandemicData('chat', 'send', {t:elem.data('t'),m:elem.val()});
                if (r.result === 'success') {
                    alert('Seeent!');
                }*/
            }
        }
    });

    /* Dropzone */
    $("#img-upload").dropzone({
        paramName: "file",
        maxFilesize: 10,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        createImageThumbnails: true,
        thumbnailWidth: null,
        thumbnailHeight: null,
        clickable: true,
        addRemoveLinks: true,
        acceptedFiles: "image/*",
        accept: function(file, done) { done(); }
    });

    /* Modal windows for pages */
    $.fn.extend({
        leanModal: function() {
            var container = $('#modals');
            window.onhashchange = function(e) {
                if (window.location.hash) {
                    close_all_modals();
                    if (window.location.hash && $(window.location.hash + '.lean-modal').length) {
                        open_modal(window.location.hash);
                    }
                } else {
                    close_all_modals();
                }
            }
            return this.each(function() {
                if (window.location.hash && $(window.location.hash + '.lean-modal').length) {
                    open_modal(window.location.hash);
                }
                $(this).click(function() {
                    close_all_modals();
                    open_modal($(this).attr("href"));
                });
                $('.close-modal, #lean-mask').on('click', function(e) {
                    close_all_modals();
                    history.pushState("", document.title, window.location.pathname);
                    event.preventDefault();
                });
            });

            function open_modal(modal_id) {
                $(document.body).addClass('noscroll');
                container.addClass('show-modals');
                $(modal_id).addClass('show-modal in').removeClass('out');
                setTimeout(function() {
                    $('.lean-modal').removeClass('in');
                }, 600);
            }

            function close_modal(modal_id) {
                $(document.body).removeClass('noscroll');
                container.removeClass('show-modals');
                $(modal_id).addClass('out').removeClass('show-modal in');
                setTimeout(function() {
                    $('.lean-modal').removeClass('out');
                }, 600);
            }

            function close_all_modals() {
                close_modal();
                $('.show-modal').addClass('out').removeClass('show-modal in');
            }
        }
    });
    $("a[rel*=leanModal]").leanModal();

    /* Terms Agreement */
    $(document).on('click', ".button.agree", function(e) {
        document.getElementById("signup-agree").checked = true;
        $('.button.confirm').removeClass('disabled');
    });
    $(document).on('click', ".button.disagree", function(e) {
        document.getElementById("signup-agree").checked = false;
        $('.button.confirm').addClass('disabled');
    });
    $('#signup-agree').change(function() {
        this.checked ? $('.button.confirm').removeClass('disabled') : $('.button.confirm').addClass('disabled');
    });

    /* Burger menu */
    $(document).on('click', "a.nav-toggle", function(e) {
        e.preventDefault();
        $(this).toggleClass('cross');
        $('body').toggleClass('noscroll');
        $('header').toggleClass('show_nav');
        $('.mask').toggleClass('show-mask');
    });

    $(document).on('click', '.login-fb', function(e) {
        e.preventDefault();
        try {
            FB.login(function(response) {
                if (response.status === 'connected') {
                    FB.api('/me', function(response) {
                        toastr.success('Welcome back, ' + response.name + '!', 'Authenticated');
                        fbId = response.id;
                        $.get('', function(response){
                            var header = $(response).find('header').html();
                            console.log(header);
                            $('header').fadeOut('fast').html(header);
                        });
                        //setTimeout(function(){ window.location.reload(); }, 500);
                    });
                } else if (response.status === 'not_authorized') {
                    toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
                } else {
                    toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
                }
            }, {
                scope: 'public_profile'
            });
        } catch(e) {
            toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
        }
    });
});

$('#post-the-ad').on('click', function(e) {
    e.preventDefault();
    $('#post-the-ad span').text('Sending…');

    req({
        a               : 'places',
        m               : 'create',
        title           : $('#title').val(),
        description     : $('#description').val(),
        category        : $('#category').val(),
        phone           : $('#phone').val(),
        email           : $('#email').val(),
        website         : $('#website').val()
    }, function(res) {
        if (typeof res.errors !== 'undefined' && res.errors.length > 0) {
            $('#post-the-ad span').html('Ready to publish &rarr;');
            toastr.error(response.errors[0], 'Whoops!');
        } else { makeLocation(response.id); }
    });
});

/* Location creation */
function makeLocation(placeId) {
    $('#save-location').data('place', placeId);
    $('div.si-wrapper-top').hide();

    clearOverlays();

    $('#save-location').show();
    $('.show-modal').addClass('out').removeClass('show-modal in');
    $('#modals').removeClass('show-modals');

    setTimeout(function() { $('.lean-modal').removeClass('out'); }, 600);
    map.panTo(placeMarker.getPosition());
}

$('#save-location').on('click', function(e) {
    e.preventDefault();
    req({
        a           : 'places',
        m           : 'location',
        place       : $(this).data('place'),
        lat         : $(this).data('lat'),
        lng         : $(this).data('lng')
    }, function(r) {
        if (r.result == 'success') { toastr.success('The selected location is now published with your specified information.', 'Place published'); }
        else { toastr.error('We have some kind of technical difficulities, if the problem persists, please get in touch!', 'Error'); }
    });
});

// Other settings
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "20000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

// Helpers
function geoLocate() {
    GMaps.geolocate({
        success: function(position) {
            map.setCenter(position.coords.latitude, position.coords.longitude);
            req({
                a       : 'people',
                m       : 'set',
                lat     : position.coords.latitude,
                lng     : position.coords.longitude
            });
        },
        error: function(error) {
            toastr.error('GeoLocation is sending us an error: ' + error, 'Error');
            map.setZoom(9);
        },
        not_supported: function() {
            toastr.error('This browser doesn\'t support GeoLocation. Please check extensions, or try with different browser.', 'Not supported');
            map.setZoom(9);
        },
        options: { enableHighAccuracy: true }
    });
}

function getIcon(fC = '00aeef', sColor = 222, sC = 1.2, fO = 0.65, url = undefined) {
    return true;
}

function dismissPreloader() {
    map.setCenter({lat:latitude,lng:longitude});
    $('#preloader').remove();
    $('.preload-hide').show();
    $('#map').css({'width': '100%','height': '100%'});
}

function clearOverlays() {
    for (var i = 0; i < allMarkers.length; i++)
        pandemic.markers[i].setMap(null);
    pandemic.markers.length = 0;
}

function strip(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}
