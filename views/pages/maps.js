var map;
function initMap() {
    var mapOpt = {
        center: {lat: 43.47229, lng: -80.54486},
        zoom: 16
    };
    map = new google.maps.Map(document.getElementById('map'), mapOpt);
    var infoWindow = new google.maps.InfoWindow({map: map});
    var pos = mapOpt.center;
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            //infoWindow.setPosition(pos);
            //infoWindow.setContent('Location found.');
            map.setCenter(pos);

            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: 'My Location'
            });

        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
        map.setZoom(16);
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}

function loadMarkers(locations) {
    var marker, i;

    for(i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        })
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }

        })(marker, i));
    }


}