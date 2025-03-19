@extends('layouts.master_app')

@push('styles')
    <style>
        @media print {
            .no-print, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
                display: none !important;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            tfoot tr td {
                font-weight: bold;
                text-align: right;
            }
        }
        
    </style>
@endpush

@section('content')
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
    <div class="col-md-12" style="margin-top: 10px">
        <h3>Booking List</h3>
        <div class="x_panel">
            <form method="GET" action="{{ url('bookings') }}">
                <div class="x_title">
                    <h2>Search Bookings</h2>
                    <div class="mb-3 pull-right">
                        <a href="{{ url('bookings') }}" class="btn btn-primary"><i class="fa fa-refresh"></i> Reset</a>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-filter"></i> Filter</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-3 form-group">
                        <label>Customer Name</label>
                        <input type="text" name="customer_name" value="{{ request('customer_name') }}" class="form-control">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Check-in Date</label>
                        <input type="date" name="check_in" value="{{ request('check_in') }}" class="form-control">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Check-out Date</label>
                        <input type="date" name="check_out" value="{{ request('check_out') }}" class="form-control">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="checked-in" {{ request('status') == 'checked-in' ? 'selected' : '' }}>Checked In</option>
                            <option value="checked-out" {{ request('status') == 'checked-out' ? 'selected' : '' }}>Checked Out</option>
                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                </div>
            </form>            
        </div>
        
        <div class="x_panel">
            <div class="x_title">
                <h2>Booking Table</h2>
                <div class="panel_toolbox">
                    @can('Create Booking')
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Booking</a>
                    @endcan
                    <button class="btn btn-warning no-print" onclick="printTable()"><i class="fa fa-print"></i> Print</button>
                </div>
                <div class="clearfix"></div>
            </div>

            <div id="printableTable" class="x_content">
                <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No #</th>
                            <th>Customer</th>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                            <th>Grand Total</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th style="text-align: center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($booking->customer)->first_name }} {{ optional($booking->customer)->last_name }}</td>
                            <td>{{ optional($booking->room)->room_number }} - {{ optional($booking->room->roomType)->name }}</td>                                                  
                            <td>{{ $booking->check_in }}</td>
                            <td>{{ $booking->check_out }}</td>
                            <td>
                                <span class="badge" style="
                                    background-color: {{
                                        $booking->status === 'checked_in' ? '#28a745' : 
                                        ($booking->status === 'checked_out' ? '#6c757d' : 
                                        ($booking->status === 'confirmed' ? '#ffc107' : '#dc3545'))
                                    }};
                                    color: {{
                                        $booking->status === 'confirmed' ? '#000' : '#fff'
                                    }};
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            
                            @php
                                // Calculate the number of days between check-in and check-out
                                $days = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                            
                                // Calculate the total price (price per room * number of rooms * number of nights)
                                $totalPrice = $booking->room->roomType->price * $booking->number_of_rooms * $days;
                                
                                // Calculate the total payments completed
                                $totalPayments = $booking->payments->where('status', 'completed')->sum('amount');
                                
                                // Calculate the remaining balance
                                $remainingBalance = $totalPrice - $totalPayments;
                            @endphp

                            <td style="text-align: center">USD {{ number_format($totalPrice, 2) }}</td>

                            <th style="text-align: center">USD {{ number_format($booking->payments->where('status', 'pending', 'completed')->sum('amount'), 2) }}</th>
                            <td style="text-align: center">USD {{ number_format($remainingBalance, 2) }}</td>
                            <td>
                                @can('View Booking')
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan
                                @can('Edit Booking')
                                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                            
                                @if($booking->status == 'confirmed')
                                    @can('check-in bookings')
                                        <a href="{{ route('bookings.check-in', $booking->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Check In">
                                            <i class="fas fa-sign-in-alt"></i> Check-In
                                        </a>
                                    @endcan
                                @elseif($booking->status == 'checked_in')
                                    @can('check-out bookings')
                                        <a href="{{ route('bookings.check-out', $booking->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Check Out">
                                            <i class="fas fa-sign-out-alt"></i> Check-Out
                                        </a>
                                    @endcan
                                @elseif($booking->status == 'pending')
                                    <a href="{{ route('bookings.confirm', $booking->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Confirm Booking">
                                        <i class="fas fa-check"></i> Confirm
                                    </a>
                                    <a href="{{ route('bookings.cancel', $booking->id) }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancel">
                                        <i class="fas fa-ban"></i> Cancel
                                    </a>
                                @elseif($booking->status == 'confirmed')
                                    <a href="{{ route('bookings.cancel', $booking->id) }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancel">
                                        <i class="fas fa-ban"></i> Cancel
                                    </a>
                                @endif

                                @can('Delete Booking')
                                    <a href="{{url('bookings/'.$booking->id.'/delete')}}" class="btn btn-sm bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title='{{ trans("menu.delete")}}' style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a>
                                @endcan
                            </td>                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function printTable() {
        let table = document.getElementById('printableTable').outerHTML;
        let newWin = window.open('', '', 'height=600,width=800');
        newWin.document.write(`<html><head><title>Print Table</title><style>body { font-family: Arial; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #000; padding: 8px; text-align: left; } th { background: #405467; color: #fff; }</style></head><body><h2>Booking List</h2>${table}</body></html>`);
        newWin.document.close();
        newWin.print();
    }

    // Initialize DataTables (if needed)
    $(document).ready(function() {
        $('#datatable-checkbox').DataTable();
    });
</script>

@endpush