
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
                <div id="map" style="width:860px; height:800px"></div>

                <div class="Job Panel" style="margin: 0 auto; text-align: center">
                    <?php
                    echo '<h2>Welcome ' . $cur_user->username . '!</h2>';
                    ?>
                    <table style="margin: 0 auto">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Coordinates</th>
                        </tr>
                    <?php foreach ($jobs as $job){ ?>
                            <tr>
                                <td> <?php echo $job->job_id; ?> </td>
                                <td> <?php echo $job->job_name; ?> </td>
                                <td> <?php echo $job->job_description; ?> </td>
                                <td> <?php echo "$".$job->job_price; ?> </td>
                                <td> <?php echo "(".$job->job_latitude.",".$job->job_longitude.")"; ?> </td> </tr>
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
                    <br> <br>
                    <form action = "logout">
                        <input type="submit" value="Log Out" />
                    </form>
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
                    zoom: 6
                };
                map = new google.maps.Map(document.getElementById('map'), mapOpt);
                var infoWindow;
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
                            title: 'My Location',
                            icon: 'resources/home.png'
                        });

                    }, function() {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                    map.setZoom(6);
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
                var i;
                var markers = [];
                var infowindows = [];
                var bounds = new google.maps.LatLngBounds();

                for(i = 0; i < locations.length; i++) {
                    if (!locations[i][7] || !locations[i][8]) {
                        markers.push(new google.maps.Marker({
                            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                            map: map,
                            title: locations[i][0]
                        }));
                        /*google.maps.event.addListener(marker, 'click', (function(marker, i) {
                            return function() {
                                infowindow.setContent(locations[i][0]);
                                infowindow.open(map, marker);
                            }

                        })(marker, i));
                        infowindows.push(new google.maps.InfoWindow({
                        content: locations[i][0]
                        }));
                        markers[i].addListener('click', function() {
                        infowindows[i].open(map, markers[i]);
                        });*/
                        var infowindow = new google.maps.InfoWindow({
                            content: locations[i][0],
                            position: new google.maps.LatLng(locations[i][1], locations[i][2])
                        });
                        (function(){
                            var name = locations[i][0];
                            var desc = locations[i][3];
                            var jid = locations[i][4];
                            var price = locations[i][5];
                            var m = markers[i];
                            // console.log(jid + " " + locations[i][6]);
                            var content = "";
                            if (locations[i][6]) {
                                if (locations[i][7])
                                    content = ('<p> Name: ' + name + '</p>'+
                                        '<p> Desc: ' + desc + '</p>' +
                                        '<p> Price: ' + price + '</p>' +
                                    '<p>Waiting for buyer confirmation</p>');
                                else
                                    content = ('<p> Name: ' + name + '</p>'+
                                        '<p> Desc: ' + desc + '</p>' +
                                        '<p> Price: ' + price + '</p>' +
                                        '<button onclick=completeWhizJob('+jid+')>Complete Job!</button>' +
                                        '<button onclick=cancelWhizJob('+jid+')>Cancel Job!</button>');
                            } else {
                                content = ('<p> Name: ' + name + '</p>'+
                                    '<p> Desc: ' + desc + '</p>' +
                                    '<p> Price: $' + price + '</p>' +
                                    '<button onclick=takeJob('+jid+')>Take Job!</button>');
                            }
                            google.maps.event.addListener(m, 'click', function() {
                                // map.setZoom(12);
                                // map.setCenter(m.getPosition());
                                infowindow.setContent(content);

                                // TODO!!!!! MAKE THIS ONCLICK
                                infowindow.open(map, this);

                            });
                        }()) // closure inclusion
                        //console.log('info windows yo' + i);
                        bounds.extend(markers[i].getPosition());
                    }
                }

                map.fitBounds(bounds);
            }
            function completeWhizJob (job_id) {
                $.ajax({
                    type: "POST",
                    url: '/completeWhizJob',
                    data: {job_id},
                    cache: false,

                    success: function (html) {
                        // console.log(job_id);
                        if( html == "true" ){
                            window.location.reload();
                        } else {
                            //catch error here
                        }
                    }
                });
            }
            function cancelWhizJob (job_id) {
                $.ajax({
                    type: "POST",
                    url: '/cancelWhizJob',
                    data: {job_id},
                    cache: false,

                    success: function (html) {
                        // console.log(job_id);
                        if( html == "true" ){
                            window.location.reload();
                        } else {
                            //catch error here
                        }
                    }
                });
            }
            function takeJob(job_id){
                $.ajax({
                    type: "POST",
                    url: '/takeJob',
                    data: {job_id},
                    cache: false,

                    success: function (html) {
                        if( html == "true" ){
                            window.location.reload();
                        } else {
                            //catch error here
                        }
                    }
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH5DWHzRW5NK60dvJt3ak-pdCgs3zsdec&signed_in=true&callback=initMap"
                async defer>
        </script>
</body>