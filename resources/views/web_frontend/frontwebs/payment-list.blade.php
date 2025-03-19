
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABA QR</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
        }

        .qr-container {
        text-align: center;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #fff;
            background-color: #ff0000; /* Red background */
            padding: 10px;
            border-radius: 5px;
        }

        .details {
        margin: 15px 0;
        }

        .details span {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin-right: 250px;
        }
        .name{
            margin-right: 94px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 10px;
        }

        .description {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
    <body>
        <div class="qr-container">
            <h1>KHQR</h1>
            <!-- Name and Price -->
            <div class="details">
                <span class="name"><strong>VATHANAK REASEY HOTEL</strong></span>
                <span class="price">${{ number_format($roomtype->price, 2) }}</span>
            </div>
            
            <!-- QR Code Image -->
            <img src="{{ asset('images/abakong.png') }}" alt="QR Code Image">
            <p class="description">Scan the QR code above with any ABA-supported app to proceed with payment or access.</p>
        </div>
    </body> 
</html>


