<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('routes.web.home') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('routes.web.home') }}</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home') }}">{{ __('routes.web.home') }}</a>
                            <a class="dropdown-item" href="{{ route('public.posts.index') }}">{{ __('routes.web.public.posts.index') }}</a>
                        </div>
                    </li>
                @endguest
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.posts.index') }}">{{ __('routes.web.public.posts.index') }}</a>
                    </li>
                @else
                    @can('chat')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('chat.index') }}">{{ __('routes.web.chat.index') }}</a>
                        </li>
                    @endcan
                    @can('memos')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('memos.index') }}">{{ __('routes.web.memos.index') }}</a>
                        </li>
                    @endcan
                    @can('posts')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index') }}">{{ __('routes.web.posts.index') }}</a>
                        </li>
                    @endcan
                    @can('uploads')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('uploads.index') }}">{{ __('routes.web.uploads.index') }}</a>
                        </li>
                    @endcan
                @endguest
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @hasrole('admin')
                                <h6 class="dropdown-header">{{ __('Admin') }}</h6>
                                <a class="dropdown-item" href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
                                <div class="dropdown-divider"></div>
                            @endhasrole
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
