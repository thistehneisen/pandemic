/***
    Interested in the code? We're looking for teammates & partnerships.
    info@pandemic.lv
***/

const randomDisplacement = () => Math.round(Math.random() * 1000 - 500) / 100000;

settings = {};
settings.refreshRate = 3000;
settings.service = {};
settings.service.data = true;
settings.service.global = true;
settings.service.people = true;
settings.service.places = true;
settings.service.chatbox = true;
settings.chat = {}
settings.chat.rooms = {};
settings.chat.refreshRate = 500;

pandemic = {};
pandemic.debug = false;
pandemic.init = ['data', 'places', 'people', 'chat'];
pandemic.loaded = [];
pandemic.markers = [];

var xhr = 'library/ajax.php';

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
        url: xhr,
        method: 'POST',
        dataType: 'json',
        async: true,
        data: postData,
        success: function(res) {
            if (typeof cb === 'function') cb.call(this, res);
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
        fail: function(reason, xhr) {
            if (pandemic.debug === true) {
                toastr.error(reason + ' XHR: ' + xhr, m + ': ' + a);
            }
        }
    });

}

function pandemicData(action, sub, data) {
    /* Fetching data to front-end */
    if (action === 'fetch') {
        if (sub === 'global' && settings.service.global === true) {
            req({
                a: 'data',
                m: 'global'
            }, function(res) {
                var items = [],
                    markerData = [];
                if (typeof res.global !== 'undefined' && res.global.length > 0) {
                    items = res.global;
                    for (var i = 0; i < items.length; i++) {
                        var item = items[i];
                        if (item.Country != 'Lithuania' && item.Country != 'Estonia')
                            continue;

                        if (typeof item.Lat !== 'undefined' &&
                            typeof item.Long !== 'undefined' &&
                            (item.Lat.length > 5 || item.Long.length > 5)) {
                            markerData.push({
                                lat: item.Lat,
                                lng: item.Long,
                                title: item.Date,
                                icon: getIcon('ff0000'),
                                description: item.State,
                                subtitle: item.Country
                            });
                            //console.log('Added: ' + item.Country);
                        }
                    }
                }

                pandemic.markers = map.addMarkers(markerData);
            });
        }
        if (sub === 'people' && settings.service.people === true) {
            req({
                a: sub,
                m: action,
                c: category
            }, function(res) {
                var items = [],
                    markerData = [];
                if (res.locations.length > 0) {
                    items = res.locations;
                    for (var i = 0; i < items.length; i++) {
                        var item = items[i];

                        if (typeof item.latitude !== 'undefined' &&
                            typeof item.longitude !== 'undefined') {
                            markerData.push({
                                id: item.id,
                                title: strip(item.name),
                                subtitle: item.status ? item.status : '',
                                description: '<img src="' + item.img + '" alt="' + strip(item.name) + '" style="width: 50px; height: 50px;"> ' + strip(item.description),
                                lat: item.latitude,
                                lng: item.longitude,
                                icon: getIcon('00ff54'),
                                name: item.name,
                                status: item.status,
                                category: item.category,
                                url: fullAddress + '?p=' + item.id
                            });
                        }
                    }
                }

                pandemic.markers = map.addMarkers(markerData);
            });
        } else if (sub === 'data' && settings.service.data === true) {
            req({
                a: sub,
                m: action
            }, function(res) {
                var items = [],
                    markerData = [];

                if (typeof res.data !== 'undefined' && res.data.length > 0) {
                    items = res.data;
                    for (var i = 0; i < items.length; i++) {
                        var item = items[i];

                        if (typeof item.selfCooLat !== 'undefined' &&
                            typeof item.selfCooLng !== 'undefined') {
                            markerData.push({
                                id: item.id,
                                lat: item.selfCooLat * 1 + randomDisplacement(),
                                lng: item.selfCooLng * 1 + randomDisplacement(),
                                title: item.label,
                                icon: getIcon('ff0000'),
                                description: '<strong>Notes:</strong></br>' + item.descriptionTitle + '<br/><strong>First contact in Latvia:</strong> ' + item.dateOfFirstContactWithLatvia + '<br/><strong>Broadcasted:</strong> ' + item.dateOfDiagnosisBroadcast + '<br/><strong>Sources:</strong><ol><li><a href="' + item.link + '" target="_blank">' + item.link + '</a></li>' + (item.extraLink1 ? '<li><a href="' + item.extraLink1 + '" target="_blank">' + item.extraLink1 + '</a></li>' : '') + '' + (item.extraLink2 ? '<li><a href="' + item.extraLink2 + '" target="_blank">' + item.extraLink2 + '</a></li>' : '') + '' + (item.extraLink3 ? '<li><a href="' + item.extraLink3 + '" target="_blank">' + item.extraLink3 + '</a></li>' : '') + '</ol>',
                                subtitle: item.origin,
                                url: fullAddress + '?d=' + item.id
                            });
                        }
                    }
                }

                pandemic.markers = map.addMarkers(markerData);
            });
        } else if (sub === 'places' && settings.service.places === true) {
            req({
                a: sub,
                m: action,
                c: category
            }, function(res) {
                var items = [],
                    markerData = [];
                if (typeof res.places !== 'undefined' && res.places.length > 0) {
                    items = res.places;
                    for (var i = 0; i < items.length; i++) {
                        var item = items[i];

                        if (typeof item.latitude !== 'undefined' &&
                            typeof item.longitude !== 'undefined') {
                            markerData.push({
                                id: item.id,
                                lat: item.latitude,
                                lng: item.longitude,
                                title: item.title,
                                icon: getIcon(),
                                description: item.description,
                                gallery: item.gallery,
                                subtitle: item.subtitle,
                                url: fullAddress + '?i=' + item.id
                            });
                        }
                    }
                }

                pandemic.markers = map.addMarkers(markerData);
            });
        } else if (sub === 'chat' && settings.service.chatbox === true) {
            req({
                a: sub,
                m: action
            }, function(res) {
                // res.msgs coming out here
            });
        }
    }

    /* Chat XHR */
    else if (action === 'chat') {
        if (sub === 'send') {
            req({
                a: action,
                m: sub,
                t: data.t,
                r: data.r,
                msg: data.m
            }, function(res) {
                //
            });
        } else if (sub === 'ping') {
            req({
                a: action,
                m: sub
            }, function(res) {
                // PONG
            });
        }
    }
}

// Initialise the Maps
map = new GMaps({
    div: '#map',
    lat: latitude,
    lng: longitude,
    zoom: 9,
    styles: [{
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [{
            "color": "#444444"
        }]
    }, {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [{
            "color": "#f2f2f2"
        }]
    }, {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "road",
        "elementType": "all",
        "stylers": [{
            "saturation": -100
        }, {
            "lightness": 45
        }]
    }, {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [{
            "visibility": "simplified"
        }]
    }, {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "water",
        "elementType": "all",
        "stylers": [{
            "color": "#46bcec"
        }, {
            "visibility": "on"
        }]
    }]
});

Dropzone.autoDiscover = false;

$(document).ready(function() {
    // Initialising
    pandemic.init.forEach(service => pandemicData('fetch', service));
    geoLocate();

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

    if (typeof fbId === 'undefined') {
        toastr.info('Welcome to Pandemic Baltics, where you can help others and find help yourself during crisis. By using the platform, you agree to our <strong><a href="#terms-and-conditions">Terms & Conditions</a></strong>.');
    }

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
        accept: function(file, done) {
            done();
        }
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

    var template = Handlebars.compile($('#marker-content-template').html());

    map.on('marker_added', function(marker) {
        /* Marker created for the purpose of creating a new place. */
        if (marker.setLocation === true) {
            var index = map.markers.indexOf(marker);
            var info = null;
            var closeDelayed = false;
            var closeDelayHandler = function() {
                $(info.getWrapper()).removeClass('active');
                setTimeout(function() {
                    closeDelayed = true;
                    info.close();
                }, 300);
            };

            var info = new SnazzyInfoWindow({
                marker: marker,
                position: 'top',
                offset: {
                    top: '-55px'
                },
                content: '<div>' + marker.title + '</div>',
                showCloseButton: false,
                closeOnMapClick: false,
                padding: '7px 12px',
                backgroundColor: '#29cc5a',
                border: false,
                borderRadius: '3px',
                shadow: false,
                fontColor: '#fff',
                fontSize: '15px'
            });
            info.open();
            return false;
        } else {
            /* Markers coming from database or AJAX */
            var index = map.markers.indexOf(marker);
            var info = null;
            var closeDelayed = false;
            var closeDelayHandler = function() {
                $(info.getWrapper()).removeClass('active');
                setTimeout(function() {
                    closeDelayed = true;
                    info.close();
                }, 300);
            };

            // Static tooltips above the markers
            var tooltip = new SnazzyInfoWindow({
                marker: marker,
                position: 'top',
                offset: {
                    top: '-15px'
                },
                content: '<div><strong>' + strip(marker.title) + '</strong></div>' + '<div>' + marker.subtitle + '</div>',
                showCloseButton: false,
                closeOnMapClick: false,
                padding: '5px 10px',
                backgroundColor: 'rgba(0, 0, 0, 0.6)',
                border: false,
                borderRadius: '0px',
                shadow: false,
                fontColor: '#fff',
                fontSize: '11px',
                panOnOpen: false
            });
            tooltip.open();

            info = new SnazzyInfoWindow({
                marker: marker,
                wrapperClass: 'custom-window',
                offset: {
                    top: '-33px'
                },
                edgeOffset: {
                    top: 0,
                    right: 0,
                    bottom: 0
                },
                border: false,
                shadow: false,
                closeButtonMarkup: '<button type="button" class="custom-close">&#215;</button>',
                content: template({
                    title: marker.title,
                    subtitle: marker.subtitle,
                    body: marker.description,
                    gallery: marker.gallery,
                    url: marker.url,
                    person_id: marker.id
                }),
                callbacks: {
                    open: function() {
                        $(this.getWrapper()).addClass('open');
                        baguetteBox.run('.gallery');
                    },
                    afterOpen: function() {
                        var wrapper = $(this.getWrapper());
                        wrapper.addClass('active');
                        wrapper.find('.custom-close').on('click', closeDelayHandler);
                    },
                    beforeClose: function() {
                        if (!closeDelayed) {
                            closeDelayHandler();
                            return false;
                        }
                        return true;
                    },
                    afterClose: function() {
                        var wrapper = $(this.getWrapper());
                        wrapper.find('.custom-close').off();
                        wrapper.removeClass('open');
                        closeDelayed = false;
                    }
                }
            });

            // Open the i GET parameter
            if (typeof openPlace !== 'undefined' && openPlace === marker.id) {
                map.panTo(marker.getPosition());
                info.open();
            }
        }
    });

    $(document).on('click', '.login-fb', function(e) {
        e.preventDefault();
        try {
            FB.login(function(response) {
                if (response.status === 'connected') {
                    FB.api('/me', function(response) {
                        toastr.success('Welcome back, ' + response.name + '!', 'Authenticated');
                        fbId = response.id;
                        $.get(fullAddress, function(response) {
                            //console.log(response);
                            var header = $(response).find('header').html();
                            //console.log(header);
                            //$('header').fadeOut('fast').html(header);
                        });
                        setTimeout(function(){ window.location.reload(); }, 500);
                    });
                } else if (response.status === 'not_authorized') {
                    toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
                } else {
                    toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
                }
            }, {
                scope: 'public_profile'
            });
        } catch (e) {
            toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
        }
    });
});

// Saving the profile functionality
$('#save-profile').on('click', function(e) {
    e.preventDefault();
    $('#save-profile span').text('Saving…');

    req({
        a: 'profile',
        m: 'save',
        pseudo: $('#nickname').val(),
        status: $('#status').val(),
        category: $('#profilecat').val(),
        display: $('#mapdisplay').val(),
        description: $('#profiledesc').val()
    }, function(res) {
        if (typeof res.errors !== 'undefined' && res.errors.length > 0) {
            $('#post-the-ad span').html('Save profile &rarr;');
            toastr.error(res.errors[0], 'Whoops!');
        } else {
            toastr.success('Your profile has been updated.', 'Success');
            $('#save-profile span').text('Profile saved');
        }
    });
});

// Posting new service functionality
$('#post-the-ad').on('click', function(e) {
    e.preventDefault();
    $('#post-the-ad span').text('Sending…');

    req({
        a: 'places',
        m: 'create',
        title: $('#title').val(),
        description: $('#description').val(),
        category: $('#category').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        website: $('#website').val()
    }, function(res) {
        if (typeof res.errors !== 'undefined' && res.errors.length > 0) {
            $('#post-the-ad span').html('Ready to publish &rarr;');
            toastr.error(res.errors[0], 'Whoops!');
        } else {
            makeLocation(res.id);
        }
    });
});

$("#global-data").fancybox({
    'autoSize':false,
    'type':'iframe',
    'src':'https://global.pandemic.lv/',
    'caption':'https://global.pandemic.lv/'
});

/* Location creation */
function makeLocation(placeId) {
    $('#save-location').data('place', placeId);
    $('div.si-wrapper-top').hide();

    clearOverlays();

    placeMarker = map.addMarker({
        lat: latitude,
        lng: longitude,
        icon: getIcon('29cc5a', 'fff'),
        draggable: true,
        setLocation: true,
        zIndex: 999999,
        dragend: function(e) {
            var lat = e.latLng.lat();
            var lng = e.latLng.lng();
            $('#save-location').data('lat', lat);
            $('#save-location').data('lng', lng);
        },
        title: 'Click & drag to set the location!'
    });

    placeMarker.setZIndex(999999);

    $('#save-location').show();
    $('.show-modal').addClass('out').removeClass('show-modal in');
    $('#modals').removeClass('show-modals');

    setTimeout(function() {
        $('.lean-modal').removeClass('out');
    }, 600);
    map.panTo(placeMarker.getPosition());
}

$('#save-location').on('click', function(e) {
    e.preventDefault();
    req({
        a: 'places',
        m: 'location',
        place: $(this).data('place'),
        lat: $(this).data('lat'),
        lng: $(this).data('lng')
    }, function(r) {
        if (r.result == 'success') {
            toastr.success('The selected location is now published with your specified information.', 'Place published');
        } else {
            toastr.error('We have some kind of technical difficulities, if the problem persists, please get in touch!', 'Error');
        }
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
                a: 'people',
                m: 'set',
                lat: position.coords.latitude,
                lng: position.coords.longitude
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
        options: {
            enableHighAccuracy: true
        }
    });
}

function getIcon(fC = '00aeef', sColor = 222, sC = 1.2, fO = 0.65, url = undefined) {
    return {
        path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
        fillColor: '#' + fC,
        fillOpacity: fO,
        scale: sC,
        strokeColor: '#' + sC,
        strokeWeight: 2,
        url: url,
        anchor: new google.maps.Point(12, 12)
    };
}

function dismissPreloader() {
    $('#map').css({
        'width': '100%',
        'height': '100%'
    });
    $('#preloader').remove();
    $('.preload-hide').show();
    map.setCenter({
        lat: latitude,
        lng: longitude
    });
}

function clearOverlays() {
    for (var i = 0; i < pandemic.markers.length; i++)
        pandemic.markers[i].setMap(null);
    pandemic.markers.length = 0;
}

function strip(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}
