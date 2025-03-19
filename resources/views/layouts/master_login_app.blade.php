<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Booking')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/build/css/custom.min.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hanuman:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="icon" href="/hotel/images/photo.jpg" type="image/x-icon">

    <!-- Custom CSS -->
    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: 'Hanuman', 'Times New Roman', serif !important;
            font-weight: 400;
        }

        .login_wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login_content {
            width: 350px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login_content h1 {
            color: #FF5733;
        }

        /* General styling for both buttons */
        .btn-success.w-100, .btn-primary.w-100 {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            padding: 10px 0;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            position: relative;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Specific style for the Google button */
        .btn-success.w-100 {
            background-color: white; /* White background for Google button */
            color: #28a745; /* Green text color */
            border: 1px solid #28a74698; /* Optional green border */
        }

        /* Center the text */
        .btn-success.w-100 span {
            flex: 1;
            text-align: center;
        }

        /* Style for the image on the left */
        .btn-success.w-100 img, .btn-primary.w-100 img {
            width: 20px;
            height: 20px;
            margin-left: 10px; /* Prevent image from going too far left */
            margin-right: 8px; /* Space between icon and text */
            border-radius: 3px;
        }

        /* Hover effect for the button */
        .btn-success.w-100:hover {
            background-color: #e6e6e6; /* Light gray background on hover */
            color: #218838; /* Darker green text on hover */
            border-color: #218838; /* Darker green border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: add shadow effect */
        }

        .btn-primary.w-100:hover {
            background-color: #0056b3; /* Darker blue on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: add shadow effect */
        }
        
        /* General styling for both buttons */
        .btn-primary.w-100 {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            padding: 10px 0;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            position: relative;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Specific style for the Back Home button */
        .btn-primary.w-100 {
            background-color: #007bff; /* Primary blue background for Back Home button */
            color: white; /* White text color */
        }

        /* Center the text */
        .btn-primary.w-100 span {
            flex: 1;
            text-align: center;
        }

        /* Style for the image with rounded border */
        .btn-primary.w-100 img {
            width: 30px; /* Adjust width of the icon */
            height: 30px; /* Adjust height of the icon */
            margin-left: 10px; /* Prevent image from going too far left */
            margin-right: 8px; /* Space between icon and text */
            border-radius: 50%; /* Makes the image circular */
            border: 2px solid #fff; /* White border around the image */
            background-color: white; /* White background for the image */
            padding: 5px; /* Optional padding inside the circle */
        }

        /* Hover effect for the Back Home button */
        .btn-primary.w-100:hover {
            background-color: #0056b3; /* Darker blue on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional shadow effect on hover */
        }

        .btn-primary.w-100:active {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Optional active state shadow */
        }

        /* Title Style */
        .title-with-lines {
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 1.5em;
        text-align: center;
        }

        .title-with-lines::before,
        .title-with-lines::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #ff000047; /* Adjust color as needed */
        margin: 0 10px; /* Adjust spacing as needed */
        }

        /* Additional Styles for buttons and other UI elements */
        .spinner-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }

            .spinner {
                border: 6px solid #f3f3f3;
                border-top: 6px solid #3498db;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
    </style>

    @yield('head')
</head>
<body class="login" style="background: url('{{ asset('images/hotel5.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div class="login_wrapper">
        @yield('content')
        <!-- Spinner Start -->
        <div class="spinner-container" id="spinner-container">
            <div class="spinner"></div>
        </div>
        
        <!-- Spinner End -->
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';    
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePasswordIcon.classList.remove('fa-eye-slash');
                togglePasswordIcon.classList.add('fa-eye');
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Keep the spinner for 4 seconds
            setTimeout(() => {
                const spinnerContainer = document.getElementById('spinner-container');
                if (spinnerContainer) {
                    spinnerContainer.style.transition = 'opacity 0.1s'; // Smooth fade-out effect
                    spinnerContainer.style.opacity = '0';
                    setTimeout(() => spinnerContainer.remove(), 500); // Remove spinner after fade-out
                }
            }, 1000); // Display spinner for 4 seconds
        });
    </script>
</body>
</html>
