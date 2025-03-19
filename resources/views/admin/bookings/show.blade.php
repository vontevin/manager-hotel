@extends('layouts.master_app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Booking Details</h1>
            <a href="{{ url('bookings') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Bookings
            </a>
        <div class="mb-3 pull-right">
            <a href="{{ route('customers.show', $booking->customer->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-user"></i> View customer Profile
            </a>
        </div>
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
                <div class="x_content py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="x_title">
                        <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Booking Actions:</div>
                            @if($booking->status == 'confirmed')
                            <a class="dropdown-item" href="{{ route('bookings.check-in', $booking->id) }}">
                                <i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Check-in
                            </a><br>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('cancel-form').submit();">
                                <i class="fas fa-ban fa-sm fa-fw mr-2 text-gray-400"></i> Cancel Booking
                            </a><br>
                            <form id="cancel-form" action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @elseif($booking->status == 'checked_in')
                            <a class="dropdown-item" href="{{ route('bookings.check-out', $booking->id) }}">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Check-out
                            </a><br>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this booking?')) document.getElementById('delete-form').submit();">
                                <i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i> Delete Booking
                            </a><br>
                            <form id="delete-form" action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Status</span>
                        @if($booking->status == 'confirmed')
                            <span class="badge bg-warning text-dark" style="background-color: #ffc107; color: #000;">Confirmed</span>
                        @elseif($booking->status == 'checked_in')
                            <span class="badge bg-success" style="background-color: #28a745; color: #fff;">Checked In</span>
                        @elseif($booking->status == 'checked_out')
                            <span class="badge bg-secondary" style="background-color: #6c757d; color: #fff;">Checked Out</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="badge bg-danger" style="background-color: #dc3545; color: #fff;">Cancelled</span>
                        @endif
                    </div><br>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Booking Reference</span>
                        <span class="h5 font-weight-bold">{{ $booking->booking_reference }}</span>
                    </div><br>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Check-in Date</span>
                        <span>{{ $booking->check_in_date }}</span>
                        @if($booking->actual_check_in)
                            <span class="text-success d-block small">
                                <i class="fas fa-check-circle"></i> Checked in on {{ $booking->actual_check_in}}
                            </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Check-out Date</span>
                        <span>{{ $booking->check_out_date}}</span>
                        @if($booking->actual_check_out)
                            <span class="text-success d-block small">
                                <i class="fas fa-check-circle"></i> Checked out on {{ $booking->actual_check_out}}
                            </span>
                        @endif
                    </div><br>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Number of Nights</span>
                        {{ $booking->check_in && $booking->check_out ? max($booking->check_in->diffInDays($booking->check_out), 1) : 'N/A' }}
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Number of Rooms</span>
                        <span>{{ $booking->number_of_rooms }}</span>
                    </div><br>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Number of Adults</span>    <span>{{ $booking->number_of_adults }}</span><br>
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Number of Children</span>  <span>{{ $booking->number_of_children }}</span>
                    </div><br>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Total Price</span>
                        <span class="h5 font-weight-bold text-success">
                            ${{ number_format($booking->room->roomType->price * $booking->number_of_rooms * \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out), 2) }}
                        </span>
                    </div>                    

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Booking Source</span>
                        <span>{{ ucfirst(str_replace('_', ' ', $booking->booking_source)) }}</span>
                    </div><br>

                    @if($booking->special_requests)
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Special Requests</span>
                        <p class="mb-0">{{ $booking->special_requests }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Guest Information Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="x_panel">
                <div class="x_title">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                </div>
                <div class="x_content">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode($booking->customer->first_name . ' ' . $booking->customer->last_name) }}&background=4e73df&color=ffffff&size=128" width="100" height="100">
                        <h5 class="mt-3 mb-0">{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</h5>
                        <p class="text-muted">{{ $booking->customer->email }}</p>
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Phone</span>
                        <span>{{ $booking->customer->phone }}</span>
                    </div><br>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Address</span>
                        <p class="mb-0">
                            {{ $booking->customer->address }}<br>
                            {{ $booking->customer->city }}, {{ $booking->customer->state }} {{ $booking->customer->zip_code }}<br>
                            {{ $booking->customer->country }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">ID Type</span>
                        <span>{{ $booking->customer->identification_type }}</span>
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">ID Number</span>
                        <span>{{ $booking->customer->identification_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="x_panel">
                <div class="x_title">
                    <h6 class="m-0 font-weight-bold text-primary">Room Information</h6>
                </div>
                <div class="x_content">
                    <div class="text-center mb-4">
                        <div class="bg-light p-3 rounded-circle d-inline-block">
                            <i class="fas fa-door-open fa-3x text-primary"></i>
                        </div>
                        <h5 class="mt-3 mb-0">Room {{ $booking->room->room_number }}</h5>
                        <p class="text-muted">{{ $booking->room->roomType->name }}</p>
                    </div>
    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Room Type</span>
                        <span>{{ $booking->room->roomType->name }}</span>
                    </div>
    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Floor</span>
                        <span>{{ $booking->room->floor }}</span>
                    </div>
    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Capacity</span>
                        <span>{{ $booking->number_of_guests }} Persons</span>
                    </div>
    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Price Per Night</span>
                        <span>${{ number_format($booking->room->roomType->price, 2) }}</span>
                    </div>
    
                    <div class="mb-3">
                        <span class="d-block text-xs font-weight-bold text-uppercase text-muted">Amenities</span>
                        <p class="mb-0">
                            @foreach(collect(json_decode($booking->room->roomType->amenities)) as $amenity)
                                <i class="fa-solid fa-check-circle text-success"></i> {{ $amenity->name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </p>                                                                
                    </div>
    
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.rooms.show', $booking->room->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-door-open"></i> View Room Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payments Card -->
    <div class="x_panel mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <div class="panel_toolbox">
                @can('Create Payment')
                    @if($booking->payments->where('status', 'completed')->sum('amount') < $booking->total_price)
                        <a href="{{ route('payments.create', ['booking_id' => $booking->id]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus fa-sm"></i> Add Payment
                        </a>
                    @endif
                @endcan
            </div>
            <div class="x_title">
                <h6 class="m-0 font-weight-bold text-primary">Payment History</h6>
            </div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->payments as $payment)
                        <tr>
                            <td>{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</td>
                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>
                                @if($payment->payment_method == 'credit_card')
                                    <i class="fas fa-credit-card text-primary"></i> Credit Card
                                @elseif($payment->payment_method == 'paypal')
                                    <i class="fab fa-paypal text-primary"></i> PayPal
                                @elseif($payment->payment_method == 'bank_transfer')
                                <img src="{{ asset('assets/production/images/aba.jpg') }}" alt="Bank ABA" style="width: 15px; height: 15px;"> ABA Bank
                                @elseif($payment->payment_method == 'cash')
                                    <i class="fas fa-money-bill-wave text-success"></i> Cash
                                @else
                                    <i class="fa-solid fa-question-circle"></i> {{ ucfirst($payment->payment_method) }}
                                @endif
                            </td>
                            
                            <td>
                                @if($payment->status == 'completed')
                                <span style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 5px;">✔ Completed</span>
                                @elseif($payment->status == 'pending')
                                    <span style="background-color: #ffc107; color: black; padding: 5px 10px; border-radius: 5px;">⏳ Pending</span>
                                @elseif($payment->status == 'failed')
                                    <span style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 5px;">❌ Failed</span>
                                @elseif($payment->status == 'refunded')
                                    <span style="background-color: #17a2b8; color: white; padding: 5px 10px; border-radius: 5px;">💰 Refunded</span>
                                @endif
                            
                            </td>
                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('payments.receipt', ['booking' => $booking->id, 'payment' => $payment->id]) }}" class="btn btn-sm btn-info" title="Receipt">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                                @can('Edit Payment')
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('Delete Payment')
                                    <a href="{{url('payments/'.$booking->id.'/delete')}}" class="btn btn-sm bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title='{{ trans("menu.delete")}}' style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a>
                                @endcan
                                @can('check-out bookings')
                                    @if($payment->status == 'completed' && !$booking->actual_check_out)
                                        <a href="{{ route('bookings.check-out', $booking->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Check Out">
                                            <i class="fas fa-sign-out-alt"></i> Check Out
                                        </a>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No payments recorded</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-end">Total Paid:</th>
                            <th>${{ number_format($booking->payments->where('status', 'completed')->sum('amount'), 2) }}</th>
                            <th colspan="3"></th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end">Balance:</th>
                            <th>
                                @php
                                    // Calculate the number of days between check-in and check-out
                                    $days = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                                    $roomTotal = $booking->room->roomType->price * $days * $booking->number_of_rooms;
                                    $remainingBalance = $roomTotal - $booking->payments->where('status', 'completed')->sum('amount');
                                @endphp
                            
                                ${{ number_format($remainingBalance, 2) }}
                            </th>
                            <th colspan="3"></th>
                        </tr>
                    </tfoot>
                </table>                
            </div>
        </div>
    </div>
</div>
@endsection
