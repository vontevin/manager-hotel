<!-- resources/views/web_frontend/master_web/fornt_master.blade.php -->
<!doctype html>
<html lang="zxx">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('VATHANAK REASEY HOTEL', 'VATHANAK REASEY HOTEL(សណ្ឋាគារ វឌ្ឍនៈរាសី)')</title> <!-- Dynamic Page Title -->
        
        <!-- Apple Touch Icon -->
        <link rel="icon" href="/hotel/images/photo.jpg" type="image/x-icon">

        <!-- Template CSS -->
        <link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
        <link href="//fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('hotel/css/style-starter.css') }}">
        <link rel="stylesheet" href="{{ asset('hotel/css/top_deal_slide.css') }}">
        
        {{-- Link Google Font Icon --}}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        @stack('custom-css')
        <style>
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
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #007bff;
                border: 1px solid #006fe6;
                color: white;
            }
        </style>
    </head>

    <body>
        <!-- Spinner Start -->
        <div class="spinner-container" id="spinner-container">
            <div class="spinner"></div>
        </div>
        
        <!-- Spinner End -->

        <!--header-->
        @include('web_frontend.frontwebs.topnav') <!-- Top Navigation -->
        <!--/header-->

        <!-- Content Section -->
        @yield('content')

        <!-- footer -->
        @include('web_frontend.frontwebs.foooter') <!-- Footer -->
        <!--//footer -->

        {{-- Swiper Script --}}
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="{{ asset('hotel/js/top_deal_slide.js') }}"></script>

        <!-- Template JavaScript -->
        <script src="{{ asset('hotel/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('hotel/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('hotel/js/theme-change.js') }}"></script>
        <script src="{{ asset('hotel/js/owl.carousel.js') }}"></script>
        <script src="{{ asset('hotel/js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('hotel/js/jquery.countup.js') }}"></script>
        <script src="{{ asset('hotel/js/bootstrap.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- Custom Scripts -->
        <script>
            $(document).ready(function () {
                // Spinner code
                $(window).on('load', function () {
                    $('#spinner-container').fadeOut('slow', function() {
                        $(this).remove();
                    });
                });

                // Magnific Popup
                $('.popup-with-zoom-anim').magnificPopup({
                    type: 'inline',
                    fixedContentPos: false,
                    fixedBgPos: true,
                    overflowY: 'auto',
                    closeBtnInside: true,
                    preloader: false,
                    midClick: true,
                    removalDelay: 300,
                    mainClass: 'my-mfp-zoom-in'
                });

                // Owl Carousel
                $('.owl-one').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: false,
                    responsiveClass: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplaySpeed: 1000,
                    autoplayHoverPause: false,
                    responsive: {
                        0: { items: 1, nav: false },
                        480: { items: 1, nav: false },
                        667: { items: 1, nav: true },
                        1000: { items: 1, nav: true }
                    }
                });

                // Navbar toggle
                $('.navbar-toggler').click(function () {
                    $('body').toggleClass('noscroll');
                });

                $(window).on("scroll", function () {
                    var scroll = $(window).scrollTop();
                    if (scroll >= 80) {
                        $("#site-header").addClass("nav-fixed");
                    } else {
                        $("#site-header").removeClass("nav-fixed");
                    }
                });

                $(".navbar-toggler").on("click", function () {
                    $("header").toggleClass("active");
                });

                $(document).on("ready", function () {
                    if ($(window).width() > 991) {
                        $("header").removeClass("active");
                    }
                    $(window).on("resize", function () {
                        if ($(window).width() > 991) {
                            $("header").removeClass("active");
                        }
                    });
                });

                $('.counter').countUp();
            });
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

        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    allowClear: true
                });
            });
        </script>
        @stack('custom-scripts')
    </body>
</html>
