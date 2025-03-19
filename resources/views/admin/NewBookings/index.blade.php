@extends("layouts.master_app")
@push("styles")
    <style>
        .x_panel {
            font-family: Hanuman, 'Times New Roman' !important;
            font-weight: 400;
            font-size: 12px;
        }
        .icon-item {
            color: rgb(145, 89, 89);
        }
        .icon-ite {
            color: red;
        }
    </style>
@endpush

@section("content")

<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h3>New Booking List</h3>
    </div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                <thead>
                    <tr style="height: 25px;">
                        <th>User Details</th>
                        <th>Room Details</th>
                        <th>Booking Details</th>
                        <th style="text-align: center">{{ trans('menu.status') }}</th>
                        <th style="text-align: center">{{ trans('menu.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        @if($booking->booking_source == 'website' || $booking->status == 'pending')
                            <tr>
                                <td>
                                    <strong>Name:</strong> {{ $booking->customer->first_name }} {{ $booking->customer->last_name }}<br>
                                    <strong>Email:</strong> {{ $booking->customer->email }}<br>
                                    <strong>Phone:</strong> {{ $booking->customer->phone }}<br>
                                    <strong>{{ trans('menu.maxAdult') }}:</strong> {{ $booking->number_of_adults }}<br>
                                    <strong>{{ trans('menu.maxChildren') }}:</strong> {{ $booking->number_of_children }}<br>
                                    <strong>Gender:</strong> {{ $booking->customer->gender }}
                                </td>
                                <td>
                                    @if($booking->room && $booking->room->roomType)
                                        <strong>Room:</strong> {{ $booking->room->room_number }}<br>
                                        <strong>Floor:</strong> {{ $booking->room->floor }}<br>
                                        <strong>Number Of Rooms:</strong> {{ $booking->number_of_rooms }}<br>
                                        <strong>Type:</strong> {{ $booking->room->roomType->name }}<br>
                                        <strong>Price for 1 night:</strong> ${{ number_format($booking->room->roomType->price, 2) }}<br>
                                        @php
                                            $days = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                                            $totalPrice = $booking->room->roomType->price * $booking->number_of_rooms * $days; // Calculate total price
                                        @endphp
                                        <strong>Total Price:</strong> ${{ number_format($totalPrice, 2) }}
                                        
                                    @else
                                        <span class="text-danger">Room details unavailable</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>Check-in:</strong> {{ $booking->check_in }}<br>
                                    <strong>Check-out:</strong> {{ $booking->check_out }}<br>
                                </td>
                                <td style="text-align: center">
                                    <span class="badge" style="background-color: #28a745; color: #fff">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                    <span class="badge" style="background-color: #e96767; color: #fff">
                                        {{ ucfirst(str_replace('_', ' ', $booking->booking_source)) }}
                                    </span>
                                </td>
                
                                <td style="width: 150px; text-align: center">
                                    @if($booking->status == 'pending')
                                        <a href="{{ route('bookings.confirm', $booking->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Apply Booking">
                                            <i class="fas fa-check"></i> Apply Booking
                                        </a>
                                        <a href="{{ route('bookings.cancel', $booking->id) }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancel Booking">
                                            <i class="fas fa-close"></i> Cancel Booking
                                        </a>
                                    @elseif($booking->status == 'confirmed')
                                        <a href="{{ route('bookings.cancel', $booking->id) }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancel Booking">
                                            <i class="fas fa-close"></i> Cancel Booking
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>                
            </table>
        </div>
    </div>
</div>
@endsection
