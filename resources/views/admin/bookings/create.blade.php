@extends('layouts.master_app')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
   <h3>Add New Booking</h3>
   <div class="col-md-12">
        <div class="pull-right">
            <div class="close-link">
                @if (session("status"))
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            iconColor: 'white',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 1200,
                            timerProgressBar: true,
                        })
                        Toast.fire({
                            icon: 'success',
                            title: "{{ session("status") }}",
                        })
                    </script>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small>Create Booking</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                
                <div class="x_content">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="col-md-12 col-sm-12 col-xs-12 row">
                                        <p style="font-weight: bold; font-size: 14px; color: #4472ff;">Customer Information</p>
                                        <!-- Customer Selection -->
                                        <div class="mb-3">
                                            <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                            <select name="customer_id" id="customer_id" class="form-control select2" required>
                                                <option value="">---Select Customer---</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ isset($customer_id) && $customer_id == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <br>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="mb-3">
                                                <a href="{{ route('customers.create', ['from_booking' => 1]) }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create New Customer
                                                </a>                                                
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <p style="font-weight: bold; font-size: 14px; color: #4472ff;">Booking Source</p>
                                            <div class="col-md-12 col-sm-12 col-xs-12 row">
                                                <div class="mb-3">
                                                    <label for="booking_source" class="form-label">Booking Source</label>
                                                    <select class="form-control select2" id="booking_source" name="booking_source" required>
                                                        <option value="direct" {{ old('booking_source') == 'direct' ? 'selected' : '' }}>Direct</option>
                                                        <option value="website" {{ old('booking_source') == 'website' ? 'selected' : '' }}>Website</option>
                                                        <option value="booking_com" {{ old('booking_source') == 'booking_com' ? 'selected' : '' }}>Booking.com</option>
                                                        <option value="expedia" {{ old('booking_source') == 'expedia' ? 'selected' : '' }}>Expedia</option>
                                                        <option value="airbnb" {{ old('booking_source') == 'airbnb' ? 'selected' : '' }}>Airbnb</option>
                                                        <option value="travel_agent" {{ old('booking_source') == 'travel_agent' ? 'selected' : '' }}>Travel Agent</option>
                                                        <option value="phone" {{ old('booking_source') == 'phone' ? 'selected' : '' }}>Phone</option>
                                                        <option value="walk_in" {{ old('booking_source') == 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                                                        <option value="other" {{ old('booking_source') == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div><br>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <p style="font-weight: bold; font-size: 14px; color: #4472ff;">Room Selection</p>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <!-- Check-in Date -->
                                        <div class="mb-3">
                                            <label for="check_in" class="form-label">Check-in Date <span class="text-danger">*</span></label>
                                            <input type="date" name="check_in" id="check_in" class="form-control" value="{{ old('check_in') }}" required>
                                            @error('check_in') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <!-- Check-out Date -->
                                        <div class="mb-3">
                                            <label for="check_out" class="form-label">Check-out Date <span class="text-danger">*</span></label>
                                            <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out') }}" required>
                                            @error('check_out') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div><br>
                                    </div>

                                    <!-- Room Selection -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label for="room_id" class="form-label">Room <span class="text-danger">*</span></label>
                                            <select name="room_id" id="room_id" class="form-control select2" required>
                                                <option value="">---Select Room---</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}" data-price="{{ $room->roomType->price }}" 
                                                        {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                        Room {{ $room->room_number }} - {{ $room->roomType->name }} (${{ number_format($room->roomType->price, 2) }})
                                                    </option>                                                    
                                                @endforeach
                                            </select>
                                            @error('room_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div><br>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label for="number_of_adults">Number of Adults <span class="text-danger">*</span></label>
                                            <input type="number" name="number_of_adults" id="number_of_adults" class="form-control" value="{{ old('number_of_adults') }}" required>
                                            @error('number_of_adults') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label for="number_of_children">Number of Children <span class="text-danger">*</span></label>
                                            <input type="number" name="number_of_children" id="number_of_children" class="form-control" value="{{ old('number_of_children') }}" required>
                                            @error('number_of_children') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div><br>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label for="number_of_rooms">Number of Rooms <span class="text-danger">*</span></label>
                                            <select name="number_of_rooms" id="number_of_rooms" class="form-control" required>
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <option value="{{ $i }}" {{ old('number_of_rooms') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('number_of_rooms') 
                                                <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="clearfix x_panel">
                                            <p style="font-weight: bold; font-size: 14px; color: #4472ff;">Payment Information</p>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <!-- Number of Nights -->
                                                <div class="mb-3">
                                                    <label for="number_of_nights" class="form-label">Number of Nights</label>
                                                    <input type="number" name="number_of_nights" id="number_of_nights" class="form-control" value="{{ old('number_of_nights') }}" readonly>
                                                </div>
                                            </div>                                                
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <!-- Total Price -->
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Room Price per Night</label>
                                                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" step="0.01" required>
                                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                                    <span>Room price = Room price × Number of nights</span>
                                                </div><br>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <!-- Total Price -->
                                                <div class="mb-3">
                                                    <label for="total_price" class="form-label">Total Price ($)</label>
                                                    <input type="number" name="total_price" id="total_price" class="form-control" value="{{ old('total_price') }}" step="0.01" required>
                                                    @error('total_price') <span class="text-danger">{{ $message }}</span> @enderror
                                                    <span>Total price = Room price × Number of nights</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ url('bookings') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - setting up price calculation');

        // Initialize Select2
        $('#room_id').select2();
        $('#customer_id').select2();

        // Get form elements
        const roomSelect = document.getElementById('room_id');
        const checkInDate = document.getElementById('check_in');
        const checkOutDate = document.getElementById('check_out');
        const numberOfNightsInput = document.getElementById('number_of_nights');
        const roomPriceInput = document.getElementById('price');
        const totalPriceInput = document.getElementById('total_price');

        // Function to update price calculation
        function updatePrice() {
            console.log('Updating price...');

            let nights = 0;
            let roomPrice = 0;
            let totalPrice = 0;

            try {
                const checkIn = checkInDate.value ? new Date(checkInDate.value) : null;
                const checkOut = checkOutDate.value ? new Date(checkOutDate.value) : null;

                if (checkIn && checkOut && checkOut > checkIn) {
                    nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24)); // Calculate number of nights
                }

                numberOfNightsInput.value = nights; // Set number of nights in input field

                if (roomSelect.value) {
                    const selectedOption = roomSelect.options[roomSelect.selectedIndex];
                    let priceString = selectedOption.dataset.price || "0";

                    roomPrice = parseFloat(priceString) || 0;
                    totalPrice = roomPrice * nights; // Total Price = Room Price × Number of Nights
                }
            } catch (error) {
                console.error('Error calculating price:', error);
            }

            roomPriceInput.value = roomPrice.toFixed(2);
            totalPriceInput.value = totalPrice.toFixed(2);
        }

        // Add event listeners
        $('#room_id').on('change', updatePrice); // Select2-compatible event
        checkInDate.addEventListener('change', updatePrice);
        checkOutDate.addEventListener('change', updatePrice);

        // Initial price update
        updatePrice();
    });
</script>
@endpush