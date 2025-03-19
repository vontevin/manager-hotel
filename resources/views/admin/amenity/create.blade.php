@extends("layouts.master_app")

@section("content")
<!-- page content -->

<div class="right_col" role="main" style="margin-top: 100px;">
    <h3>Create Amenites</h3>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small>Create Amenites</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- Create Amenity Form -->
                    <form action="{{ route('amenities.store') }}" method="POST">
                        @csrf

                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                            <label for="name">{{ trans('menu.name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="description">{{ trans('menu.desType') }}</label>
                            <textarea name="description" id="description" class="form-control" rows="4" >{{ old('description') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="mb-3 pull-right">
                                    <a href="{{ route('amenities.index') }}" class="btn btn-primary"><i class="fa fa-close"></i> {{ trans('menu.close') }}</a>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> {{ trans('menu.save') }}</button>
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
