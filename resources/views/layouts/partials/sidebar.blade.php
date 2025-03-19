  <!-- sidebar menu -->
  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
          <h3>{{trans('menu.general')}}</h3>
            <ul class="nav side-menu">
                <li>
                    @role('admin|super-admin|manager')
                        <a href="{{url('dashbord')}}"><i class="fa fa-dashboard"></i> {{ trans("menu.dashboard") }}​</span></a>
                    @endrole
                </li>
                <ul class="nav side-menu">
                    @can('role permission')
                        <li><a><i class="fa fa-user"></i> {{ trans("menu.role") }} <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                    <li>
                                        <a href="{{url('users')}}"> {{ trans("menu.users") }} </a>
                                    </li>
                                    <li>
                                        <a href="{{url('permissions')}}">{{ trans("menu.permission") }} </a>
                                    </li>
                                    <li>
                                        <a href="{{url('roles')}}">{{ trans("menu.role") }}</a>
                                    </li>
                            </ul>
                        </li>
                    @endcan
                </ul>
            </ul>
        
            <ul class="nav side-menu">
                <li>
                    <a>
                        
                        <i class="fa fa-calendar"></i> {{ trans("menu.booking") }}  <span class="badge badge-danger">{{ $websiteBookingCount }}</span>
                        <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{ url('newbookings') }}">
                                <i class="fa fa-folder"></i> New Bookings
                                @if($websiteBookingCount > 0)
                                    <span class="badge badge-danger">{{ $websiteBookingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{ url('events') }}"><i class="fa fa-calendar"></i>{{ trans("menu.calendar") }}</a></li>
                        <li><a href="{{ url('bookings') }}"><i class="fa fa-table"></i>{{ trans("menu.bookingRecord") }}</a></li>
                    </ul>
                </li>         
                <li><a><i class="fa fa-area-chart"></i> Report Hotel <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ url('reports') }}"><i class="fa fa-calendar-check-o"></i> {{ trans("menu.report") }}</a></li>
                    </ul>
                </li>                
                <li><a><i class="fa fa-money"></i> {{ trans("menu.payment") }} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{url('payments')}}"><i class="fa fa-usd"></i>{{ trans('menu.payment') }}</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-bed"></i> {{ trans("menu.roomManagement") }} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{url('rooms')}}"><i class="fa fa-bed"></i>{{ trans("menu.room") }}</a>
                        </li>
                        <li>
                            <a href="{{url('roomtypes')}}"><i class="fa fa-bed"></i>{{ trans("menu.roomType") }}</a>
                        </li>
                    </ul>
                </li>
                <li><a><i class="fa fa-lightbulb-o"></i> Amenities <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{url('amenities')}}"><i class="fa fa-lightbulb-o"></i>Amenities</a>
                        </li>
                    </ul>
                </li>
                <li><a><i class="fa fa-users"></i> Customer <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{ url('customers') }}">
                                <i class="fa fa-users"></i> Customer List
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a><i class="fa fa-users"></i> Staff <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{ url('staffs') }}"><i class="fa fa-users"></i>Staff</a>
                        </li>
                    </ul>
                </li>
                </br>
                <h3>{{ trans("menu.menu") }}</h3>
                <li><a><i class="fa fa-folder-open"></i> {{ trans("menu.webPage") }} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{url('clients')}}"><i class="fa fa-users"></i>{{ trans("menu.ouyGuest") }}</a>
                        </li>
                        <li>
                            <a href="{{url('galleries')}}"><i class="fa fa-image"></i>{{ trans("menu.gallery") }}</a>
                        </li>
                        <li>
                            <a href="{{url('packages')}}"><i class="fa fa-folder"></i>{{ trans("menu.package") }}</a>
                        </li>
                    </ul>
                </li>

                <li><a><i class="fa fa-cogs"></i> Setting<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{url('home')}}"><i class="fa fa-home"></i> Home Page</a>
                        </li>
                        <li>
                            <a href="{{ route('profile')}}"><i class="fa fa-user"></i> Profile</a>
                        <li>
                            @if (Auth::check())
                                <a href="{{ route('change-password', Auth::id()) }}"><i class="fa fa-lock"></i> Change Password</a>
                            @endif
                        
                        </li>                   
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Log Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
  <!-- /sidebar menu -->
