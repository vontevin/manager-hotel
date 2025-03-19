
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile Picture" class="user-profile" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/production/images/user_icon.png') }}" alt="Default Profile Picture" class="img-thumbnail" width="50">
                        @endif

                        {{ Auth::user()->name }}

                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="{{route('dashbord')}}" class="user-profile dropdown-toggle"><img src="{{asset('assets')}}/production/images/cancel.png">{{trans('menu.appcancel')}}</a>
                        </li>
                        <li>
                            <a href="{{route('profile')}}" class="user-profile dropdown-toggle"><img src="{{asset('assets')}}/production/images/user_icon.png"> Profile</a>
                        </li>
                        <li>
                            <a href="{{route('change-password', Auth::id())}}" class="user-profile dropdown-toggle"><img src="{{asset('assets')}}/production/images/unlock.png"> Change Password</a>
                        </li>
                        <li>
                            <a class="dropdown-item user-profile dropdown-toggle" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    <img src="{{asset('assets')}}/production/images/logout.png">{{trans('menu.logout')}} {{ __('Logout') }}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <?php  
                        $flag = app()->getLocale();
                        if ($flag == "en") {
                            $flag = "us";
                        }
                    ?>
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img id="current-flag" src="{{ asset('assets/production/images/'.$flag.'.png') }}">
                        <!-- Remove "Translate" and use the flag as the label -->
                        <span class="fa fa-angle-down"></span>
                    </a>
                    <ul id="menu1" class="dropdown-menu dropdown-usermenu pull-right" role="menu">
                        <li class="{{ $flag == 'kh' ? 'active' : '' }}">
                            <a href="{{ url('lang/kh') }}" class="user-profile" onclick="changeFlag('kh')">
                                <img src="{{ asset('assets/production/images/kh.png') }}"> Khmer
                            </a>
                        </li>
                        <li class="{{ $flag == 'us' ? 'active' : '' }}">
                            <a href="{{ url('lang/en') }}" class="user-profile" onclick="changeFlag('us')">
                                <img src="{{ asset('assets/production/images/FlagEnglish.png') }}"> English
                            </a>
                        </li>
                    </ul>
                </li>   
                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number user-profile" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/production/images/notification.png') }}">
                        <span class="badge bg-green">{{ $recent_users_count }}</span> <!-- Recent user count -->
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <div class="col-md-12">
                            <h2 class="text-center">{{ trans('menu.notification') }}</h2>
                            <div class="x_title">
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @forelse ($bookings->take(5) as $booking)
                                    <article class="media event">
                                        <a class="pull-left date">
                                            <p class="month">{{ $booking->created_at->format('F') }}</p>
                                            <p class="day">{{ $booking->created_at->format('d') }}</p>
                                        </a>
                                        <div class="media-body">
                                            <a class="title" href="{{ route('bookings.show', ['booking' => $booking->id]) }}">
                                                {{ $booking->customer->first_name }} {{ $booking->customer->last_name }}
                                            </a>
                                            <p>{{ Str::limit('User Booking This Room: ' . $booking->customer->first_name . ' ' . $booking->customer->last_name, 50) }}</p>
                                        </div>
                                    </article>
                                @empty
                                    <p class="text-center">No recent bookings.</p>
                                @endforelse
                                <div class="text-center mt-3">
                                    <a href="javascript:;" id="loadMoreAlerts">
                                        <strong>{{ trans('menu.close') }}</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </ul>
                </li>                
            </ul>
        </nav>
    </div>
</div>
<script>
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
</script>
<!-- /top navigation -->

<script>
    function fetchGuestName(bookingId) {
    fetch(`/booking/guest-name/${bookingId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Guest Name:', data.guest_name);
            document.getElementById('guestNameDisplay').textContent = data.guest_name;
        })
        .catch(error => console.error('Error fetching guest name:', error));
}

// Example usage
fetchGuestName(1);

</script>
