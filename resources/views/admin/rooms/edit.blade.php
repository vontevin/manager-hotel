@extends("layouts.master_app")

@push("styles")

@endpush

@section("content")
<!-- page content -->
<div class="content-wrapper">
    <h2 class="title">{{ trans("menu.updateRoom") }}</h2>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_title">
            <h2><small>{{ trans("menu.updateRoom") }}</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Room Information Section -->
                <fieldset class="room-info">
                    <legend>{{ trans('menu.roomInformation') }}</legend>

                    <!-- Room Number -->
                    <div class="col-md-6 form-group">
                        <label for="room_number" class="form-label">{{ trans('menu.roomNumber') }} <span class="text-danger">*</span></label>
                        <input type="text" name="room_number" id="room_number" class="form-control" value="{{ old('room_number', $room->room_number) }}" required>
                        @error('room_number')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Room Type -->
                    <div class="col-md-6 form-group">
                        <label for="room_type_id" class="form-label">RoomType <span class="text-danger">*</span></label>
                        <select name="room_type_id" id="room_type_id" class="form-control" required>
                            <option value="">{{ trans('menu.selectbedType') }}</option>
                            @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}" 
                                    {{ (old('room_type_id') == $roomType->id || $room->room_type_id == $roomType->id) ? 'selected' : '' }}>
                                    {{ $roomType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_type_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Floor -->
                    <div class="col-md-6 form-group">
                        <label for="floor" class="form-label">{{ trans('menu.floor') }} <span class="text-danger">*</span></label>
                        <input type="text" name="floor" id="floor" class="form-control" value="{{ old('floor', $room->floor) }}" required>
                        @error('floor')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 form-group">
                        <label for="status" class="form-label">{{ trans('menu.status') }} <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>{{ trans('menu.available') }}</option>
                            <option value="booked" {{ $room->status == 'booked' ? 'selected' : '' }}>Booked</option>
                            <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>{{ trans('menu.maintenance') }}</option>
                        </select>                        
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 form-group">
                        <label for="description" class="form-label">{{ trans('menu.description_s') }}</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $room->description) }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>

                <!-- Submit Section -->
                <div class="form-footer text-right">
                    <a href="{{ url('rooms') }}" class="btn btn-primary"><i class="fa fa-close"></i> {{ trans('menu.close') }}</a>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> {{ trans('menu.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /page content -->

@endsection
