@extends('layouts.master_app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Check-out: Booking Room #{{ $booking->room->room_number }}</h1>
        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Booking
        </a>
    </div>
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

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Booking Information Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="x_panel">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
                </div><br>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Status</span>
                        <span class="badge bg-success" style="background-color: green; color: white;">Checked In</span>
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Customer</span>
                        <span class="h5 font-weight-bold">{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</span>
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Room</span>
                        <span>Room {{ $booking->room->room_number }} ({{ $booking->room->roomType->name }})</span>
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Check-in Date</span>
                        <span>{{ $booking->check_in_date }}</span>
                        @if($booking->actual_check_in)
                            <span class="text-success d-block small">
                                <i class="fas fa-check-circle"></i> Checked in on {{ $booking->actual_check_in->format('M d, Y g:i A') }}
                            </span>
                        @endif
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Check-out Date</span>
                        <span>{{ $booking->check_out_date }}</span>
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Length of Stay</span>
                        <span>{{ $booking->actual_check_in ? $booking->actual_check_in->diffInDays(now()) + 1 : $booking->check_in_date->diffInDays($booking->check_out_date) }} nights</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="x_panel">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Original Total</span>
                        @php
                            $days = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                            $originalTotal = $booking->room->roomType->price * $days * $booking->number_of_rooms;
                        @endphp
                        <span class="h5 font-weight-bold">${{ number_format($originalTotal, 2) }}</span>
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Additional Charges</span>
                        <span class="h5 font-weight-bold text-danger" id="additional_charges_display">$0.00</span> <!-- Update based on your charges -->
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Final Total</span>
                        @php
                            $additionalCharges = 0; // Add your dynamic calculation for additional charges
                            $finalTotal = $originalTotal + $additionalCharges;
                        @endphp
                        <span class="h5 font-weight-bold text-success" id="final_total_display">${{ number_format($finalTotal, 2) }}</span>
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Amount Paid</span>
                        <span class="h5 font-weight-bold">${{ number_format($booking->payments->where('status', 'completed')->sum('amount'), 2) }}</span>
                    </div><br>
                    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Balance Due</span>
                        @php
                            $balanceDue = $finalTotal - $booking->payments->where('status', 'completed')->sum('amount');
                        @endphp
                        <span class="h5 font-weight-bold {{ $balanceDue > 0 ? 'text-danger' : 'text-success' }}" id="balance_due_display">
                            ${{ number_format($balanceDue, 2) }}
                        </span>
                    </div><br>
                    
                    @if($balanceDue > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> There is an outstanding balance on this booking.
                        </div><br>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> This booking is fully paid.
                        </div>
                    @endif
                </div>                
            </div>
        </div>

        <!-- Check-out Form Card -->
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="x_panel">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Check-out Form</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('bookings.process-check-out', $booking->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="actual_check_out" class="form-label">Check-out Date & Time</label>
                            <input type="datetime-local" class="form-control" id="actual_check_out" name="actual_check_out" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div><br>
                        
                        <div class="mb-3">
                            <label for="additional_charges" class="form-label">Additional Charges</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="additional_charges" name="additional_charges" value="0" min="0" step="0.01" onchange="updateTotals()">
                            </div>
                            <div class="form-text">Enter any additional charges (mini-bar, room service, damages, etc.)</div>
                        </div><br/>
                        
                        <div class="mb-3">
                            <label for="additional_charges_notes" class="form-label">Additional Charges Notes</label>
                            <textarea class="form-control" id="additional_charges_notes" name="additional_charges_notes" rows="2"></textarea>
                        </div><br>
                        
                        <div class="mb-3">
                            <label for="key_returned" class="form-label">Room Key</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="key_returned" name="key_returned" value="1" required>
                                <label class="form-check-label" for="key_returned">
                                    I confirm that the room key has been returned
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="room_inspected" class="form-label">Room Inspection</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="room_inspected" name="room_inspected" value="1" required>
                                <label class="form-check-label" for="room_inspected">
                                    I confirm that the room has been inspected
                                </label>
                            </div><br>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Check-out Notes</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div><br>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sign-out-alt"></i> Complete Check-out
                            </button>
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Inspection Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Room Inspection Checklist</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fas fa-bed text-primary"></i> Furniture</td>
                            <td>
                                <select class="form-control">
                                    <option value="good">Good</option>
                                    <option value="damaged">Damaged</option>
                                    <option value="missing">Missing</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm"></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-tv text-primary"></i> Electronics</td>
                            <td>
                                <select class="form-control">
                                    <option value="good">Good</option>
                                    <option value="damaged">Damaged</option>
                                    <option value="missing">Missing</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm"></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-bath text-primary"></i> Bathroom</td>
                            <td>
                                <select class="form-control">
                                    <option value="good">Good</option>
                                    <option value="damaged">Damaged</option>
                                    <option value="issue">Issue</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm"></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-wine-glass-alt text-primary"></i> Mini Bar</td>
                            <td>
                                <select class="form-control">
                                    <option value="untouched">Untouched</option>
                                    <option value="used">Used</option>
                                    <option value="refill">Needs Refill</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm"></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-key text-primary"></i> Safe</td>
                            <td>
                                <select class="form-control">
                                    <option value="empty">Empty</option>
                                    <option value="items">Items Inside</option>
                                    <option value="locked">Locked</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm"></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-broom text-primary"></i> Cleanliness</td>
                            <td>
                                <select class="form-control">
                                    <option value="good">Good</option>
                                    <option value="needs_cleaning">Needs Cleaning</option>
                                    <option value="excessive">Excessive Cleaning</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Payment Processing Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Payment Processing</h6>
        </div>
        <div class="card-body">
            <div class="row x_panel">
                <div class="col-md-6">
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Payment History</span>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($booking->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date }}</td>
                                        <td>${{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }}</td>
                                        <td>
                                            @if($payment->status == 'completed')
                                                <span class="badge bg-success" style="background-color: green;">Completed</span>
                                            @elseif($payment->status == 'pending')
                                                <span class="badge bg-warning text-dark" style="background-color: yellow;">Pending</span>
                                            @elseif($payment->status == 'failed')
                                                <span class="badge bg-danger" style="background-color: red;">Failed</span>
                                            @elseif($payment->status == 'refunded')
                                                <span class="badge bg-info" style="background-color: lightblue;">Refunded</span>
                                            @endif
                                        </td>                                        
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No payments recorded</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Process Final Payment</span>
                    <div class="mb-3 x_panel">
                        <div class="card border-left-warning shadow py-2 mb-3">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    @php
                                        // Calculate the number of days between check-in and check-out
                                        $days = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                                        $totalPrice = $booking->room->roomType->price * $booking->number_of_rooms * $days;
                                        $totalPayments = $booking->payments->where('status', 'completed')->sum('amount');
                                        $remainingBalance = $totalPrice - $totalPayments;
                                    @endphp

                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Balance Due
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="payment_balance_due">
                                            ${{ number_format($remainingBalance, 2) }}
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($booking->total_price - $booking->payments->where('status', 'completed')->sum('amount') > 0)
                            <div class="text-center">
                                <a href="{{ route('payments.create', ['booking_id' => $booking->id]) }}" class="btn btn-success">
                                    <i class="fas fa-credit-card"></i> Process Payment
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function updateTotals() {
            // Get values
            const originalTotal = {{ $booking->room->roomType->price }} * {{ $booking->number_of_rooms }} * {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }};
            const amountPaid = {{ $booking->payments->where('status', 'completed')->sum('amount') }};
            const additionalCharges = parseFloat(document.getElementById('additional_charges').value) || 0;
            
            // Calculate new totals
            const finalTotal = originalTotal + additionalCharges;
            const balanceDue = finalTotal - amountPaid;
            
            // Update display
            document.getElementById('additional_charges_display').textContent = '$' + additionalCharges.toFixed(2);
            document.getElementById('final_total_display').textContent = '$' + finalTotal.toFixed(2);
            document.getElementById('balance_due_display').textContent = '$' + balanceDue.toFixed(2);
            document.getElementById('payment_balance_due').textContent = '$' + balanceDue.toFixed(2);
            
            // Update classes for balance due
            const balanceDueElement = document.getElementById('balance_due_display');
            if (balanceDue > 0) {
                balanceDueElement.classList.remove('text-success');
                balanceDueElement.classList.add('text-danger');
            } else {
                balanceDueElement.classList.remove('text-danger');
                balanceDueElement.classList.add('text-success');
            }
        }

    </script>
@endpush
