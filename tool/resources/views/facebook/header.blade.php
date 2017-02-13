<header>
    <ul class="nav-bar">
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Youtube</a></li>
    </ul>
    <div class="toggle-menu">
        <div class="line-1"></div>
        <div class="line-2"></div>
        <div class="line-3"> </div>
    </div>
    <div class="container">
    
        @if (!empty($data) && $data->loggedIn == true)
            <a href="{{URL::full()}}/logout" class="logout">Logout</a>
        @endif

        <div class="title text-center">
            <img src="{!!url('public/images/logo_transparent.png')!!}" class="logo">
        @if (!empty($data->profile['avatar'])) 
            <img src="{{$data->profile['avatar']}}" class="logo user-logo" style="animation : dropRight 0.3s ease-out forwards {{count($data->allPage) * 0.2}}s;">
        @endif
            <h3>WELCOME TO VANMINH.XYZ</h3></div>
        </div>
</header>