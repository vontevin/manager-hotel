<!-- Modal for Creating/Editing Bookings -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-calendar-check"></i> Create/Edit Booking</h4>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="form-group">
                        <label for="customer_id"><i class="fas fa-user"></i> Customer:</label>
                        <select class="form-control select2" id="customer_id" name="customer_id" required>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_id"><i class="fas fa-key"></i> Room:</label>
                        <select class="form-control select2" id="room_id" name="room_id" required>
                            <option value="">---Select Room---</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" data-price="{{ $room->roomType->price }}">
                                    Room {{ $room->room_number }} - {{ $room->roomType->name }} (${{ number_format($room->roomType->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="check_in"><i class="fas fa-calendar-check"></i> Check-In Date:</label>
                        <input type="date" name="check_in" id="check_in" class="form-control" value="{{ old('check_in') }}" required>
                        @error('check_in') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="check_out"><i class="fas fa-calendar-times"></i> Check-Out Date:</label>
                        <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out') }}" required>
                        @error('check_out') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="number_of_guests"><i class="fas fa-users"></i> Number of Guests:</label>
                        <input type="number" class="form-control" id="number_of_guests" name="number_of_guests" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="number_of_nights" class="form-label">Number of Nights</label>
                        <input type="number" name="number_of_nights" id="number_of_nights" class="form-control" value="{{ old('number_of_nights') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="price"><i class="fas fa-dollar-sign"></i> Room Price per Night:</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="total_price"><i class="fas fa-dollar-sign"></i> Total Price ($):</label>
                        <input type="number" class="form-control" id="total_price" name="total_price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="status"><i class="fas fa-clipboard-check"></i> Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="confirmed">Confirmed</option>
                            <option value="pending">Pending</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="booking_source"><i class="fas fa-external-link-alt"></i> Booking Source:</label>
                        <select class="form-control" id="booking_source" name="booking_source" required>
                            <option value="direct">Direct</option>
                            <option value="website">Website</option>
                            <option value="booking_com">Booking.com</option>
                            <option value="expedia">Expedia</option>
                            <option value="airbnb">Airbnb</option>
                            <option value="travel_agent">Travel Agent</option>
                            <option value="phone">Phone</option>
                            <option value="walk_in">Walk-in</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description"><i class="fas fa-info-circle"></i> Description:</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="deleteEventBtn"><i class="fas fa-trash-alt"></i> Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - setting up price calculation');

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

                if (roomSelect.selectedIndex > 0) {
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
        roomSelect.addEventListener('change', updatePrice);
        checkInDate.addEventListener('change', updatePrice);
        checkOutDate.addEventListener('change', updatePrice);

        // Initial price update
        updatePrice();
    });
</script>
