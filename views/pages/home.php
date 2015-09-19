
<script>
    $(document).ready(function () {



    }); //end document on ready

</script>

</head>

<body>


        <div id="content">
            <div class="wrapper">

                <div class="panel left" style="position:fixed;">
                   Welcome
                   <?php  echo $cur_user->username; ?>
                </div>

                <input type="submit" action="logout" name="Logout" />


                <div class="panel center" id="broadcast_panel">
                    <!--Add broadcasts here-->
                </div>
            </div>
        </div>
</body>