@extends("layouts.master_app")

@push("styles")
    <style>
        /* Additional styling if needed */
    </style>
@endpush

@section("content")

<!-- page content -->
<div class="">
    <h2><i class="fa fa-angle-double-left"></i> {{ trans('menu.roomTypeDetails') }} <i class="fa fa-angle-double-right"></i></h2>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small><i class="fa fa-angle-double-left"></i> {{ trans('menu.roomTypeDetails') }} <i class="fa fa-angle-double-right"></i></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-4 col-sm-3 col-xs-12 profile_left py-2">
                        <h4 class="ff">{{ trans('menu.uploadImage') }}</h4>
                        <img src="{{ Storage::url($roomType->image) }}" alt="Room Image" class="img-responsive" />
                        <br/>
                        <label style="margin-top: 15px">{{ trans('menu.desType') }}</label>
                        <textarea class="form-control" rows="4" readonly>{{ $roomType->description }}</textarea>

                        <label>{{ trans('menu.status') }}</label>
                        <input type="checkbox" disabled {{ $roomType->is_active ? 'checked' : '' }} />
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <h4 class="ff">{{ trans('menu.detailsRoomType') }}</h4>
                    </div>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <div class="x_content f_card" style="margin-top: 10px">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                <label>{{ trans('menu.name') }}</label>
                                <input type="text" class="form-control" value="{{ $roomType->name }}" readonly>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                <label>{{ trans('menu.priceRoom') }}</label>
                                <input type="text" class="form-control" value="{{ $roomType->price }}" readonly>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                <label>{{ trans('menu.maxAdult') }}</label>
                                <input type="text" class="form-control" value="{{ $roomType->adult }}" readonly>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                <label>{{ trans('menu.maxChildren') }}</label>
                                <input type="text" class="form-control" value="{{ $roomType->child }}" readonly>
                            </div><br>
                            <div class="form-group">
                                <div class="x_title">
                                    <label>Amenities</label>
                                </div>
                                <div class="row">
                                    @foreach ($roomType->amenities as $amenity)
                                        <div class="col-md-4 col-sm-6 col-12 mb-2">
                                            <div class="x_content form-check">
                                                <input type="checkbox" disabled checked>
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
                            
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-12">
                        <div class="form-group" style="margin-top: 55px">
                            <div class="mb-3 pull-right">
                                <a href="{{url('roomtypes')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ trans("menu.close") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection