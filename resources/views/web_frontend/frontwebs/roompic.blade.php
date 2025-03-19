@extends('web_frontend.master_web.fornt_master')

@section('ROOM', trans('room.title'))

@push('custom-css')
    <link rel="stylesheet" href="{{ asset('css/hotel.css') }}">
    <link rel="stylesheet" href="{{ asset('hotel/css/roompic.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('hotel/css/style-starter.css') }}">
@endpush

@section('content')
    <!-- main-slider -->
    @include('web_frontend.frontwebs.main_slider')
    <!-- //banner-slider-->

    <div class="title-content text-center">
        <br/>
        <h6 class="sub-title title-with-lines">{{ trans('menu.welcome') }}</h6>
        <h3 class="hny-title">{{ trans('menu.explore_rooms') }}</h3>
        <p class="fea-para">{{ trans('menu.comfort_elegance') }}</p>
    </div>    
    <div class="contai container">
        <!-- Left Column: Search Form -->
        <div class="filter-sidebar">
            <h2 class="title-with-lines">{{ trans('menu.search') }}</h2>
            <!-- Search Form -->
            <form action="{{ route('search.rooms') }}" method="GET" class="booking-form">
                @csrf
                
                <!-- Minimum Price Filter -->
                <label for="min_price">{{ trans('menu.min_price') }}:</label>
                <select id="min_price" name="min_price">
                    <option value="">{{ trans('menu.allPrice') }}</option>
                    @foreach ($roomtypes->unique('price') as $roomtype)
                        <option value="{{ $roomtype->price }}" {{ request('min_price') == $roomtype->price ? 'selected' : '' }}>
                            @php
                                $currency = session('currency', 'USD'); // Default to USD if no currency is set
                                $exchangeRate = 4100; // Example exchange rate
                            @endphp
                            @if ($currency == 'KHR')
                                {{ number_format($roomtype->price * $exchangeRate) }} ៛
                            @else
                                ${{ $roomtype->price }}
                            @endif
                        </option>
                    @endforeach
                </select>
                
            
                <!-- Bedroom Filter -->
                <label for="name">{{ trans('menu.nameOfRoom') }}:</label>
                <select name="name" id="name" class="form-control">
                    <option value="">{{ trans('menu.allRoom') }}</option>
                    @foreach ($roomtypes as $roomtype)
                        <option value="{{ $roomtype->name }}" {{ request('name') == $roomtype->name ? 'selected' : '' }}>
                            {{ $roomtype->name }}
                        </option>
                    @endforeach
                </select>        
            
                <!-- Children Filter -->
                <label for="children">{{ trans('menu.maxChildren') }}:</label>
                <select id="children" name="children" class="form-control">
                    <option value="">{{ trans('menu.selectChildren') }}</option>
                    @for ($i = 0; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('children') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>

                <!-- Adults Filter -->
                <label for="adult">{{ trans('menu.maxAdult') }}:</label>
                <select id="adult" name="adult" class="form-control">
                    <option value="">{{ trans('menu.selectAdult') }}</option>
                    @for ($i = 1; $i <= 5; $i++) <!-- Adjust the range as per your needs -->
                        <option value="{{ $i }}" {{ request('adult') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>                

                <!-- Check-in Date -->
                <label for="checkin">{{ trans('menu.check_in_date') }}:</label>
                <input type="date" name="check_in" value="{{ Request::get('check_in') }}" class="form-control">

                <!-- Check-out Date -->
                <label for="checkout">{{ trans('menu.check_out_date') }}:</label>
                <input type="date" name="check_out" value="{{ Request::get('check_out') }}" class="form-control">

            
                <!-- Submit Button -->
                <button type="submit">{{ trans('menu.search') }}</button>
                <a href="{{ url('room') }}" class="btn btn-primary"><i class="fa fa-refresh"></i> {{ trans("menu.reset") }}</a>
            </form><br>
            
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d62109.744935335955!2d103.8446552!3d13.3590386!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31101793f90791a9%3A0xa0a136c3870c4!2sVATHANAK%20REASEY%20HOTEL!5e0!3m2!1sen!2skh!4v1735118320296!5m2!1sen!2skh" 
                width="270" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <!-- Right Column: Hotel List -->
        <div class="hotel-list">
            <!-- Alert for session messages -->
            @if (session('alert'))
                <div class="alert alert-warning">
                    {{ session('alert') }}
                </div>
            @endif
            @foreach ($roomtypes as $roomtype)
                <!-- Ensure the roomtype has rooms and the room's status is not 'maintenance' -->
                @foreach ($roomtype->rooms as $room)
                    @if (optional($room)->status !== 'maintenance')
                        <!-- Hotel Cards -->
                        <div class="hotel-card">
                            <img src="{{ Storage::url($roomtype->image) }}" alt="{{ $roomtype->name }}">
                            <div class="hotel-info-container">
                                <!-- Left Column: Hotel Details -->
                                <div class="hotel-details">
                                    <h3>{{ $roomtype->name }}</h3>
                                    <span class="rating">{{ trans('menu.rating', ['rating' => '8.5']) }}</span>
                                    <p>{{ Str::limit($roomtype->description, 35) }}</p>
                                    
                                    <!-- Icons for hotel amenities -->
                                    <div class="amenities-icons">
                                        @foreach ($roomtype->amenities->take(4) as $amenity)
                                            <div class="amenity-item">
                                                <!-- Display Icon Based on Amenity Name -->
                                                @if($amenity->name == 'WiFi')
                                                        <i class="fas fa-wifi"></i>
                                                        @elseif($amenity->name == 'Bathtub')
                                                            <i class="fas fa-bath"></i>
                                                        @elseif($amenity->name == 'Minibar')
                                                            <i class="fas fa-glass-martini-alt"></i>
                                                        @elseif($amenity->name == 'Air Conditioning')
                                                            <i class="fas fa-fan"></i>
                                                        @elseif($amenity->name == 'Refrigerator')
                                                            <i class="fas fa-ice-cream"></i>
                                                        @elseif($amenity->name == 'Restaurant')
                                                            <i class="fas fa-utensils"></i>
                                                        @elseif($amenity->name == 'Swimming Pool')
                                                            <i class="fas fa-swimmer"></i>
                                                        @elseif($amenity->name == 'Gym')
                                                            <i class="fas fa-dumbbell"></i>
                                                        @elseif($amenity->name == 'Parking')
                                                            <i class="fas fa-parking"></i>
                                                        @elseif($amenity->name == 'TV')
                                                            <i class="fas fa-tv"></i>
                                                        @elseif($amenity->name == 'Spa')
                                                            <i class="fas fa-spa"></i>
                                                        @elseif($amenity->name == 'Breakfast')
                                                            <i class="fas fa-coffee"></i>
                                                        @elseif($amenity->name == 'Pet Friendly')
                                                            <i class="fas fa-paw"></i>
                                                        @elseif($amenity->name == 'Shuttle Service')
                                                            <i class="fas fa-bus"></i>
                                                        @elseif($amenity->name == 'Laundry')
                                                            <i class="fas fa-tshirt"></i>
                                                        @else
                                                            <i class="fas fa-cogs"></i> 
                                                        @endif
                                                <p>{{ $amenity->name }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <br/>
                                    <a href="{{ url('viewroom', $roomtype->id) }}">
                                        <small class="more-info" style="color: red">{{ trans('menu.more_info') }}</small>
                                    </a>
                                </div>
                                
                                <!-- Right Column: Price and Booking -->
                                <div class="price-and-button">
                                    @php
                                        $currency = session('currency', 'USD'); // Default to USD if no currency is set
                                        $exchangeRate = 4100; // Example exchange rate
                                    @endphp

                                    <h3 class="price">
                                        @if ($currency == 'KHR')
                                            {{ number_format($roomtype->price * $exchangeRate) }} ៛
                                        @else
                                            ${{ $roomtype->price }}
                                        @endif
                                    </h3>

                                    <p class="price-details">Price for 1 night for adults {{ $roomtype->adult }} and children {{ $roomtype->child }} </p>
                                    @if (Auth::check())
                                        <a href="{{ url('viewroom/' . $roomtype->id) }}?check_in={{ request('check_in') }}&check_out={{ request('check_out') }}">
                                            <button class="book-now">{{ trans('menu.book_now') }}</button>
                                        </a>
                                    @else
                                        <a href="{{ url('register') }}">
                                            <button class="book-now">{{ trans('menu.book_now') }}</button>
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
    <!-- Pagination Links -->
    <div class="pagination-links">
        {{ $roomtypes->links() }}
        <p>{{ trans('menu.showing_results', ['start' => $roomtypes->firstItem(), 'end' => $roomtypes->lastItem(), 'total' => $roomtypes->total()]) }}</p>
    </div>
    <br/>

@endsection
<style>

</style>
@push('custom-scripts')
    <!-- Custom JavaScript -->
    <script src="{{ asset('hotel/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('hotel/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('hotel/js/theme-change.js') }}"></script>
    <script src="{{ asset('hotel/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('hotel/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('hotel/js/jquery.countup.js') }}"></script>
    <script src="{{ asset('hotel/js/bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Spinner code
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const passengerBtn = document.getElementById("passenger-selector-btn");
            const dropdown = document.getElementById("passenger-dropdown");
            const passengerSummary = document.getElementById("passenger-summary");
        
            // Counter elements
            const adultsCount = document.getElementById("adults-count");
            const childrenCount = document.getElementById("children-count");
            const roomsCount = document.getElementById("rooms-count");
        
            // Toggle Dropdown
            passengerBtn.addEventListener("click", (event) => {
                // Prevent default form submission
                event.preventDefault();
                dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            });
        
            // Update Summary Text
            const updateSummary = () => {
                const adults = parseInt(adultsCount.value, 10);
                const children = parseInt(childrenCount.value, 10);
                const rooms = parseInt(roomsCount.value, 10);
        
                passengerSummary.textContent = `${adults} Adult${adults !== 1 ? "s" : ""} · ${children} Child${children !== 1 ? "ren" : ""} · ${rooms} Room${rooms !== 1 ? "s" : ""}`;
            };
        
            // Increment & Decrement Functions
            const updateCount = (buttonId, countElement, increment) => {
                document.getElementById(buttonId).addEventListener("click", (event) => {
                    event.preventDefault(); // Prevent default button behavior
                    let value = parseInt(countElement.value, 10);
                    if (increment) {
                        value += 1;
                    } else if (value > 0) {
                        value -= 1;
                    }
                    countElement.value = value;
                    updateSummary();
                });
            };
        
            // Adults Counter
            updateCount("adults-increment", adultsCount, true);
            updateCount("adults-decrement", adultsCount, false);
        
            // Children Counter
            updateCount("children-increment", childrenCount, true);
            updateCount("children-decrement", childrenCount, false);
        
            // Rooms Counter
            updateCount("rooms-increment", roomsCount, true);
            updateCount("rooms-decrement", roomsCount, false);
        
            // Hide dropdown when clicking outside
            document.addEventListener("click", (e) => {
                if (!passengerBtn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = "none";
                }
            });
        });
    </script>
@endpush
