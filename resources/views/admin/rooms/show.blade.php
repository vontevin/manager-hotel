@extends("layouts.master_app")
@push("styles")
<style>
    .carousel-container {
        position: relative;
        width: 80%;
        max-width: 600px;
        margin: auto;
        overflow: hidden;
    }

    .carousel-images {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .carousel-images img {
        width: 100%;
        border-radius: 8px;
    }

    .prev, .next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.7);
        color: #333;
        padding: 10px;
        cursor: pointer;
        border: 2px solid #ccc;
        border-radius: 50%;
        font-size: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s, color 0.3s;
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }

    .prev:hover, .next:hover {
        background-color: rgba(255, 255, 255, 0.9);
        color: #000;
        border-color: #999;
    }

    /* Dots styling */
    .owl-dots {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .owl-dot {
        display: flex;
        width: 12px;
        height: 12px;
        background-color: #ccc;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .owl-dot.active {
        background-color: #ff0000; /* Active dot color */
    }

</style>
@endpush
@section("content")

    <!-- page content -->
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small>{{ trans("menu.viewRoom") }}</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                    </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                            </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form action="{{ url('admin.rooms.show') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="col-md-4 col-sm-3 col-xs-12 profile_left py-2">
                                <h4 class="ff">{{ trans("menu.imageRoom") }}</h4>
                                <div class="carousel-container">
                                    <!-- Carousel or gallery of all rooms -->
                                    <div class="carousel-images">
                                        @if(isset($roomType->image)) 
                                            <img src="{{ asset($roomType->image) }}" alt="{{ $roomType->name }}" class="main-image">
                                        @endif

                                        <!-- Static images (if needed) -->
                                        <img src="{{ asset('hotel/images/room7.jpg') }}" alt="Room Image">
                                        <img src="{{ asset('hotel/images/room20.jpg') }}" alt="Room Image">
                                        <img src="{{ asset('hotel/images/room15.jpg') }}" alt="Room Image">
                                        <img src="{{ asset('hotel/images/room10.jpg') }}" alt="Room Image">

                                    </div>
                                
                                    <p class="prev" onclick="moveSlide(-1)">&#10094;</p>
                                    <p class="next" onclick="moveSlide(1)">&#10095;</p>
                                </div>
                                
                                <!-- Room Facilities Section -->
                                <div class="room-facilities">
                                    <div class="facilities-icons">
                                        <div class="facility-item">
                                            <i class="fas fa-wifi" aria-hidden="true" title="{{ trans('menu.wifi') }}"></i>
                                            <p>{{ trans('menu.wifi') }}</p>
                                        </div>
                                        <div class="facility-item">
                                            <i class="fas fa-parking" aria-hidden="true" title="{{ trans('menu.parking_space') }}"></i>
                                            <p>{{ trans('menu.parking_space') }}</p>
                                        </div>
                                        <div class="facility-item">
                                            <i class="fas fa-dumbbell" aria-hidden="true" title="{{ trans('menu.gym') }}"></i>
                                            <p>{{ trans('menu.gym') }}</p>
                                        </div>
                                        <div class="facility-item">
                                            <i class="fas fa-coffee" aria-hidden="true" title="{{ trans('menu.coffee') }}"></i>
                                            <p>{{ trans('menu.coffee') }}</p>
                                        </div>
                                        <div class="facility-item">
                                            <i class="fas fa-bath" aria-hidden="true" title="{{ trans('menu.bath') }}"></i>
                                            <p>{{ trans('menu.bath') }}</p>
                                        </div>
                                        <div class="facility-item">
                                            <i class="fas fa-swimmer" aria-hidden="true" title="{{ trans('menu.swimming_pool') }}"></i>
                                            <p>{{ trans('menu.swimming_pool') }}</p>
                                        </div>
                                        <div class="facility-item">
                                            <i class="fas fa-utensils" aria-hidden="true" title="{{ trans('menu.breakfast') }}"></i>
                                            <p>{{ trans('menu.breakfast') }}</p>
                                        </div>
                                        <div class="facility-item">
                                            <i class="fas fa-glass-martini-alt" aria-hidden="true" title="{{ trans('menu.drinks') }}"></i>
                                            <p>{{ trans('menu.drinks') }}</p>
                                        </div>
                                    </div>
                                    <!-- Hotel Rules Section -->
                                    <div class="hotel-rules">
                                        <div class="section-title">{{ trans('menu.hotel_rules') }}</div>
                                        <p>{{ trans('menu.hotel_rules_desc') }}</p>
                                        <ul>
                                            <li>{{ trans('menu.check_in') }}: 3:00 PM - 9:00 PM</li>
                                            <li>{{ trans('menu.check_out') }}: 10:30 AM</li>
                                            <li>{{ trans('menu.no_pets') }}</li>
                                            <li>{{ trans('menu.no_smoking') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-sm-9 col-xs-12">
                                <div class="x_content ">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h4 class="ff">{{ trans("menu.listViewRoom") }}</h4>
                                        </div>
                                    
                                    <!-- Room Type Details -->
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label for="room_number">{{ trans("menu.roomNumber") }}:</label>
                                        <input type="text" class="form-control" value="{{ $room->room_number }}" disabled>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label for="room_type_id">{{ trans("menu.roomType") }}:</label>
                                        <input type="text" class="form-control" value="{{ $room->roomType->name }}" disabled>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label for="floor">{{ trans("menu.floor") }}:</label>
                                        <input type="text" class="form-control" value="{{ $room->floor }}" disabled>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label for="status">{{ trans("menu.status") }}:</label>
                                        <input type="text" class="form-control" value="{{ ucfirst($room->status) }}" disabled>
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                        <label for="description">{{ trans("menu.description") }}:</label>
                                        <textarea class="form-control" id="description" disabled>{{ $room->description }}</textarea>
                                    </div>                                    
                                    
                                </div>
                                <!-- start of user-activity-graph -->
                                <div id="graph_bar" style="width:100%; height:280px;"></div>
                                <!-- end of user-activity-graph -->
                            </div>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="mb-3 pull-right">
                                        <a href="{{url('rooms')}}" class="btn btn-primary"><i class="fa fa-close"></i> {{trans('menu.close')}}</a>
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
<script>
    // Carousel Slide Movement
    let currentIndex = 0;

    function moveSlide(step) {
        const imagesContainer = document.querySelector('.carousel-images');
        const totalImages = imagesContainer.children.length;

        // Update index based on step (previous/next)
        currentIndex += step;

        // Wrap around if we reach either end
        if (currentIndex >= totalImages) {
            currentIndex = 0;
        } else if (currentIndex < 0) {
            currentIndex = totalImages - 1;
        }

        // Move the slide by translating the container
        const translateXValue = -currentIndex * 100; // Shift by 100% per image
        imagesContainer.style.transform = `translateX(${translateXValue}%)`;
    }
</script>