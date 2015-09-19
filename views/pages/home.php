
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

            <div class="wrapper"><div id="map" style="width:500px; height:500px"></div>
                <div class="panel left" style="position:fixed;">
                   Welcome
                   <?php  echo $cur_user->username; ?>
                </div>


                <br>
                <form action = "logout">
                    <input type="submit" value="Logout" />
                </form>


                <div class="panel center" id="broadcast_panel">
                    <!--Add broadcasts here-->
                </div>
            </div>
        </div>

        <script src="google-maps-test.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH5DWHzRW5NK60dvJt3ak-pdCgs3zsdec&signed_in=true&callback=initMap"
                async defer>
        </script>
</body>