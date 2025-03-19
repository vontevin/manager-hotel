<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield("title", "System Dashboard (សណ្ឋាគារ វឌ្ឍនៈរាសី)")</title>


    <link rel="icon" href="/hotel/images/photo.jpg" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="{{ asset('css/master-styles.css') }}" rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ asset("assets") }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset("assets") }}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset("assets") }}/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset("assets") }}/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset("assets") }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset("assets") }}/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset("assets") }}/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset("assets") }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset("assets") }}/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    {{-- Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom Theme Style -->
    <link href="{{ asset("assets") }}/build/css/custom.min.css" rel="stylesheet">
    @stack("styles")
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{asset('assets')}}/production/images/IMG_2179.PNG" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>{{trans('menu.welcome')}},</span>
                            <h2>HOTEL</h2>
                        </div>
                    </div>
                        <div class="clearfix"></div>
                        <br />
                    <!-- sidebar menu -->
                    @include("layouts.partials.sidebar")
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            @include("layouts.partials.navbar")
            <!-- /top navigation -->
            
            <!-- Page Content -->
            <div class="right_col" role="main">
                @stack("page_header")
                <section class="">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div id="calendar"> --}}
                            </div> <!-- Calendar Container -->
                        </div>
                        @yield("content")
                    </div>
                </section>
            </div>

            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    CopyRight - 2024 Create Design by <a href="#">Von Tevin</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- Include CSS and JavaScript -->
    
    <!-- jQuery -->
    <script src="{{ asset("assets") }}/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset("assets") }}/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="{{ asset("assets") }}/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="{{ asset("assets") }}/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="{{ asset("assets") }}/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="{{ asset("assets") }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="{{ asset("assets") }}/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/jszip/dist/jszip.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset("assets") }}/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- jquery.inputmask -->
    <script src="{{ asset("assets") }}/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- jQuery Knob -->
    <script src="{{ asset("assets") }}/vendors/jquery-knob/dist/jquery.knob.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset("assets") }}/build/js/custom.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.6.15/sweetalert2.all.min.js" 
    integrity="sha512-Kt6r/5Z/2zB2zP5u1J9+zWk9Kr9VHZ6B8pK4C5xjD+bi/9F93zFbxZoKsLZdyFNNPmv8e8t4kZzovXY84qa/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();

            var urlToRedirect = ev.currentTarget.getAttribute('href');

            console.log(urlToRedirect);

            Swal.fire({
                title: 'Are you sure?',
                text: 'This delete will remove the room!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                dangerMode: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = urlToRedirect;
                }
            });
        }
    </script>
    @stack("scripts")

</body>

</html>