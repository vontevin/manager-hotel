@extends("layouts.master_app")
@push("styles")
    <style>
        /* .f_card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            } */
    </style>
@endpush
@section("content")
    <!-- page content -->
    <div class="">
        <h2><i class="fa fa-angle-double-left"></i> {{ trans("menu.editRoomType") }} <i class="fa fa-angle-double-right"></i>
        </h2>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small><i class="fa fa-angle-double-left"></i> {{ trans("menu.editRoomType") }} <i
                                    class="fa fa-angle-double-right"></i></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form action="{{ route("admin.roomtypes.update", $roomType->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="col-md-4 col-sm-3 col-xs-12 profile_left py-2">
                                <h4 class="ff">{{ trans("menu.uploadImage") }}</h4>
                                <input type="file" name="image" class="form-control" id="imageInput" onchange="previewImage(event)"/>

                                @if ($roomType->image)
                                    <img src="{{ Storage::url($roomType->image) }}" class="img-thumbnail" width="450" height="150" id="existingImage"/>
                                @endif
                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: auto; margin-top: 10px;"/>

                                <br />
                                <label style="margin-top: 15px">{{ trans("menu.desType") }}</label>
                                <textarea name="description" class="form-control" rows="4">{{ old("description", $roomType->description) }}</textarea>

                                <label>{{ trans("menu.status") }}</label>
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old("is_active", $roomType->is_active) ? "checked" : "" }} />
                            </div>
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <h4 class="ff">{{ trans("menu.editFormRoomType") }}</h4>
                            </div>
                            <div class="col-md-8 col-sm-9 col-xs-12">
                                <div class="x_content f_card" style="margin-top: 10px">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label>{{ trans("menu.name") }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old("name", $roomType->name) }}">
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label>{{ trans("menu.priceRoom") }}<span style="color: red">*</span></label>
                                        <input type="text" name="price" required="required" class="form-control"
                                            value="{{ old("price", $roomType->price) }}">
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label for="adult">{{ trans("menu.maxAdult") }} <span class="text-danger">*</span></label>
                                        <select name="adult" id="adult" class="form-control">
                                            <option value="">{{ trans("menu.selectAdult") }}</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old("adult", $roomType->adult) == $i ? "selected" : "" }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label for="child">{{ trans("menu.maxChildren") }}</label>
                                        <select name="child" id="child" class="form-control">
                                            <option value="">{{ trans("menu.selectChildren") }}</option>
                                            @for ($i = 0; $i <= 5; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old("child", $roomType->child) == $i ? "selected" : "" }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="x_title">
                                            <label>Amenities</label>
                                        </div>
                                        <div class="row">
                                            @foreach ($amenities as $amenity)
                                                <div class="col-md-4 col-sm-6 col-12 mb-2">
                                                    <div class="x_content form-check">
                                                        <input type="checkbox" name="amenities[]"
                                                            value="{{ $amenity->id }}" class="form-check-input"
                                                            {{ in_array($amenity->id, $selectedAmenities) ? "checked" : "" }}>

                                                        <!-- Display Icon and Name -->
                                                        <label class="form-check-label x_penal">
                                                            @if ($amenity->name == "WiFi")
                                                                <i class="fas fa-wifi"></i>
                                                            @elseif($amenity->name == "Bathtub")
                                                                <i class="fas fa-bath"></i>
                                                            @elseif($amenity->name == "Minibar")
                                                                <i class="fas fa-glass-martini-alt"></i>
                                                            @elseif($amenity->name == "Air Conditioning")
                                                                <i class="fas fa-fan"></i>
                                                            @elseif($amenity->name == "Refrigerator")
                                                                <i class="fas fa-ice-cream"></i>
                                                            @elseif($amenity->name == "Restaurant")
                                                                <i class="fas fa-utensils"></i>
                                                            @elseif($amenity->name == "Swimming Pool")
                                                                <i class="fas fa-swimmer"></i>
                                                            @elseif($amenity->name == "Gym")
                                                                <i class="fas fa-dumbbell"></i>
                                                            @elseif($amenity->name == "Parking")
                                                                <i class="fas fa-parking"></i>
                                                            @elseif($amenity->name == "TV")
                                                                <i class="fas fa-tv"></i>
                                                            @elseif($amenity->name == "Spa")
                                                                <i class="fas fa-spa"></i>
                                                            @elseif($amenity->name == "Breakfast")
                                                                <i class="fas fa-coffee"></i>
                                                            @elseif($amenity->name == "Pet Friendly")
                                                                <i class="fas fa-paw"></i>
                                                            @elseif($amenity->name == "Shuttle Service")
                                                                <i class="fas fa-bus"></i>
                                                            @elseif($amenity->name == "Laundry")
                                                                <i class="fas fa-tshirt"></i>
                                                            @else
                                                                <i class="fas fa-cogs"></i>
                                                                <!-- Default icon if no match found -->
                                                            @endif
                                                            {{ $amenity->name }}

                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group" style="margin-top: 55px">
                                            <div class="mb-3 pull-right">
                                                <a href="{{ route("roomtypes.index") }}" class="btn btn-primary"><i
                                                        class="fa fa-close"></i> {{ trans("menu.close") }}</a>
                                                <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i>
                                                    {{ trans("menu.save") }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
@push("scripts")
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
        const imagePreview = document.getElementById('imagePreview');
        const existingImage = document.getElementById('existingImage');
        
        // Hide the existing image (if any) when a new one is selected
        if (existingImage) {
            existingImage.style.display = 'none';
        }
        
        // Set the preview image
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush