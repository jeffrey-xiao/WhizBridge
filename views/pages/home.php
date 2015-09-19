
<script>
    $(document).ready(function () {



    }); //end document on ready

</script>

</head>

<body>

<div id="map" style="height:400px; width:500px;"></div>
        <div id="content">
            <div class="wrapper">

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

        <script src="geolocation.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH5DWHzRW5NK60dvJt3ak-pdCgs3zsdec&signed_in=true&callback=initMap">
        </script>
</body>