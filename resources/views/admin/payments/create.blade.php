@extends('layouts.master_app')

@push('styles')
<style>
    .payment-method-card {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
        border-radius: 10px;
        overflow: hidden;
    }
    .payment-method-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .payment-method-card.selected {
        border-color: var(--primary-color);
    }
    .payment-method-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    .credit-card-form {
        display: none;
    }
    .credit-card-form.active {
        display: block;
    }
    .bank-transfer-form {
        display: none;
    }
    .bank-transfer-form.active {
        display: block;
    }
    .paypal-form {
        display: none;
    }
    .paypal-form.active {
        display: block;
    }
    .cash-form {
        display: none;
    }
    .cash-form.active {
        display: block;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Payment</h1>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Payments
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="x_panel mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('payments.store') }}" method="POST" id="paymentForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="booking_id" class="form-label">Select Booking <span class="text-danger">*</span></label>
                            <select class="form-control @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                                <option value="">-- Select a booking --</option>
                                @foreach($bookings as $booking)
                                    @php
                                        // Calculate the paid amount for the booking
                                        $paidAmount = $booking->payments->where('status', 'completed')->sum('amount');
                                        
                                        // Calculate the total price (price per room * number of rooms * number of nights)
                                        $days = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                                        $totalPrice = $booking->room->roomType->price * $booking->number_of_rooms * $days;
                                        
                                        // Calculate the remaining balance
                                        $remainingAmount = $totalPrice - $paidAmount;
                                        
                                        // Concatenate the customer's full name
                                        $customerName = $booking->customer->first_name . ' ' . $booking->customer->last_name;
                                    @endphp

                                    <!-- Booking Option with number of rooms and remaining balance -->
                                    <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }} 
                                        data-amount="{{ $remainingAmount }}"
                                        data-customer="{{ $customerName }}"
                                        data-room="{{ $booking->room->room_number }} ({{ $booking->room->roomType->name }})"
                                        data-checkin="{{ $booking->check_in ? $booking->check_in->format('M d, Y') : 'N/A' }}"
                                        data-checkout="{{ $booking->check_out ? $booking->check_out->format('M d, Y') : 'N/A' }}">
                                        #{{ $booking->id }} - {{ $customerName }} - ${{ number_format($remainingAmount, 2) }} remaining ({{ $booking->number_of_rooms }} rooms)
                                    </option>

                                    <!-- Table Row Showing Remaining Balance -->
                                    <td style="text-align: center">
                                        USD {{ number_format($remainingAmount, 2) }}
                                    </td>
                                @endforeach

                            </select>
                            @error('booking_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="bookingDetails" class="card bg-light mb-4" style="display: none;">
                            <div class="card-body">
                                <h6 class="font-weight-bold">Booking Details</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Customer:</strong> <span id="customerName"></span></p>
                                        <p><strong>Room:</strong> <span id="roomDetails"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Check-in:</strong> <span id="checkInDate"></span></p>
                                        <p><strong>Check-out:</strong> <span id="checkOutDate"></span></p>
                                    </div>
                                </div>
                                <div class="alert alert-info mb-0">
                                    <strong>Remaining Balance:</strong> $<span id="remainingBalance"></span>
                                </div>
                            </div>
                        </div><br>
                        
                        <!-- Amount Input -->
                        <div class="mb-4">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <div class="input-group col-md-12">
                                <input type="number" step="0.01" min="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                    id="amount" name="amount" value="{{ old('amount') }}" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div><br>
                        
                        <div class="mb-4 x_panel">
                            <div class="x_title">
                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            </div>
                            <div class="row">
                                <div class="x_content">
                                    <div class="col-md-3 mb-3">
                                        <div class="payment-method-card card text-center p-3" data-method="credit_card">
                                            <div class="payment-method-icon">
                                                <i class="fas fa-credit-card text-primary"></i>
                                            </div>
                                            <h6>Credit Card</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="payment-method-card card text-center p-3" data-method="cash">
                                            <div class="payment-method-icon">
                                                <i class="fas fa-money-bill-wave text-success"></i>
                                            </div>
                                            <h6>Cash</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="payment-method-card card text-center p-3" data-method="bank_transfer">
                                            <div class="payment-method-icon">
                                                <img src="{{ asset('assets/production/images/aba.jpg') }}" alt="Bank ABA" style="width: 20px; height: 20px;">
                                            </div>
                                            <h6>ABA Bank</h6>
                                        </div>  
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="payment-method-card card text-center p-3" data-method="paypal">
                                            <div class="payment-method-icon">
                                                <i class="fab fa-paypal text-primary"></i>
                                            </div>
                                            <h6>PayPal</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="payment_method" id="payment_method" value="{{ old('payment_method') }}" required>
                            @error('payment_method')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div><br>
                        
                        <div class="x_panel">
                            <div class="x_title">
                                <h6 class="font-weight-bold mb-3">Payment Date <span class="text-danger">*</span></h6>
                            </div>
                            <div class="mb-4">
                                <input type="datetime-local" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date') ?? date('Y-m-d\TH:i') }}" required>
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div><br>
                            
                            <div class="mb-4">
                                <label for="status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div><br>
                            
                            <div class="mb-4">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div><br>
                        </div>
                        
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg col-md-12">
                                <i class="fas fa-save"></i> Save Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="x_panel mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Summary</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h1 class="display-4 font-weight-bold text-primary">$<span id="summaryAmount">0.00</span></h1>
                        <p class="text-muted">Total Amount</p>
                    </div>
                    
                    <hr>
                    
                    <div id="paymentSummary">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Payment Method:</span>
                            <span id="summaryMethod" class="font-weight-bold">Not selected</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Booking:</span>
                            <span id="summaryBooking" class="font-weight-bold">Not selected</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Customer:</span>
                            <span id="summaryCustomer" class="font-weight-bold">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Date:</span>
                            <span id="summaryDate" class="font-weight-bold">{{ date('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> A receipt will be automatically generated after the payment is processed.
                    </div>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Help</h6>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold">Payment Methods</h6>
                    <ul class="mb-3">
                        <li><strong>Credit Card:</strong> For card payments processed at the hotel.</li>
                        <li><strong>Cash:</strong> For cash payments received at the front desk.</li>
                        <li><strong>Bank Transfer:</strong> For payments made via bank transfer.</li>
                        <li><strong>PayPal:</strong> For payments processed through PayPal.</li>
                    </ul>
                    
                    <h6 class="font-weight-bold">Payment Status</h6>
                    <ul class="mb-0">
                        <li><strong>Completed:</strong> Payment has been received and confirmed.</li>
                        <li><strong>Pending:</strong> Payment is in process but not yet confirmed.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-select booking from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = urlParams.get('booking_id');
        if (bookingId) {
            $('#booking_id').val(bookingId).trigger('change');
        }

        // Booking selection
        $('#booking_id').change(function() {
            var selectedOption = $(this).find('option:selected');
            if (selectedOption.val()) {
                var amount = selectedOption.data('amount');
                var customer = selectedOption.data('customer');
                var room = selectedOption.data('room');
                var checkin = selectedOption.data('checkin');
                var checkout = selectedOption.data('checkout');
                
                $('#customerName').text(customer);
                $('#roomDetails').text(room);
                $('#checkInDate').text(checkin);
                $('#checkOutDate').text(checkout);
                $('#remainingBalance').text(amount.toFixed(2));
                $('#bookingDetails').show();
                
                // Set amount to remaining balance
                $('#amount').val(amount.toFixed(2));
                updateSummary();
                
                // Update summary
                $('#summaryBooking').text('#' + selectedOption.text().split(' - ')[0]);
                $('#summaryCustomer').text(customer);
            } else {
                $('#bookingDetails').hide();
                $('#amount').val('');
                updateSummary();
                
                // Update summary
                $('#summaryBooking').text('Not selected');
                $('#summaryCustomer').text('-');
            }
        });
        
        // Simplified payment method selection
        $('.payment-method-card').click(function() {
            $('.payment-method-card').removeClass('selected');
            $(this).addClass('selected');
            
            var method = $(this).data('method');
            $('#payment_method').val(method);
            
            // Update summary
            var methodText = $(this).find('h6').text();
            $('#summaryMethod').text(methodText);
        });
        
        // Amount change
        $('#amount').on('input', function() {
            updateSummary();
        });
        
        // Date change
        $('#payment_date').on('change', function() {
            var date = new Date($(this).val());
            var formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            $('#summaryDate').text(formattedDate);
        });
        
        // Update summary
        function updateSummary() {
            var amount = parseFloat($('#amount').val()) || 0;
            $('#summaryAmount').text(amount.toFixed(2));
        }
        
        // Form validation
        $('#paymentForm').on('submit', function(e) {
            if (!$('#payment_method').val()) {
                e.preventDefault();
                alert('Please select a payment method');
                return false;
            }
            
            if (!$('#booking_id').val()) {
                e.preventDefault();
                alert('Please select a booking');
                return false;
            }
            
            return true;
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let bookingSelect = document.getElementById("booking_id");
        let amountInput = document.getElementById("amount");

        bookingSelect.addEventListener("change", function () {
            let selectedOption = this.options[this.selectedIndex];
            let amount = selectedOption.getAttribute("data-amount");

            if (amount) {
                amountInput.value = amount;
            }
        });

        // Trigger change event if there's a pre-selected booking
        if (bookingSelect.value) {
            bookingSelect.dispatchEvent(new Event("change"));
        }
    });
</script>

@endpush