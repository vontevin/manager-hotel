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
        <h3>Edit Staff</h3>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <form action="{{ route('staffs.update', $staff->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="full_name">{{ trans('menu.name') }}</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $staff->full_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="position">{{ trans('menu.position') }}</label>
                    <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $staff->position) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">{{ trans('menu.email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $staff->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">{{ trans('menu.phone') }}</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $staff->phone) }}" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ trans('menu.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
