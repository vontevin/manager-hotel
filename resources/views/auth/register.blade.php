@extends('layouts.master_login_app')

@section('title', 'Register Account')

@section('content')
<div class="login_wrapper">
    <!-- Registration Form -->
    <div class="login_content">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Rister Acount</h1>

            <div class="mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Username" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 position-relative">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" required autocomplete="new-password">
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                    <i id="togglePasswordIcon" class="fa fa-eye"></i>
                </span>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary w-100">
                        Signup
                    </button>
                </div>
            </div>

            <div class=" mt-4">
                <p class="change_link">Already have an account?
                    <a href="{{ route('login') }}" class="text-danger">Login</a>
                </p>
            </div>

            <div class="row">
                <div class="title-with-lines">
                    <h6>Or</h6>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ route('auth.google') }}" class="btn btn-success w-100">
                        <img src="{{ asset('hotel/images/google.jpg') }}" alt="Google logo" class="img-fluid">
                        <span>Login with Google</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
