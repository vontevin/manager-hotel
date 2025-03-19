@extends("layouts.master_app")
@push("styles")
    
@endpush
@section("content")
    <div class="right_col" role="main" style="margin-top: 100px">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>{{ trans("menu.formedit") }}</h3>
        </div>
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small>Edit User Managerment</small></h2>
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
                        <form action="{{ url('users/'.$user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control has-feedback-left" id="inputSuccess2" placeholder="{{trans('menu.name')}}">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="email" value="{{ $user->email }}" class="form-control has-feedback-left" id="inputSuccess4" placeholder="{{trans('menu.email')}}">
                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                            </div>
            
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="password" name="password" class="form-control has-feedback-left" id="inputSuccess4" placeholder="{{trans('menu.password')}}">
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <label for="">{{trans('menu.role')}} <span class="required">*</span></label>
                                <div class="mb-3">
                                    <select name="roles[]" class="form-control" multiple>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option 
                                                value="{{ $role }}"
                                                {{ in_array( $role, $userRoles ) ? 'selected':'' }}
                                            >
                                                {{ $role }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>  
                            </div>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="mb-3 pull-right">
                                        <a href="{{ route("users.index") }}" class="btn btn-primary"><i class="fa fa-close"></i> {{trans('menu.close')}}</a>
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> {{trans('menu.save')}}</button>
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
