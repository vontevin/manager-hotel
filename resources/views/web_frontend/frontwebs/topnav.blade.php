
<!--header-->
<body>
    <header id="site-header" class="fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <h1>
                    <a class="navbar-brand" href="{{url('home')}}">
                        <span>{{trans('menu.h')}}</span>{{trans('menu.otel')}}
                    </a>
                </h1>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa icon-expand fa-bars"></span>
                    <span class="fa icon-close fa-times"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ url('home') }}">{{ trans('menu.home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('room') ? 'active' : '' }}" href="{{ url('room') }}">{{ trans('menu.room') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('about*') ? 'active' : '' }}" href="{{ url('about') }}">{{ trans('menu.about') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('service*') ? 'active' : '' }}" href="{{ url('service') }}">{{ trans('menu.services') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('contact*') ? 'active' : '' }}" href="{{ url('contact') }}">{{ trans('menu.contact') }}</a>
                        </li>
                    </ul>                    
                    
                    <ul class="navbar-nav search-right mt-lg-0 mt-2">
                        @guest
                            <!-- Display REGISTER/LOGIN button only for guests (not logged-in users) -->
                            <li class="nav-item">
                                <a href="{{ url('register') }}" class="btn btn-primary d-none d-lg-block btn-style mr-2">{{ trans('menu.signup_login') }}</a>
                            </li>                            
                        @endguest
                        <li role="presentation" class="dropdown">
                            <?php  
                                $flag = app()->getLocale();
                                if ($flag == "en") {
                                    $flag = "us";
                                }
                            ?>
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img id="current-flag" style="min-width: 40px; height: 40px;" src="{{ asset('assets/production/images/'.$flag.'.png') }}">
                            </a>
                            <ul id="menu1" class="dropdown-menu dropdown-usermenu pull-right" role="menu">
                                <!-- Label for language change dropdown -->
                                <li class="dropdown-header">{{ trans('menu.change_language') }}</li>
                        
                                <!-- Khmer language option -->
                                <li class="{{ session('locale') == 'kh' ? 'active' : '' }}">
                                    <a href="{{ url('lang/kh') }}" class="user-profile">
                                        <img src="{{ asset('assets/production/images/kh.png') }}" alt="Khmer Flag"> {{ trans('menu.khmer') }}
                                    </a>
                                </li>
                        
                                <!-- English language option -->
                                <li class="{{ session('locale') == 'en' ? 'active' : '' }}">
                                    <a href="{{ url('lang/en') }}" class="user-profile">
                                        <img src="{{ asset('assets/production/images/FlagEnglish.png') }}" alt="English Flag"> {{ trans('menu.english') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="navbar-nav">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-left: 32px;">
                                @if (Auth::check())
                                    @php
                                        $user = Auth::user();
                                        $nameParts = explode(' ', $user->name);  // Split the name by space
                                        $initials = strtoupper(substr($nameParts[0], 0, 2));  // Get first 2 characters of the first name
                                    @endphp
                                    <div style="width: 42px; height: 42px; border-radius: 50%; background-color: #4CAF50; color: white; display: flex; align-items: center; justify-content: center;">
                                        {{ $initials }}
                                    </div>
                                    <span class="user-name">{{ $user->name }}</span>
                                    {{-- <span class="fa fa-angle-down"></span> --}}
                                @else
                                    <!-- Optional: Display something if the user is not logged in -->
                                @endif
                            </a>
                            
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                @if (Auth::check())
                                    <li>
                                        <a href="{{ route('logout') }}" 
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out"></i> Log Out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @endif

                                <!-- Cancel Option -->
                                <li>
                                    <a href="javascript:;" onclick="closeDropdown();">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</body>

{{-- <script>
    function changeFlag(language) {
        // Change the flag image on the navbar based on the selected language
        let flagSrc = '';
        if (language === 'kh') {
            flagSrc = '{{ asset('assets/production/images/kh.png') }}';
        } else if (language === 'us') {
            flagSrc = '{{ asset('assets/production/images/us.png') }}';
        }
        // Update the navbar flag
        document.getElementById('current-flag').src = flagSrc;
    }
</script> --}}
<!--/header-->