// - - - - - - - - - - -  Fastclick  - - - - - - - - - - -
window.addEventListener('load', function() {
    FastClick.attach(document.body);
}, false);
document.addEventListener("touchstart", function(){}, true);

Dropzone.autoDiscover = false;
var map;
$(document).ready(function(){
    // IMG UPLOAD
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
                    if (window.location.hash && $(window.location.hash+'.lean-modal').length) {
                        open_modal(window.location.hash);
                    }
                }
                else {
                    close_all_modals();
                }
            }
            return this.each(function() {
                if (window.location.hash && $(window.location.hash+'.lean-modal').length) {
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
    $('#signup-agree').change(function(){
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
        lat: 56.946618,
        lng: 24.097274,
        zoom: 9,
        styles: [
            {
                "featureType": "all",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "saturation": 36
                    },
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 40
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 16
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 17
                    },
                    {
                        "weight": 1.2
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#c4c4c4"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#707070"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 21
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#be2026"
                    },
                    {
                        "lightness": "0"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    },
                    {
                        "hue": "#ff000a"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 18
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#575757"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#2c2c2c"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 16
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#999999"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "saturation": "-52"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 19
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#000000"
                    },
                    {
                        "lightness": 17
                    }
                ]
            }
        ]
    });

    var markerIcon = {
        path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
        fillColor: '#222',
        fillOpacity: 0.95,
        scale: 1.5,
        strokeColor: '#fff',
        strokeWeight: 2,
        anchor: new google.maps.Point(12, 24)
    };

    var quarantineIcon = {
        path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
        fillColor: '#222',
        fillOpacity: 0.95,
        scale: 1.5,
        strokeColor: '#972727',
        strokeWeight: 2,
        anchor: new google.maps.Point(12, 24)
    };

    var allMarkers = [];

    $.post('library/ajax.php', {
        action: 'retrieve',
        category: category
    }, function(results) {
        var items = [], markers_data = [];
        if (results.classifieds.length > 0) {
            items = results.classifieds;
            for (var i = 0; i < items.length; i++) {
                var item = items[i];

                if (item.latitude != undefined && item.longitude != undefined) {
                    markers_data.push({
                        id : item.id,
                        lat : item.latitude,
                        lng : item.longitude,
                        title : item.title,
                        icon : markerIcon,
                        description : item.description,
                        price : item.price,
                        gallery : item.gallery,
                        subtitle : item.subtitle,
                        url : fullAddress + '?id=' + item.id
                    });
                }
            }
        }
        allMarkers = map.addMarkers(markers_data);
    }, 'json');

    $.get('json_data.php', function (results) {
        const randomDisplacement = () => Math.round(Math.random() * 1000 - 500) / 100000;
        const markers = results.map(item => ({
            id: item.id,
            lat: item.selfCooLat * 1 + randomDisplacement(),
            lng: item.selfCooLng * 1 + randomDisplacement(),
            title: item.origin,
            icon: quarantineIcon,
            description: item.descriptionTitle,
            price: undefined,
            gallery: undefined,
            subtitle: item.label,
            url: fullAddress + '?id=' + item.id
        }));
        allMarkers = allMarkers.concat(map.addMarkers(markers));
    }, 'json');

    map.on('marker_added', function (marker) {
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
                content: '<div>'+marker.title+'</div>',
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
        }
        else { // Marker coming from database
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
                content: '<div><strong>'+strip(marker.title)+'</strong></div>' +
                '<div>'+strip(marker.description)+'</div>',
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

    /*map.setContextMenu({
    control: 'map',
    options: [{
    title: 'Pievienot sludinājumu',
    name: 'add_marker',
    action: function(e) {
    this.addMarker({
    lat: e.latLng.lat(),
    lng: e.latLng.lng(),
    title: 'Jauns sludinājums'
});
}
}, {
title: 'Centrēt šeit',
name: 'center_here',
action: function(e) {
this.setCenter(e.latLng.lat(), e.latLng.lng());
}
}]
});*/

map.addControl({
    position: 'top_right',
    content: 'My location',
    style: {
        margin: '5px',
        padding: '1px 6px',
        border: 'solid 1px #717B87',
        background: '#fff'
    },
    events: {
        click: function(){
            GMaps.geolocate({
                success: function(position){
                    map.setCenter(position.coords.latitude, position.coords.longitude);
                },
                error: function(error){
                    alert('Error: ' + error.message);
                },
                not_supported: function(){
                    alert("Your browser doesn't support this function.");
                }
            });
        }
    }
});

GMaps.geolocate({
    success: function(position){
        map.setCenter(position.coords.latitude, position.coords.longitude);
    },
    error: function(error){
        map.setZoom(9);
    },
    not_supported: function(){
        alert("Your browser doesn't support this function.");
        map.setZoom(9);
    }
});

$('.login-fb').on('click', function(e){
    e.preventDefault();
    FB.login(function(response) {
        if (response.status === 'connected') {
            window.location.reload();
        } else if (response.status === 'not_authorized') {
            alert('We had an error authorising you. If the problem persists, contact us via info@pandemic.lv');
        } else {
            alert('We had an error authorising you. If the problem persists, contact us via info@pandemic.lv');
        }
    }, {scope: 'email,public_profile'});
});
});

$('#post-the-ad').on('click', function(e){
    e.preventDefault();

    $('#post-the-ad span').text('Adding…');

    $.post('library/ajax.php', {
        action:'add',
        title:$('#title').val(),
        description:$('#description').val(),
        price:$('#price').val(),
        category:$('#category').val(),
        phone:$('#phone').val(),
        email:$('#email').val()
    }, function(response){
        if (typeof response.errors !== 'undefined' && response.errors.length > 0) {
            $('#post-the-ad span').text('Create without errors');
            alert('Whoops: '+response.errors[0]);
        } else {
            makeLocation(response.id);
        }
    }, 'json');
});

/* Facebook */
function statusChangeCallback(response) { /* do nothing */ }

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
        lat: 56.946618,
        lng: 24.097274,
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
$('#save-location').on('click', function(e){
    e.preventDefault();
    $.post('library/ajax.php', {
        action: 'location',
        classified: $(this).data('classified'),
        lat: $(this).data('lat'),
        lng: $(this).data('lng')
    }, function(response){
        if (response.result == 'success') {
            window.location.href = fullAddress;
        }
    }, 'json');
});

/* Custom functions */
function clearOverlays() {
    for (var i = 0; i < allMarkers.length; i++)
    allMarkers[i].setMap(null);
    allMarkers.length = 0;
}

function strip(html) {
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent || tmp.innerText || "";
}
