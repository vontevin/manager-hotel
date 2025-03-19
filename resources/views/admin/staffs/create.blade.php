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
        <h3>Create Staff</h3>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <form action="{{ route('staffs.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="full_name">{{ trans('menu.name') }}</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>

                <div class="form-group">
                    <label for="position">Position</label>
                    <select class="form-control" id="position" name="position" required>
                        <option value="">-- Select Position --</option>
                        <option value="Admin">Admin</option>
                        <option value="Manager">Manager</option>
                        <option value="Receptionist">Receptionist</option>
                    </select>
                </div>
                

                <div class="form-group">
                    <label for="email">{{ trans('menu.email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">{{ trans('menu.phone') }}</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ trans('menu.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
