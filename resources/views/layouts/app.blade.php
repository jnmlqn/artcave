<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@section('styles')
    @yield('styles')
@endsection
@include('includes.head', ['title' => $title ?? 'ARTCAVE'])
<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light border"  style="z-index: 1">
            <a class="navbar-brand" href="/backend/dashboard"><img loading="lazy" src="/img/logo.png" width="100px"></a>
            @auth
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item @if (Request::is('backend/dashboard')) active @endif">
                        <a class="nav-link" href="/backend/dashboard">HOME</a>
                    </li>
                    <li class="nav-item @if (Request::is('backend/users')) active @endif">
                        <a class="nav-link" href="/backend/users">USERS</a>
                    </li>
                    <li class="nav-item @if (Request::is('backend/artists*')) active @endif">
                        <a class="nav-link" href="/backend/artists">ARTISTS</a>
                    </li>
                    <li class="nav-item @if (Request::is('backend/art-pieces*') || Request::is('backend/categories*')) active @endif">
                        <a class="nav-link" href="/backend/art-pieces">ART PIECES</a>
                    </li>
                    <li class="nav-item @if (Request::is('backend/promos-and-events*')) active @endif">
                        <a class="nav-link" href="/backend/promos-and-events">PROMOS & EVENTS</a>
                    </li>
                    <li class="nav-item @if (Request::is('backend/media*')) active @endif">
                        <a class="nav-link" href="/backend/media">MEDIA</a>
                    </li>
                    <li class="nav-item @if (Request::is('backend/menus*')) active @endif">
                        <a class="nav-link" href="/backend/menus">MENU</a>
                    </li>
                    <li class="nav-item @if (Request::is('backend/subscribers*')) active @endif">
                        <a class="nav-link" href="/backend/subscribers">SUBSCRIBERS</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item pointer" id="change_password">
                                Change Password
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>                    
                </ul>
                @endauth
            </div>
        </nav>

        <br><br><br>
        <main class="py-4 pr-4 pl-4">
            @yield('content')
        </main>
    </div>
</body>
<script type="text/javascript" src="/public/js/changepass.js"></script>
</html>
