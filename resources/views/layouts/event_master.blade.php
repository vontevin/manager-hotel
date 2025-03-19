<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Booking System')</title>

    <!-- Include CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <!-- Link to Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <style>
        .event-past {
            background-color: #f9c3c3;
            border-color: #f9c3c3;
            color: #000;
        }
        /* Set font for FullCalendar */
        .fc {
            font-family: 'Roboto', sans-serif !important;
        }

        /* Set font for event titles */
        .fc-event {
            font-family: 'Roboto', sans-serif !important;
        }

        /* Set font for header */
        .fc-header-toolbar {
            font-family: 'Roboto', sans-serif !important;
        }
        
        /* Optional: Customize font size and weight */
        .fc-event {
            font-size: 14px;
            font-weight: 500;
        }

        .fc-header-toolbar {
            font-size: 18px;
            font-weight: 700;
        }
    </style>
    @stack('styles') <!-- For page-specific styles -->
</head>

<body>
    <div class="container mt-3">
        <header>
            <h1 class="text-center mt-3">Booking Event Hotel</h1>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    @stack('scripts') <!-- For page-specific scripts -->
</body>

</html>
