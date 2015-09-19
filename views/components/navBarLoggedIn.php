<header>
    <div class="wrapper">

        <div id="navigation">
            <a href="/"><div class="item" id="home">Home</div></a>
            <a href="/notifications"><div class="item" id="notifications">Notifications</div></a>
            <a href="/explore"><div class="item" id="explore">Explore</div></a>
        </div>

        <div id="dropdownParent" >
             <img style="height:34px; border-radius:10px;" src="/content/pp_thumb<?php echo $cur_user->avatar_hash;?>.jpg?" onError="this.onerror=null;this.src='/resources/images/default_avatar.jpg';" >
             <img src="resources/images/dropdown.png" style = "height:15px;">
             <div id="dropdown"> <a href="/<?php echo $cur_user->username; ?>">View Profile</a><br> <a href="/settings">Settings</a><br><a href="/logout">Log Out</a></div>
        </div>

        <form id="searchForm" method="get" action="/search" class="search">
            <input id = "searchBox" name="query" type="text" size="40" placeholder="Search..." />
        </form>

        <div  id="logo">
            <a href = "/"><img src="/resources/images/whistlet_logo.svg" alt = "Whistlet Logo"></a>
        </div>

    </div>
</header>