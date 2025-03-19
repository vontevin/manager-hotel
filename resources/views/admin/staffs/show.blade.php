@extends("layouts.master_app")
@push("styles")
    <style>
        .x_panel {
            font-family: Hanuman, 'Times New Roman' !important;
            font-weight: 400;
            font-size: 12px;
        }
    </style>
@endpush

@section("content")
<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h3>Staff Details</h3>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="form-group">
                <label for="full_name">{{ trans('menu.name') }}</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $staff->full_name }}" disabled>
            </div>

            <div class="form-group">
                <label for="position">{{ trans('menu.position') }}</label>
                <input type="text" class="form-control" id="position" name="position" value="{{ $staff->position }}" disabled>
            </div>

            <div class="form-group">
                <label for="email">{{ trans('menu.email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $staff->email }}" disabled>
            </div>

            <div class="form-group">
                <label for="phone">{{ trans('menu.phone') }}</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $staff->phone }}" disabled>
            </div>

            <div class="form-group">
                <a href="{{ route('staffs.index') }}" class="btn btn-secondary">{{ trans('menu.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
