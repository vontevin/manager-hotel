@extends("web_frontend.master_web.fornt_master")

@section("title", "View Room")

@push("custom-css")
    <link rel="stylesheet" href="{{ asset("css/hotel.css") }}">
    <link rel="stylesheet" href="{{ asset("hotel") }}/css/viewroom.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("hotel/css/style-starter.css") }}">
@endpush


@section("content")

    @include("web_frontend.frontwebs.main_slider")

    <div class="title-content text-center" style="margin-top: 50px">
        <h6 class="sub-title title-with-lines">{{ trans("menu.best_hotel") }}</h6>
        <h3 class="hny-title">{{ trans("menu.view_hotel_room_type_detail") }}</h3>
        <p class="fea-para">{{ trans("menu.discover_our_accommodation") }}</p>
    </div>

    <div class="conta">
        <!-- Room Image Section -->
        <div class="room-image">
            <div class="carousel-container">
                <div class="carousel-images">
                    <img src="{{ Storage::url($roomType->image) }}" alt="{{ $roomType->name }}">
                    <img src="{{ asset("hotel/images/room3.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room4.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room6.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room7.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room8.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room9.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room10.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room7.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room20.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room15.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room10.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room11.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room8.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room12.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room10.jpg") }}" alt="">

                    <img src="{{ asset("hotel/images/room16.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room17.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room18.jpg") }}" alt="">
                    <img src="{{ asset("hotel/images/room19.jpg") }}" alt="">

                </div>
                <p class="prev" onclick="moveSlides(-1)">&#10094;</p>
                <p class="next" onclick="moveSlides(1)">&#10095;</p>
            </div>

            <!-- Room Facilities Section -->
            <div class="room-facilities">
                <div class="section-title">{{ $roomType->name }}</div>
                <div>
                    <p>{{ $roomType->description }}</p>
                </div>
                <br>
                Room Feature.
                <div class="facilities-icons">
                    @foreach ($roomType->amenities as $amenity)
                        <div class="facility-item">
                            @if ($amenity->name == "WiFi")
                                <i class="fas fa-wifi" aria-hidden="true" title="{{ trans("menu.wifi") }}"></i>
                            @elseif($amenity->name == "TV")
                                <i class="fas fa-tv" aria-hidden="true" title="{{ trans("menu.tv") }}"></i>
                            @elseif($amenity->name == "Coffee Maker")
                                <i class="fas fa-coffee" aria-hidden="true" title="{{ trans("menu.coffee_maker") }}"></i>
                            @elseif($amenity->name == "Bathtub")
                                <i class="fas fa-bath" aria-hidden="true" title="{{ trans("menu.bathtub") }}"></i>
                            @elseif($amenity->name == "Minibar")
                                <i class="fas fa-glass-martini-alt" aria-hidden="true"
                                    title="{{ trans("menu.minibar") }}"></i>
                            @elseif($amenity->name == "Air Conditioning")
                                <i class="fas fa-fan" aria-hidden="true" title="{{ trans("menu.air_conditioning") }}"></i>
                            @elseif($amenity->name == "Refrigerator")
                                <i class="fas fa-ice-cream" aria-hidden="true"
                                    title="{{ trans("menu.refrigerator") }}"></i>
                            @elseif($amenity->name == "Restaurant")
                                <i class="fas fa-utensils" aria-hidden="true" title="{{ trans("menu.restaurant") }}"></i>
                            @elseif($amenity->name == "Parking")
                                <i class="fas fa-parking" aria-hidden="true" title="{{ trans("menu.parking") }}"></i>
                            @elseif($amenity->name == "Swimming Pool")
                                <i class="fas fa-swimmer" aria-hidden="true" title="{{ trans("menu.swimming_pool") }}"></i>
                            @elseif($amenity->name == "Gym")
                                <i class="fas fa-dumbbell" aria-hidden="true" title="{{ trans("menu.gym") }}"></i>
                            @elseif($amenity->name == "Spa")
                                <i class="fas fa-spa" aria-hidden="true" title="{{ trans("menu.spa") }}"></i>
                            @elseif($amenity->name == "Hair Dryer")
                                <i class="fas fa-wind" aria-hidden="true" title="{{ trans("menu.hair_dryer") }}"></i>
                            @elseif($amenity->name == "Laundry")
                                <i class="fas fa-tshirt" aria-hidden="true" title="{{ trans("menu.laundry") }}"></i>
                            @elseif($amenity->name == "Safe Box")
                                <i class="fas fa-lock" aria-hidden="true" title="{{ trans("menu.safe_box") }}"></i>
                            @else
                                <i class="fas fa-concierge-bell" aria-hidden="true" title="{{ $amenity->name }}"></i>
                                <!-- Default Icon -->
                            @endif
                            <p>{{ $amenity->name }}</p>
                        </div>
                    @endforeach

                </div>
                <!-- Hotel Rules Section -->
                <div class="hotel-rules">
                    <div class="section-title">{{ trans("menu.accommodation_rules") }}</div>
                    <p>{{ trans("menu.welcome_accommodation") }}</p>
                    <ul>
                        <li>{{ trans("menu.check_in") }}: 3:00 PM - 9:00 PM</li>
                        <li>{{ trans("menu.check_out") }}: 10:30 AM</li>
                        <li>{{ trans("menu.no_pets") }}</li>
                        <li>{{ trans("menu.no_smoking") }}</li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- Sidebar Section -->
        <div class="sidebar">

            {{-- Alert Messages --}}
            @if (session("status"))
                <script>
                    Swal.fire({
                        text: "{{ session('status') }}",
                        icon: "success",
                        draggable: true
                    });
                </script>
            @elseif (session("error"))
                <script>
                    Swal.fire({
                        title: "Booking Failed!",
                        text: "{{ session('error') }}",
                        icon: "error",
                        draggable: true
                    });
                </script>
            @endif
        

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Booking Section -->
            <div class="booking-box">
                <div class="x_content">
                    <form action="{{ route("viewrooms.store") }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="first_name">First Name <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required maxlength="255" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="last_name">Last Name <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required maxlength="255" placeholder="Last Name">
                                </div>
                            </div>
                            <!-- Check-in Date -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="check_in">
                                        <i class="fas fa-calendar-check"></i> {{ trans("menu.check_in_date") }} <span style="color: red"> *</span>
                                    </label>
                                    <input type="date" class="form-control" id="check_in" name="check_in" required
                                        min="{{ now()->format('Y-m-d') }}"
                                        value="{{ request('check_in', old('check_in', $defaultCheckIn ?? '')) }}">
                                </div>
                            </div>

                            <!-- Check-out Date -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="check_out">
                                        <i class="fas fa-calendar-alt"></i> {{ trans("menu.check_out_date") }} <span style="color: red"> *</span>
                                    </label>
                                    <input type="date" class="form-control" id="check_out" name="check_out" required
                                        min="{{ now()->addDay()->format('Y-m-d') }}"
                                        value="{{ request('check_out', old('check_out', $defaultCheckOut ?? '')) }}">
                                </div>
                            </div>
                            <!-- Guest Email -->
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="email"><i class="fas fa-envelope"></i>{{ trans("menu.guest_email") }}<span style="color: red"> *</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required maxlength="255"
                                        value="{{ old("email", auth()->check() ? auth()->user()->email : "") }}"
                                        placeholder="{{ trans("menu.enter_valid_email") }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_adults"><i class="fas fa-user"></i> Adults <span style="color: red">*</span></label>
                                    <select class="form-control" id="number_of_adults" name="number_of_adults" required>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ old('number_of_adults', 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_children"><i class="fas fa-child"></i> Children</label>
                                    <select class="form-control" id="number_of_children" name="number_of_children">
                                        @for ($i = 0; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('number_of_children', 0) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>                            
                            
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Gender <span style="color: red"> *</span></label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Guest Phone -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="phone"><i class="fas fa-phone-alt"></i>{{ trans("menu.guest_phone") }}<span style="color: red"> *</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required maxlength="15" pattern="0[0-9]{8,14}" 
                                        value="{{ old("phone") }}" placeholder="{{ trans("menu.phone") }}">
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="address"><i class="fas fa-key"></i>Address <span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" id="address" name="address" required maxlength="255"
                                        value="{{ old("address") }}" placeholder="Address">
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="number_of_rooms"><i class="fas fa-key"></i> Number of Rooms <span style="color: red"> *</span></label>
                                    <select class="form-control" id="number_of_rooms" name="number_of_rooms" required>
                                        @for ($i = 1; $i <= 4; $i++) <!-- Adjust range as needed -->
                                            <option value="{{ $i }}" {{ old('number_of_rooms', 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @error('number_of_rooms') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                            </div>                                                       
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="room_type_id"><i class="fas fa-bed"></i>{{ trans("menu.room") }}<span style="color: red"> *</span></label>
                                    <select class="form-control" id="room_type_id" name="room_id" required>
                                            <option value="{{ $roomType->id }}" data-price="{{ $roomType->price }}">
                                                {{ $roomType->name }} - ${{ number_format($roomType->price, 2) }}
                                            </option>
                                    </select><br>
                                    <p id="total_price_display" style="font-size: 18px; font-weight: bold; color: green;">Total Price: $0.00</p>                                                                       
                                </div>
                            </div>
                    
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="room_number"><i class="fas fa-key"></i>{{ trans("menu.select_room_code") }}<span style="color: red"> *</span></label>
                                    <select class="form-control" id="room_id" name="room_id" required>
                                        @foreach ($roomType->rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                Room {{ $room->room_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            @auth
                                <button type="submit" class="btn btn-primary">{{ trans("menu.book_now") }}</button>
                            @endauth
                    
                            @guest
                                <p>{!! trans("menu.please_register_login", ["register_url" => route("register"), "login_url" => route("login")]) !!}</p>
                            @endguest
                        </div>
                    </form>
                    
                </div>

                <p style="color: blueviolet;">{{ trans("menu.how_to_pay") }}</p>
                <div class="payment-option" onclick="window.location='https://t.me/tevin_q'">
                    <!-- Right arrow icon -->
                    <i class="fas fa-arrow-right payment-icon-next"></i>
                    <div class="payment-method-description">
                        <span class="payment-method-title">Telegram</span>
                        <p>ទំនាក់ទំនង Booking តាមរយៈ Telegram</p>
                    </div>
                    <img class="payment-icon" src="{{ asset("images/telegram.png") }}" alt="">
                </div>
                <div class="payment-option" onclick="window.location='https://pay.ababank.com/7R8tdZ4Fc3JWYMoj7'">
                    <!-- Right arrow icon -->
                    <i class="fas fa-arrow-right payment-icon-next"></i>
                    <div class="payment-method-description">
                        <span class="payment-method-title">{{ trans("menu.aba_pay_title") }}</span>
                        <p>{{ trans("menu.aba_pay_description") }}</p>
                    </div>
                    <img class="payment-icon" src="{{ asset("images/ic_ABA-PAY_3x.png") }}" alt="ABA Pay">
                </div>
                <div class="payment-option" {{-- onclick="window.location='{{ route("payment.card", ["id" => $roomType->id ?? 1]) }}'"> --}} <!-- Right arrow icon -->
                    <i class="fas fa-arrow-right payment-icon-next"></i>
                    <div class="payment-method-description">
                        <span class="payment-method-title">{{ trans("menu.bakong_pay_title") }}</span>
                        <p>{{ trans("menu.bakong_pay_description") }}</p>
                    </div>
                    <img class="payment-icon" src="{{ asset("images/bakong.png") }}" alt="ABA Pay">
                </div>
                <div class="payment-option" {{-- onclick="window.location='{{ route("card", ["id" => $roomType->id ?? 1]) }}'"> --}} <!-- Right arrow icon -->
                    <i class="fas fa-arrow-right payment-icon-next"></i>
                    <div class="pay-text">
                        <span>{{ trans("menu.credit_debit_card") }}</span>
                        <div class="payment-image">
                            <img src="{{ asset("images/A-3Card_3x.png") }}" alt="Additional Card">
                        </div>
                    </div>
                    <img class="payment-icon" src="{{ asset("images/ic_generic_3x.png") }}" alt="Credit/Debit Card">
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
    label i {
        margin-right: 5px;
        /* Adds spacing between icon and text */
        color: #aa394b;
        /* Sets icon color */
    }
</style>

{{-- Carousel --}}
<script>
    // Carousel Slide Movement
    let currentIndex = 0;

    function moveSlides(step) {
        const imagesContainer = document.querySelector('.carousel-images');
        const totalImages = imagesContainer.children.length;

        currentIndex += step;

        if (currentIndex >= totalImages) {
            currentIndex = 0;
        } else if (currentIndex < 0) {
            currentIndex = totalImages - 1;
        }

        const translateXValue = -currentIndex * 100;
        imagesContainer.style.transform = `translateX(${translateXValue}%)`;
    }
</script>

{{-- Check-in and Check-out --}}
<script>
    document.getElementById('check_in').addEventListener('change', function() {
        const checkInDate = this.value;
        const checkOutInput = document.getElementById('check_out');
        checkOutInput.min = checkInDate;
    });
</script>

{{-- Calculate Total Price Based on Check-in and Check-out --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const checkInInput = document.getElementById("check_in");
    const checkOutInput = document.getElementById("check_out");
    const roomTypeSelect = document.getElementById("room_type_id");
    const numberOfRoomsSelect = document.getElementById("number_of_rooms");  // Add reference to number_of_rooms select
    const totalPriceDisplay = document.getElementById("total_price_display");

    function calculateTotalPrice() {
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);

        if (isNaN(checkIn) || isNaN(checkOut)) {
            totalPriceDisplay.innerText = "Total Price: $0.00";
            return;
        }

        let nights = (checkOut - checkIn) / (1000 * 60 * 60 * 24);

        if (nights <= 0) {
            totalPriceDisplay.innerText = "Total Price: $0.00";
            return;
        }

        let selectedRoomType = roomTypeSelect.options[roomTypeSelect.selectedIndex];
        let pricePerNight = parseFloat(selectedRoomType.getAttribute("data-price"));

        // Get the number of rooms selected
        let numberOfRooms = parseInt(numberOfRoomsSelect.value, 10);

        if (!isNaN(pricePerNight)) {
            let totalPrice = nights * pricePerNight * numberOfRooms; // Multiply by number of rooms
            totalPriceDisplay.innerText = `Total Price: $${totalPrice.toFixed(2)}`;
        } else {
            totalPriceDisplay.innerText = "Total Price: $0.00";
        }
    }

    // Run calculation on page load in case values are already set
    window.onload = calculateTotalPrice;

    // Trigger calculation on input changes
    checkInInput.addEventListener("change", calculateTotalPrice);
    checkOutInput.addEventListener("change", calculateTotalPrice);
    roomTypeSelect.addEventListener("change", calculateTotalPrice);
    numberOfRoomsSelect.addEventListener("change", calculateTotalPrice);  // Add event listener for number_of_rooms
});

</script>

{{-- Toggle Customer Form --}}
<script>
     function toggleCustomerForm(selectElement) {
        var existingCustomerFields = document.getElementById('existing_customer_fields');
        var newCustomerFields = document.getElementById('new_customer_fields');
        
        if (selectElement.value === 'new') {
            existingCustomerFields.style.display = 'none';
            newCustomerFields.style.display = 'block';
        } else {
            existingCustomerFields.style.display = 'block';
            newCustomerFields.style.display = 'none';
        }
    }
</script>
