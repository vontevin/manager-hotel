@extends("layouts.master_app")

@section("content")
<!-- page content -->

<div class="">
    <h3>{{ trans('menu.createManagement') }}</h3>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small>{{ trans('menu.createManagement') }}</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- Create Client Form -->
                    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-12 col-sm-9 col-xs-12">
                            <div class="x_content">
                                <!-- Name Field -->
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="name">{{ trans('menu.name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="email">{{ trans('menu.email') }}</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone Field -->
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="phone">{{ trans('menu.phone') }}</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Address Field -->
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="address">{{ trans('menu.address') }}</label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="description">{{ trans('menu.desType') }}</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Image Field -->
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="image">{{ trans('menu.image') }}</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="mb-3 pull-right">
                                    <a href="{{ route('clients.index') }}" class="btn btn-primary">
                                        <i class="fa fa-close"></i> {{ trans('menu.close') }}
                                    </a>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-save"></i> {{ trans('menu.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- End of Create Client Form -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

@endsection
