<!-- main-slider -->
<section class="w3l-main-slider position-relative" id="home">
    <div class="companies20-content">
        <div class="owl-one owl-carousel owl-theme">
            <!-- Slider Item 1 -->
            <div class="item">
                <li>
                    <div class="slider-info banner-view"
                        style="background: url('{{ asset("hotel/images/room20.jpg") }}') no-repeat center; background-size: cover;">
                        <div class="banner-info">
                            <div class="container">
                                <div class="banner-info-bg">
                                    {{-- <h5>Your Comfort is Our Priority.<br> Experience Luxury.</h5> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </div>
            <!-- Slider Item 2 -->
            <div class="item">
                <li>
                    <div class="slider-info banner-view banner-top1"
                        style="background: url('{{ asset("hotel/images/room15.jpg") }}') no-repeat center; background-size: cover;">
                        <div class="banner-info">
                            <div class="container">
                                <div class="banner-info-bg">
                                    {{-- <h5>Exceptional Service for Your Stay.</h5> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </div>
            <!-- Slider Item 3 -->
            <div class="item">
                <li>
                    <div class="slider-info banner-view banner-top2"
                        style="background: url('{{ asset("images/hotel5.jpg") }}') no-repeat center; background-size: cover;">
                        <div class="banner-info">
                            <div class="container">
                                <div class="banner-info-bg">
                                    {{-- <h5>Luxury Accommodations Await You.</h5> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </div>
            <!-- Slider Item 4 -->
            <div class="item">
                <li>
                    <div class="slider-info banner-view banner-top3"
                        style="background: url('{{ asset("images/hotel2.jpg") }}') no-repeat center; background-size: cover;">
                        <div class="banner-info">
                            <div class="container">
                                <div class="banner-info-bg">
                                    {{-- <h5>Honest Service for Your Hotel Stay.</h5> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </div>
        </div>
    </div>
    @if (!Request::is("about*") && !Request::is("service*") && !Request::is("contact*") && !Request::is("viewroom/*"))
        <!-- Hotel Search Container (Centered below the slider) -->
        <div class="hotel-search-container card"
            style="background: rgba(255, 255, 255, 0.9); padding: 20px; border-radius: 10px; 
            display: flex; justify-items: center; top: -130px; width: 90%; z-index: 10;">
            <div class="hotel-search-form">
                <form action="{{ route("search.rooms") }}" method="GET"
                    style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
                    @csrf
                    <!-- Location -->
                    <div class="form-group">
                        <label for="location" style="margin-left: 2px;"><i
                                class="fas fa-map-marker-alt"></i>{{ trans("menu.location") }}</label>
                        <div class="location-container">
                            <input type="text" id="location" name="location" value="{{ trans("menu.siem_reap") }}"
                                placeholder="{{ trans("menu.enter_location") }}" class="form-control" required>
                        </div>
                    </div>

                    <!-- Check-In Date -->
                    <div class="form-group">
                        <label for="check-in"><i class="fas fa-calendar-check"></i>{{ trans("menu.checkin_date") }}</label>
                        <input type="date" name="check_in" value="{{ Request::get('check_in') }}" class="form-control" required>
                    </div>

                    <!-- Check-Out Date -->
                    <div class="form-group">
                        <label for="check-out"><i class="fas fa-calendar-alt"></i>{{ trans("menu.checkout_date") }}</label>
                        <input type="date" name="check_out" value="{{ Request::get('check_out') }}" class="form-control" required>
                    </div>

                    <!-- Passenger Counter -->
                    <div class="passenger-counter-container" style="margin-top: 12px;">
                        <button id="passenger-selector-btn" class="passenger-btn" type="button">
                            <i class="fas fa-user"></i>
                            <span id="passenger-summary">1 {{ trans("menu.adults") }} · 0 {{ trans("menu.children") }}
                                · 0 {{ trans("menu.room") }}</span>
                        </button>
                        <!-- Dropdown Content for Filter -->
                        <div id="passenger-dropdown" class="passenger-dropdown">
                            <!-- Adults Counter -->
                            <div class="counter-group">
                                <label for="adults">{{ trans("menu.adults") }}</label>
                                <div class="counter-controls">
                                    <button class="decrement-btn" id="adults-decrement" type="button">-</button>
                                    <input type="number" id="adults-count" name="adults"
                                        value="{{ Request::get("adults", 1) }}" min="1" readonly>
                                    <button class="increment-btn" id="adults-increment" type="button">+</button>
                                </div>
                            </div>

                            <!-- Children Counter -->
                            <div class="counter-group">
                                <label for="child">{{ trans("menu.children") }}</label>
                                <div class="counter-controls">
                                    <button class="decrement-btn" id="children-decrement" type="button">-</button>
                                    <input type="number" id="children-count" name="child"
                                        value="{{ Request::get("child", 0) }}" min="0" readonly>
                                    <button class="increment-btn" id="children-increment" type="button">+</button>
                                </div>
                            </div>

                            <!-- Rooms Counter -->
                            <div class="counter-group">
                                <label for="rooms">{{ trans("menu.room") }}</label>
                                <div class="counter-controls">
                                    <button class="decrement-btn" id="rooms-decrement" type="button">-</button>
                                    <input type="number" id="rooms-count" name="rooms" value="1"
                                        min="1" readonly>
                                    <button class="increment-btn" id="rooms-increment" type="button">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary"
                        style="width: 100%; background-color: #a85808; color: #f7f7f7">
                        <i class="fas fa-search"></i> {{ trans("menu.checkAvailability") }}
                    </button>
                </form>
            </div>
        </div>
    @endif
</section>

<style>
    label i {
        margin-right: 5px;
        /* Adds spacing between icon and text */
        /* Sets icon color */
    }

    .location-container {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .location-container i {
        font-size: 18px;
        color: #333;
    }

    .location-container input {
        width: 100%;
        padding-left: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
    }

    /* General Container */
    .hotel-search-container {
        margin-bottom: -70px;
        /* Adjust as necessary */
    }

    .passenger-counter-container {
        position: relative;
        width: 300px;
        font-family: Arial, sans-serif;
    }

    .passenger-btn {
        width: 100%;
        padding: 10px 15px;
        background: #f7f7f7;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        text-align: left;
        display: flex;
        justify-content: space-between;
    }

    .passenger-dropdown {
        display: none;
        position: absolute;
        width: 100%;
        background: white;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 10px;
        z-index: 1000;
    }

    .counter-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .counter-controls {
        display: flex;
        align-items: center;
    }

    .increment-btn,
    .decrement-btn {
        width: 30px;
        height: 30px;
        border: 1px solid #ddd;
        background-color: #f0f0f0;
        text-align: center;
        font-size: 18px;
        cursor: pointer;
        border-radius: 50%;
    }

    .increment-btn:hover,
    .decrement-btn:hover {
        background-color: #ddd;
    }

    input[readonly] {
        width: 30px;
        border: none;
        text-align: center;
        font-size: 16px;
        margin: 0 5px;
    }

    .done-btn {
        width: 100%;
        padding: 8px;
        background-color: #0062cc;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .done-btn:hover {
        background-color: #005bb5;
    }
</style>
@push("script")
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get elements
        const adultsInput = document.getElementById("adults-count");
        const adultsIncrement = document.getElementById("adults-increment");
        const adultsDecrement = document.getElementById("adults-decrement");
    
        const childrenInput = document.getElementById("children-count");
        const childrenIncrement = document.getElementById("children-increment");
        const childrenDecrement = document.getElementById("children-decrement");
    
        const roomsInput = document.getElementById("rooms-count");
        const roomsIncrement = document.getElementById("rooms-increment");
        const roomsDecrement = document.getElementById("rooms-decrement");
    
        const passengerSummary = document.getElementById("passenger-summary");
    
        // Function to update summary text
        function updatePassengerSummary() {
            passengerSummary.innerHTML = `
                ${adultsInput.value} {{ trans("menu.adults") }} · 
                ${childrenInput.value} {{ trans("menu.children") }} · 
                ${roomsInput.value} {{ trans("menu.room") }}
            `;
        }
    
        // Function to handle counter logic
        function setupCounter(input, incrementBtn, decrementBtn, minValue = 0) {
            // Ensure default value is not below minimum
            if (!input.value || input.value < minValue) {
                input.value = minValue;
            }
    
            // Increment value
            incrementBtn.addEventListener("click", function () {
                input.value = parseInt(input.value, 10) + 1;
                updatePassengerSummary();
            });
    
            // Decrement value (but not below minValue)
            decrementBtn.addEventListener("click", function () {
                if (parseInt(input.value, 10) > minValue) {
                    input.value = parseInt(input.value, 10) - 1;
                    updatePassengerSummary();
                }
            });
        }
    
        // Set up counters for adults, children, and rooms
        setupCounter(adultsInput, adultsIncrement, adultsDecrement, 1);
        setupCounter(childrenInput, childrenIncrement, childrenDecrement, 0);
        setupCounter(roomsInput, roomsIncrement, roomsDecrement, 0);
    
        // Initialize summary on page load
        updatePassengerSummary();
    });

</script>
@endpush
