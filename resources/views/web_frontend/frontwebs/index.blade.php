@extends("web_frontend.master_web.fornt_master")

@section("title", "Hotel")

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
<style>
    /* General Section Styling */
    .testimonials {
        background-color: #f9f9f9;
        padding: 40px 20px;
        text-align: center;
        font-family: Arial, sans-serif;
        position: relative;
        overflow: hidden;
    }

    /* Additional CSS code... */
    /* Modal body styling */
    .modal-body {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Button styling */
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 500;
        color: #fff;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 500;
        color: #fff;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    /* Google logo styling */
    .btn-success img {
        width: 20px;
        height: 20px;
    }

    /* Text styling */
    .change_link {
        text-align: center;
        font-size: 14px;
        color: #666;
    }

    .change_link a {
        color: #dc3545;
        text-decoration: none;
        font-weight: 500;
    }

    .change_link a:hover {
        text-decoration: underline;
    }

    /* "Or" divider styling */
    .title-with-lines {
        display: flex;
        align-items: center;
        width: 100%;
        margin: 20px 0;
    }

    .title-with-lines::before,
    .title-with-lines::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #ddd;
    }

    .title-with-lines h6 {
        margin: 0 10px;
        font-size: 14px;
        color: #666;
        text-transform: uppercase;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {

        .btn-primary,
        .btn-success {
            font-size: 14px;
            padding: 8px 16px;
        }

        .btn-success img {
            width: 16px;
            height: 16px;
        }

        .change_link {
            font-size: 12px;
        }

        .title-with-lines h6 {
            font-size: 12px;
        }
    }

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

    .register-title {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

@section("content")
    <!-- main-slider -->
    @include("web_frontend.frontwebs.main_slider")
    <!-- //main-slider -->

    <!-- About page -->
    @include("web_frontend.frontwebs.about")
    <!-- //About page -->

    <!-- Roomtype page -->
    <div class="card">
        @include("web_frontend.frontwebs.roomtype_home")
    </div>

    <!-- //Roomtype page -->

    <!-- Gallery -->
    <div class="card">
        @include("web_frontend.frontwebs.gallery")
    </div>

    {{-- Testimonials --}}
    @include("web_frontend.frontwebs.testimonials")

    <!-- middle section -->
    @include("web_frontend.frontwebs.middle")
    <br />

    <!-- Show Registration Modal only if User is not logged in -->
    @if (!auth()->check())
        <div id="register-modal" class="modal fade" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title register-title" id="registerModalLabel">Register Account</h5>
                        <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Registration Form -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="{{ route("register") }}">
                                    <button type="submit" class="btn w-100"
                                        style="background-color: #0056b3; color: #f7f7f7">
                                        Sign In Account
                                    </button>
                                </a>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="change_link">Already have an account?
                                <a href="{{ route("login") }}" class="text-danger">Login</a>
                            </p>
                        </div>

                        <div class="row">
                            <div class="title-with-lines">
                                <h6>Or</h6>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="{{ route("auth.google") }}" class="btn btn-success w-100">
                                    <img src="{{ asset("hotel/images/google.jpg") }}" alt="Google logo" class="img-fluid">
                                    <span>Login with Google</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('register-modal'));
                myModal.show();
            });
        </script>
    @endif
@endsection
