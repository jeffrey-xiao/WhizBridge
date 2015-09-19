
<script>
    $(document).ready(function () {



    }); //end document on ready

</script>

<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<style>
    html, body {
        height: 60%;
        margin: 0;
        padding: 0;
    }
    #map {
        height: 60%;
    }
</style>

</head>

<body>

        <div id="content">

            <div class="wrapper">
                <div id="map" style="width:500px; height:500px"></div>
                <div class="panel left" style="position:fixed;">
                   Welcome
                   <?php  echo $cur_user->username . '<br>';
                        echo 'Available jobs:';
                    ?>
                </div>


                <br>
                <br>
                <form action = "logout">
                    <input type="submit" value="Logout" />
                </form>
                <div class="Job Panel">
                    <table>
                        <tr>
                            <td> Jod Id </td>
                            <td> Job Name </td>
                            <td> Job Description </td>
                            <td> Job price </td>
                            <td> Job Coord </td>
                        </tr>
                    <?php foreach ($jobs as $job){ ?>
                            <tr>
                                <td> <?php echo $job->job_id; ?> </td>
                                <td> <?php echo $job->job_name; ?> </td>
                                <td> <?php echo $job->job_description; ?> </td>
                                <td> <?php echo $job->job_price; ?> </td>
                                <td> <?php echo ($job->job_latitude.",".$job->job_longitude); ?> </td> </tr>
                        <!--     echo "<tr>";
                            echo "<td> ($job->job_name) </td>";
                            echo "<td> ($job->job_description) </td>";
                            echo "<td> ($job->job_price) </td>";
                            echo "<td>(".($job->job_lat).,.($job->job_"</td>";
                            echo "</tr>"; -->
                            <?php
                        }
                    ?>
                    </table>
                <div class="panel center" id="broadcast_panel">
                    <!--Add broadcasts here-->
                </div>
            </div>
        </div>

        <script>
            var map;
            var locations = <?php echo $big_arr; ?>;

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

                loadMarkers(locations);
            }

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
            }

            function loadMarkers(locations) {
                var marker, i, infowindow;
                var bounds = new google.maps.LatLngBounds();

                for(i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        title: locations[i][0]
                    })
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            //infowindow.setContent(locations[i][0]);
                            //infowindow.open(map, marker);
                        }

                    })(marker, i));
                    bounds.extend(marker.getPosition());
                }

                map.fitBounds(bounds);
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH5DWHzRW5NK60dvJt3ak-pdCgs3zsdec&signed_in=true&callback=initMap"
                async defer>
        </script>
</body>