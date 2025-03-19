@extends("layouts.master_app")

@push("styles")
@endpush

@section("content")
<div>
    <h3>Add New Room</h3>
</div>
<!-- Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small>Room Information</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Section -->
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Room Number <span class="text-danger">*</span></label>
                                    <input type="text" name="room_number" class="form-control" value="{{ old('room_number') }}">
                                    <small class="text-muted">Must be unique</small>
                                    @error('room_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Floor <span class="text-danger">*</span></label>
                                    <input type="text" name="floor" class="form-control" value="{{ old('floor') }}" required>
                                    @error('floor')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans("menu.status") }} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Section -->
                            <div class="col-lg-8 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="room_type_id">Room Type <span class="text-danger">*</span></label>
                                    <select name="room_type_id" id="room_type_id" class="form-control" required>
                                        <option value="">-- Select Room Type --</option>
                                        @foreach ($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}" {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                                {{ $roomType->name}} - ${{ number_format($roomType->price, 2) }} per night
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                <div class="form-group">
                                    <label>{{ trans("menu.desType") }}</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                    <small class="text-muted">Add any special notes or information about this room</small>
                                </div>
                            </div>
                            
                        </div>

                        <!-- Button Section -->
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ url('rooms') }}" class="btn btn-primary">
                                    <i class="fa fa-close"></i> {{ trans('menu.close') }}
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-save"></i> {{ trans('menu.save') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>  
            </div>
        </div>
    </div>
</div>

@endsection
