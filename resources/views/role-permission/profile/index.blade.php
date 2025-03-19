@extends('layouts.master_app')

@section('content')
<div class="col-md-12">
    <div class="pull-right">
        <div class="close-link">
            <!--- ./ Message box --->
            @if (session("status"))
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        iconColor: 'white',
                        customClass: {
                            popup: 'colored-toast',
                        },
                        showConfirmButton: false,
                        timer: 1200,
                        timerProgressBar: true,
                    })
                    Toast.fire({
                        icon: 'success',
                        title: "{{ session("status") }}",
                    })
                </script>
            @endif
            <!--- ./ End Message box --->
        </div>
    </div>

</div>
<h3>My Profile Account</h3>
<div class="x_panel">
    <div class="x_title">
        <h2>Profile Account</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4 col-sm-3 col-xs-12 profile_left py-2">
                <h4 class="ff">{{ trans("menu.image") }}</h4>
                <div class="profile_img">
                    <div id="crop-avatar">
                        <!-- Display User Avatar -->
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Picture" class="img-thumbnail" width="150">
                        @else
                            <img src="{{ asset('assets/production/images/user_icon.png') }}" alt="Default Profile Picture" class="img-thumbnail" width="150">
                        @endif
                    </div>
                </div>
                <div style="margin-top: 15px">
                    <input type="file" name="avatar" class="form-control"/>
                    @error('avatar') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-8 col-sm-12 col-xs-12">
                <h4 class="ff">Change Profile</h4>
            </div>
            <div class="col-md-8 col-sm-9 col-xs-12">
                <div class="x_content">
                    <div class="form-group">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="mb-3 pull-right">
                        <a href="{{ route('change-password', Auth::id()) }}" class="btn btn-primary"><i class="fa fa-lock"></i> Change Password</a>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Update Profile</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
