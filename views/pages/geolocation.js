//BROKEN DUE TO MAGIC
function initMap() {
    var mapOpt = {
        center: {lat: 43.47229, lng: -80.54486},
        zoom: 16
    };
    var map = new google.maps.Map(document.getElementById('map'), mapOpt);
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