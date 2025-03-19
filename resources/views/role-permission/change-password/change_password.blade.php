@extends("layouts.master_app")
@push("styles")
@endpush
@section("content")
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
    <div class="right_col" role="main" style="margin-top: 100px">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>Change Password "{{ Auth::user()->name }}"</h3>
        </div>
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small>Change Password</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form action="{{ route("change-password", ["id" => Auth::id()]) }}" method="POST">
                            @csrf
                            @method("PUT")

                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="password" name="current_password" class="form-control has-feedback-left"
                                    id="current_password" placeholder="Current Password" required>
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                @error("current_password")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="password" name="new_password" class="form-control has-feedback-left"
                                    id="new_password" placeholder="New Password" required>
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                @error("new_password")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="password" name="new_password_confirmation"
                                    class="form-control has-feedback-left" id="new_password_confirmation"
                                    placeholder="Confirm New Password" required>
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                @error("new_password_confirmation")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="mb-3 pull-right">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
@endpush
