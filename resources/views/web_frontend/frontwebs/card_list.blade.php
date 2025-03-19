{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Choose Payment Method</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0e7ed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .payment-modal {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .payment-modal h2 {
            margin-bottom: 20px;
        }
        .payment-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: row-reverse; /* Moves the image to the right */
            background: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .payment-option:hover {
            background: #e9ecef;
        }
        .payment-option img {
            max-height: 30px;
            margin-left: 10px; /* Adds spacing between the text and the image */
        }
        .payment-option span {
            font-size: 16px;
            font-weight: bold;
            margin-right: auto;
            margin-left: 12px;
        }
        .payment-image img {
            max-height: 16px; /* Ensure the image is the same height as the text */
            vertical-align: middle; /* Align the image vertically with the text */
            margin-right: 40px;
        }
        .pay-text{
            margin-right: auto;
        }
        .payment-method-description p {
            font-size: 12px;
            color: #666;
            margin: 0; /* Removes default paragraph margin */
        }
        .payment-method-description{
            margin-right: 40px;
        }
        .payment-icon-next {
            font-size: 15px;
            color: #000000; /* Change the icon color */
            cursor: pointer; /* Makes it clickable */
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .payment-icon-close {
            font-size: 24px;
            color: #dc3545; /* Red color for the close icon */
            cursor: pointer;
        }
    </style>    

</head>
<body>
    <div class="payment-modal">
        <div class="modal-header">
            <h2>Choose way to pay</h2>
            <!-- Close icon next to the title -->
            <a href="{{ url('/viewroom/{id}') }}">
                <i class="fas fa-times payment-icon-close" onclick="closeModal()"></i>
            </a>                    
        </div>
        <div class="payment-option" onclick="window.location='{{ route('payment.aba') }}'">
            <!-- Right arrow icon -->
            <i class="fas fa-arrow-right payment-icon-next"></i>
            <div class="payment-method-description">
                <span class="payment-method-title" style="margin-right: 78px;">ABA Pay</span>
                <p>Scan to pay with ABA Mobile</p>
            </div>
            <img class="payment-icon" src="{{ asset('images/ic_ABA-PAY_3x.png') }}" alt="ABA Pay">
        </div>
    
        <div class="payment-option" onclick="window.location='{{ route('payment.card') }}'">
            <!-- Right arrow icon -->
            <i class="fas fa-arrow-right payment-icon-next"></i>
            <div class="pay-text">
                <span>Credit/Debit Card</span>
                <div class="payment-image">
                    <img src="{{ asset('images/A-3Card_3x.png') }}" alt="Additional Card">
                </div>
            </div>            
            <img class="payment-icon" src="{{ asset('images/ic_generic_3x.png') }}" alt="Credit/Debit Card">
        </div>        
    </div>
    
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="{{ asset('hotel/css/card.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .btn-close {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
        }

        .btn-close:hover {
            background-color: #e0e0e0;
        }

    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <a href="{{ route('viewroom', ['id' => $roomtype->id]) }}">
                <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </a>
            
            <h2>Credit/Debit Card</h2>
            <span class="timer" id="timer">02:57</span>
        </div>
        <form action="{{ route('processPayment', ['id' => $roomtype->id]) }}" method="POST">
            @csrf
            <div class="payment-form">
                <div class="form-group card-nu">
                    <label for="card-number">
                        Card number
                        <img src="{{ asset('images/A-3Card_3x.png') }}" alt="Card Icon" class="label-icon">
                    </label>
                    <input type="text" id="card-number" name="card_number" placeholder="Enter 16-digit card number" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry-date">Expiry date</label>
                        <input type="text" id="expiry-date" name="expiry_date" placeholder="MM / YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <div class="input-container">
                            <input type="text" id="cvv" name="cvv" placeholder="000" required>
                            <img src="{{ asset('images/cvv.png') }}" alt="CVV icon" class="input-icon">
                        </div>
                    </div>
                    
                </div>
                <p style="font-size: 12px">
                    Encrypted storage and processing of cr edit/debit card payments is handled by our trusted payment solution ABA PayWay.
                </p><br>
                @php
                    $currency = session('currency', 'USD');
                    $exchangeRate = 4100;
                    $pricePerDay = $booking_record->roomType->price;
                    $days = \Carbon\Carbon::parse($booking_record->check_in)->diffInDays($booking_record->check_out);

                    $subtotal = $pricePerDay * $days;
                    if ($currency == 'KHR') {
                        $subtotal *= $exchangeRate;
                    }
                @endphp

                <div class="payment-con">
                    <div class="payment-summary">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>
                                {{ number_format($subtotal, 2) }} {{ $currency == 'KHR' ? '៛' : 'USD' }}
                            </span>
                        </div>
                        <div class="summary-row total">
                            <span>TOTAL:</span>
                            <span>
                                {{ number_format($subtotal, 2) }} {{ $currency == 'KHR' ? '៛' : 'USD' }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('processPayment', $roomtype->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="payment-button">
                            PAY {{ $currency == 'KHR' ? '៛' : 'USD' }} {{ number_format($subtotal, 2) }}
                        </button>
                    </form>
                </div>                                 
            </div>
        </form>

    </div>
</body>
    <script>

        let timeLeft = 2 * 60 + 57;

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            const formattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            document.getElementById("timer").textContent = formattedTime;

            if (timeLeft > 0) {
                timeLeft--;
            } else {
                clearInterval(timerInterval);

                window.location.href = '{{ route('viewroom', ['id' => $roomtype->id]) }}'; // Adjust route accordingly
            }
        }

        const timerInterval = setInterval(updateTimer, 1000);

        updateTimer();
    </script>
    <script>
        document.querySelector('.payment-button').addEventListener('click', function (e) {
            const cardNumber = document.getElementById('card-number').value.trim();
            const expiryDate = document.getElementById('expiry-date').value.trim();
            const cvv = document.getElementById('cvv').value.trim();

            if (!cardNumber || !expiryDate || !cvv) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    </script>
</html>
