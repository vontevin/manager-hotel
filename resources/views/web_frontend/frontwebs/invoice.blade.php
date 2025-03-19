<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('VATHANAK REASEY HOTEL', 'INVOICE VATHANAK REASEY HOTEL')</title> <!-- Dynamic Page Title -->
            
        <!-- Apple Touch Icon -->
        <link rel="icon" href="/hotel/images/photo.jpg" type="image/x-icon">

        <!-- Bootstrap -->
        <link href="{{asset('assets')}}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{asset('assets')}}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{asset('assets')}}/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- SweetAlert2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="{{asset('assets')}}/build/css/custom.min.css" rel="stylesheet">
    </head>

    <body class="nav-md" style="background: transparent">
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="col-md-12">
                    <div class="pull-right">
                        <div class="close-link">
                            <!--- ./ Message box --->
                            @if (session("status"))
                                <script>
                                    Swal.fire({
                                        text: "{{ session('status') }}",
                                        icon: "success",
                                        draggable: true
                                    });
                                </script>
                            @elseif (session("error"))
                                <script>
                                    Swal.fire({
                                        title: "Booking Failed!",
                                        text: "{{ session('error') }}",
                                        icon: "error",
                                        draggable: true
                                    });
                                </script>
                            @endif

                            <!--- ./ End Message box ---> 
                        </div>
                    </div>
                    
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                            </div>
                        <div class="x_content">
                            <section class="content invoice">
                                <!-- title row -->
                                <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1>
                                        <i class="fa fa-globe"></i> Invoice.
                                        <small class="pull-right">Date: {{ \Carbon\Carbon::now()->format('m/d/Y') }}</small>
                                    </h1>
                                </div>
                                <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong><a href="#">Iron Admin, សណ្ឋាគារ វឌ្ឍនៈរាសី</a></strong>
                                        <br><a href="#">VATHANAK REASEY HOTEL</a>
                                        <br>Phone: <a href="tel:012432082">012 432 082</a>
                                        <br>Email: <a href="mailto:vathanakreaseyhotel@gmail.com">vathanakreaseyhotel@gmail.com</a>
                                    </address>

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong>{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</strong><br>
                                        Email: {{ $booking->customer->email }}<br>
                                        Phone: {{ $booking->customer->phone }}
                                    </address>

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #{{ $booking->id }}</b>
                                    <br>
                                    <b>Booking ID:</b> {{ $booking->id }}
                                    <br>
                                    <b>Payment Due:</b> {{ \Carbon\Carbon::now()->format('m/d/Y') }}
                                    <br>
                                    <b>Account:</b> {{ $accountNumber ?? 'N/A' }}
                                </div>
                                <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                <div class="col-xs-12 table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Room Code</th>
                                                <th>Room Name</th>
                                                <th>Number of Rooms</th>
                                                <th>Adults</th>
                                                <th>Children</th>
                                                <th>Gender</th>
                                                <th>Check-In Date</th>
                                                <th>Check-Out Date</th>
                                                <th>Price per Night</th>
                                                <th>Total Nights</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                                                <td>{{ $booking->room->roomType->name ?? 'N/A' }}</td>
                                                <td>{{ $booking->number_of_rooms }}</td>
                                                <td>{{ $booking->number_of_adults }}</td>
                                                <td>{{ $booking->number_of_children }}</td>
                                                <td>{{ $booking->customer->gender }}</td>
                                                <td>{{ $booking->check_in }}</td>
                                                <td>{{ $booking->check_out }}</td>
                                                <td>${{ number_format($booking->room->roomType->price, 2) }}</td>
                                                @php
                                                    $days = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                                                    $pricePerNight = $booking->room->roomType->price;
                                                    $total = $pricePerNight * $days * $booking->number_of_rooms; // Multiply by number of rooms
                                                @endphp
                                                <td>{{ $days }}</td>
                                                
                                                <td>${{ number_format($total, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-6">
                                    <p class="lead">Payment Methods:</p>
                                    <img src="{{asset('assets')}}/production/images/visa.png" alt="Visa">
                                    <img src="{{asset('assets')}}/production/images/mastercard.png" alt="Mastercard">
                                    <img src="{{asset('assets')}}/production/images/american-express.png" alt="American Express">
                                    <img src="{{asset('assets')}}/production/images/paypal.png" alt="Paypal">
                                    <h4>Description Room</h4>
                                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                        {{$booking->room->roomType->description}}
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-6">
                                    <p class="lead">
                                        Amount Due {{ \Carbon\Carbon::now()->format('m/d/Y') }}
                                    </p>                                                    
                                    <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <!-- Summary Rows -->
                                            <tr>
                                                @php
                                                    $currency = session('currency', 'USD'); // Default to USD if no currency is set
                                                    $exchangeRate = 4100; // Example exchange rate for USD to KHR
                                                    $subtotal = 0;
                                        
                                                    // Ensure roomType is not null before accessing its price
                                                    if ($booking->room->roomType) {
                                                        $subtotal = $booking->room->roomType->price * \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                                        
                                                        // Convert subtotal to KHR if the selected currency is Riel
                                                        if ($currency == 'KHR') {
                                                            $subtotal *= $exchangeRate;
                                                        }
                                                    }
                                                @endphp
                                        
                                                <th style="width:50%">Subtotal:</th>
                                                <td>
                                                    {{ number_format($subtotal, 2) }} {{ $currency == 'KHR' ? '៛' : 'USD' }}
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Tax (5.3%):</th>
                                                <td>
                                                    {{ number_format(($booking->roomType->price * \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out)) * 0.093, 2) }} USD
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                @php
                                                    $currency = session('currency', 'USD');
                                                    $exchangeRate = 4100;
                                                    $totalPrice = 0;
                                        
                                                    if ($booking->room->roomType) {
                                                        $totalPrice = $booking->room->roomType->price * \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
                                        
                                                        if ($currency == 'KHR') {
                                                            $totalPrice *= $exchangeRate; // Convert to Riel
                                                        }
                                                    }
                                                @endphp
                                        
                                                <th>Total:</th>
                                                <td>
                                                    {{ number_format($totalPrice, 2) }} {{ $currency == 'KHR' ? '៛' : 'USD' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div class="col-xs-12">
                                        <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                                        <a href="{{ route('payment-list', ['id' => $roomtype->id]) }}" class="btn btn-success pull-right">
                                            <i class="fa fa-credit-card"></i> Submit Payment
                                        </a>                                                                                                                                                                                                                                                    
                                        <button class="btn btn-primary pull-right" onclick="window.print();" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
        <!-- jQuery -->
        <script src="{{asset('assets')}}/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="{{asset('assets')}}/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="{{asset('assets')}}/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="{{asset('assets')}}/vendors/nprogress/nprogress.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="{{asset('assets')}}/build/js/custom.min.js"></script>
    </body>
</html>