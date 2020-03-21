/*
Interested in the code? We're looking for teammates & partnerships.
info@pandemic.lv
*/

settings = {};
settings.noUsers = false;
settings.noServices = false;
settings.userChannel = 'default';

function pandemicSettings(action, element) {
    if (action == 'togglePeople') {
        settings.noUsers = !settings.noUsers;
        if (settings.noUsers === false) {
            element.find('span strong').html('&#10004;');
        } else {
            element.find('span strong').html('&#10060;');
        }
    } else if (action == 'toggleServices') {
        settings.noServices = !settings.noServices;
        if (settings.noServices === false) {
            element.find('span strong').html('&#10004;');
        } else {
            element.find('span strong').html('&#10060;');
        }
    }
}

function pandemicData(action, sub, data) {
    if (action == 'fetchUsers') {
        if (typeof sub === 'undefined' && settings.noUsers !== true) {
            $.post('library/ajax.php', {
                action: 'userlocations',
                category: category
            }, function(results) {
                var items = [],
                    markers_data = [];
                if (results.locations.length > 0) {
                    items = results.locations;
                    for (var i = 0; i < items.length; i++) {
                        var item = items[i];

                        if (item.latitude != undefined && item.longitude != undefined) {
                            markers_data.push({
                                id: item.id,
                                title: strip(item.name),
                                subtitle : item.status ? item.status : '',
                                description: '<img src="'+item.img+'" alt="'+strip(item.name)+'" style="width: 50px; height: 50px;">',
                                lat: item.latitude,
                                lng: item.longitude,
                                icon: activeIcon,
                                name: item.name,
                                status: item.status,
                                category: item.category,
                                url: fullAddress + '?user=' + item.id
                            });
                        }
                    }
                }
                allMarkers = map.addMarkers(markers_data);
            }, 'json');
        }
    }
}

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

Dropzone.autoDiscover = false;
var map;
$(document).ready(function() {
    $.post('library/ajax.php', {
        action: 'chat_items',
        channel: settings.userChannel
    }, function(results) {
        for (var i = results.items.length - 1; i >= 0; i--) {
            $('#chat_holder').append('<span class="chat_item">' + results.items[i].message + '</span>');
        };
    }, 'json');

    // Chatbox
    $('input#chatbox').on("keypress", function(e) {
        var elem = $(this);

        /* ENTER PRESSED */
        if (e.keyCode == 13) {
            e.preventDefault();
            if (typeof fbId === 'undefined') {
                toastr.error('To use the chat and see available channels, you need to authorize with Facebook.');
                $('.login-fb').click();
                return false;
            } else {
                if (elem.val().length > 0) {
                    $.post('library/ajax.php', {
                        action: 'chat',
                        channel: settings.userChannel,
                        message: elem.val()
                    }, function(results) {
                        elem.val('');
                    });
                }
            }
        }
    });

    // Dropzone image upload
    $("#img-upload").dropzone({
        paramName: "file",
        maxFilesize: 10,
        uploadMultiple: true,
        parallelUploads: 1,
        maxFiles: 5,
        createImageThumbnails: true,
        thumbnailWidth: null,
        thumbnailHeight: null,
        clickable: true,
        addRemoveLinks: true,
        acceptedFiles: "image/*",
        accept: function(file, done) {
            done();
        },
        init: function() {
            this.on("addedfile", function() {
                // if (this.files[1]!=null){
                // 	this.removeFile(this.files[0]);
                // }
            });
        }
    });

    // - - - - - - - - - - -  Lean modal  - - - - - - - - - - -
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

    // - - - - - - - - - - -  Agree with terms  - - - - - - - - - - -
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

    // - - - - - - - - - - -  Mobile burger  - - - - - - - - - - -
    $(document).on('click', "a.nav-toggle", function(e) {
        e.preventDefault();
        $(this).toggleClass('cross');
        $('body').toggleClass('noscroll');
        $('header').toggleClass('show_nav');
        $('.mask').toggleClass('show-mask');
    });

    // Set up handle bars
    var template = Handlebars.compile($('#marker-content-template').html());

    /* Map */
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
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [{
                    "color": "#f2f2f2"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [{
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [{
                    "visibility": "simplified"
                }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [{
                        "color": "#46bcec"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ]
    });

    var activeIcon = {
        path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
        fillColor: '#222',
        fillOpacity: 0.95,
        scale: 1.5,
        strokeColor: '#00ff54',
        strokeWeight: 2,
        anchor: new google.maps.Point(12, 24)
    };

    var markerIcon = {
        path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
        fillColor: '#00aeef',
        fillOpacity: 0.95,
        scale: 1.5,
        strokeColor: '#222',
        strokeWeight: 2,
        anchor: new google.maps.Point(12, 24)
    };

    var quarantineIcon = {
        path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
        fillColor: '#ff0000',
        fillOpacity: 0.95,
        scale: 1.5,
        strokeColor: '#222',
        strokeWeight: 2,
        anchor: new google.maps.Point(12, 24)
    };

    allMarkers = [];

    pandemicAction('fetchUsers');

    $.post('library/ajax.php', {
        action: 'retrieve',
        category: category
    }, function(results) {
        var items = [],
            markers_data = [];
        if (results.classifieds.length > 0) {
            items = results.classifieds;
            for (var i = 0; i < items.length; i++) {
                var item = items[i];

                if (item.latitude != undefined && item.longitude != undefined) {
                    markers_data.push({
                        id: item.id,
                        lat: item.latitude,
                        lng: item.longitude,
                        title: item.title,
                        icon: markerIcon,
                        description: item.description,
                        price: item.price,
                        gallery: item.gallery,
                        subtitle: item.subtitle,
                        url: fullAddress + '?id=' + item.id
                    });
                }
            }
        }
        allMarkers = map.addMarkers(markers_data);
    }, 'json');

    $.get('json_data.php', function(results) {
        const randomDisplacement = () => Math.round(Math.random() * 1000 - 500) / 100000;
        const markers = results.map(item => ({
            id: item.id,
            lat: item.selfCooLat * 1 + randomDisplacement(),
            lng: item.selfCooLng * 1 + randomDisplacement(),
            title: item.label,
            icon: quarantineIcon,
            description: '<strong>Notes:</strong></br>'+item.descriptionTitle+'<br/><strong>First contact in Latvia:</strong> '+item.dateOfFirstContactWithLatvia+'<br/><strong>Broadcasted:</strong> '+item.dateOfDiagnosisBroadcast+'<br/><strong>Sources:</strong><ol><li><a href="'+item.link+'" target="_blank">'+item.link+'</a></li>'+(item.extraLink1 ? '<li><a href="'+item.extraLink1+'" target="_blank">'+item.extraLink1+'</a></li>' : '')+''+(item.extraLink2 ? '<li><a href="'+item.extraLink2+'" target="_blank">'+item.extraLink2+'</a></li>' : '')+''+(item.extraLink3 ? '<li><a href="'+item.extraLink3+'" target="_blank">'+item.extraLink3+'</a></li>' : '')+'</ol>',
            price: undefined,
            gallery: undefined,
            subtitle: item.origin,
            url: fullAddress + '?case=' + item.id
        }));

        allMarkers = allMarkers.concat(map.addMarkers(markers));
    }, 'json');

    map.on('marker_added', function(marker) {
        /*
        Marker created for location setting purposes
        */
        if (marker.setlocation == true) {
            var index = map.markers.indexOf(marker);
            // Set up a close delay for CSS animations
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
        } else { // Marker coming from database
            var index = map.markers.indexOf(marker);
            // Set up a close delay for CSS animations
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
                    top: '-33px'
                },
                content: '<div><strong>' + strip(marker.title) + '</strong></div>' +
                    '<div>' + marker.subtitle + '</div>',
                showCloseButton: false,
                closeOnMapClick: false,
                padding: '5px 10px',
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                border: false,
                borderRadius: '0px',
                shadow: false,
                fontColor: '#fff',
                fontSize: '13px'
            });
            info.open();

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
                    url: marker.url
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
            if (typeof openMarker !== 'undefined' && openMarker == marker.id) {
                map.panTo(marker.getPosition());
                info.open();
            }
        }
    });

    GMaps.geolocate({
        success: function(position) {
            map.setCenter(position.coords.latitude, position.coords.longitude);
            $.post('library/ajax.php', {
                action: 'newlocation',
                lat: position.coords.latitude,
                lng: position.coords.longitude
            });
        },
        error: function(error) {
            map.setZoom(9);
        },
        not_supported: function() {
            toastr.error('Your browser doesn\'t support this function.', 'GeoLocation');
            map.setZoom(9);
        },
        options: {
            enableHighAccuracy: true
        }
    });

    $(document).on('click', '.login-fb', function(e) {
        e.preventDefault();
        try {
            FB.login(function(response) {
                if (response.status === 'connected') {
                    window.location.reload();
                } else if (response.status === 'not_authorized') {
                    toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
                } else {
                    toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
                }
            }, {
                scope: 'email,public_profile'
            });
        } catch(e) {
            toastr.error('We had an error authorising you on Facebook. Make sure all blocking extensions are disabled. If the problem persists, contact us via info@pandemic.lv', 'Facebook Authorization');
        }
    });

    setTimeout(function() {
        map.setCenter({
            lat: latitude,
            lng: longitude
        });
        $('#preloader').fadeOut();
        $('.preload-hide').show();
        $('#map').css({
            'width': '100%',
            'height': '100%'
        });

        if (typeof fbId === 'undefined') {
            setTimeout(function() {
                toastr.warning('Please authorize with Facebook & allow location access to access all of the platforms features.');
            }, 3500);
        }
    }, 1000);
});

$('#post-the-ad').on('click', function(e) {
    e.preventDefault();

    $('#post-the-ad span').text('Adding…');

    $.post('library/ajax.php', {
        action: 'add',
        title: $('#title').val(),
        description: $('#description').val(),
        price: $('#price').val(),
        category: $('#category').val(),
        phone: $('#phone').val(),
        email: $('#email').val()
    }, function(response) {
        if (typeof response.errors !== 'undefined' && response.errors.length > 0) {
            $('#post-the-ad span').text('Create without errors');
            alert('Whoops: ' + response.errors[0]);
        } else {
            makeLocation(response.id);
        }
    }, 'json');
});

/* Facebook */
function statusChangeCallback(response) {
    /* do nothing */
}

/* Location creation */
var addmarkerIcon = {
    path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
    fillColor: '#29cc5a',
    fillOpacity: 1,
    scale: 2.5,
    strokeColor: '#fff',
    strokeWeight: 2,
    anchor: new google.maps.Point(12, 24)
};

function makeLocation(claddid) {
    $('#save-location').data('classified', claddid);

    $('div.si-wrapper-top').hide();
    clearOverlays();

    classifiedmarker = map.addMarker({
        lat: latitude,
        lng: longitude,
        icon: addmarkerIcon,
        draggable: true,
        setlocation: true,
        zIndex: 999999,
        dragend: function(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            $('#save-location').data('lat', lat);
            $('#save-location').data('lng', lng);
        },
        title: 'Click & drag, to confirm the location of your area!'
    });

    classifiedmarker.setZIndex(999999);

    $('#save-location').show();
    $('.show-modal').addClass('out').removeClass('show-modal in');
    $('#modals').removeClass('show-modals');

    setTimeout(function() {
        $('.lean-modal').removeClass('out');
    }, 600);
    map.panTo(classifiedmarker.getPosition());
}
$('#save-location').on('click', function(e) {
    e.preventDefault();
    $.post('library/ajax.php', {
        action: 'location',
        classified: $(this).data('classified'),
        lat: $(this).data('lat'),
        lng: $(this).data('lng')
    }, function(response) {
        if (response.result == 'success') {
            window.location.href = fullAddress;
        }
    }, 'json');
});

/* Custom functions */
function clearOverlays() {
    if (typeof allMarkers != 'undefined') {
        for (var i = 0; i < allMarkers.length; i++)
            allMarkers[i].setMap(null);
        allMarkers.length = 0;
    }
}

function strip(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}