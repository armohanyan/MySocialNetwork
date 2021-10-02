<nav class="navbar navbar-expand-lg navbar-light bg-light">
    @if(Auth::check())
        <a class="nav-link" href="{{ Route('user.profile',Auth::user()->username) }}"> {{Auth::user()->getNameOrUsername()}} </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    @endif  
    <div class=" justify-content-end collapse navbar-collapse" id="navbarSupportedContent">
        @if(Auth::check())
        <ul class="navbar-nav mr-auto p-2">
            <li class=" nav-item active">
                <a class="nav-link" href="{{ route('home') }} ">Status </a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  href="{{ route('user.friends', Auth::user()->username ) }}">Friends</a>
            </li>
            <form method="GET" action="{{ route('search.results') }}" class="form-inline my-2 my-lg-0">
                <input name="query" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </ul>
        @endif
        @if(Auth::check())
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ Route('user.profile',Auth::user()->username) }}"> {{Auth::user()->getNameOrUsername()}} </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.edit') }}">Update Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.signout') }}">Logout</a>
            </li>
        @else 
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.signin') }}">Login</a>
            </li>
            <li class="nav-item">   
                <a class="nav-link" href="{{ route('auth.signup') }}">Register</a>
            </li>
        </ul>
        @endif
    </div>
</nav>
