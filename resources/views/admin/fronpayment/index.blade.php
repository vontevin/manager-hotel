@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ trans('menu.payment_title') }}</h2>

    <form action="{{ route('payment.process', ['booking_id' => $booking->id]) }}" method="POST">
        @csrf

        <!-- Display booking details (optional) -->
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <p><strong>Room Name:</strong> {{ $booking->room->roomType->name ?? 'N/A' }}</p>
                <p><strong>Check-in Date:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}</p>
            </div>
            <div class="col-12 col-md-6">
                <p><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
            </div>
        </div>

        <!-- Payment Information Fields (using Stripe, PayPal, etc.) -->
        <div class="form-group">
            <label for="card_number">{{ trans('menu.card_number') }}</label>
            <input type="text" id="card_number" name="card_number" class="form-control" placeholder="Enter your card number" required>
        </div>
        <div class="form-group">
            <label for="expiry_date">{{ trans('menu.expiry_date') }}</label>
            <input type="text" id="expiry_date" name="expiry_date" class="form-control" placeholder="MM/YY" required>
        </div>
        <div class="form-group">
            <label for="cvv">{{ trans('menu.cvv') }}</label>
            <input type="text" id="cvv" name="cvv" class="form-control" placeholder="CVV" required>
        </div>

        <!-- Payment button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{ trans('menu.pay_now') }}</button>
        </div>
    </form>
</div>
@endsection
