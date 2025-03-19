@extends("layouts.master_app")

@section("content")
<div class="right_col" role="main" style="margin-top: 100px;">
    <h3>Edit Amenity</h3>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small>Edit Amenity Details</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('amenities.update', $amenity->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Name Field -->
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $amenity->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $amenity->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="mb-3 pull-right">
                                    <a href="{{ route('amenities.index') }}" class="btn btn-primary"><i class="fa fa-close"></i> Cancel</a>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Save Changes</button>
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