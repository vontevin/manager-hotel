@extends('layouts.master_app')

@push('styles')
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

@section('content')

    <!-- page content -->
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small>{{ trans('menu.viewPackage') }}</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-4 col-sm-3 col-xs-12 profile_left py-2">
                            <h4 class="ff">{{ trans('menu.galleryImages') }}</h4>
                            <div class="carousel-container">
                                <div class="carousel-images">
                                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="img-fluid" />
                                </div>
                                <p class="prev" onclick="moveSlide(-1)">&#10094;</p>
                                <p class="next" onclick="moveSlide(1)">&#10095;</p>
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-9 col-xs-12">
                            <div class="x_content">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h4 class="ff">{{ trans('menu.packagesDetails') }}</h4>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="name">{{ trans('menu.name') }}:</label>
                                    <input type="text" class="form-control" value="{{ $package->name }}" disabled>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="description">{{ trans('menu.description') }}:</label>
                                    <textarea style="height: 105px" class="form-control" id="description" disabled>{{ $package->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="mb-3 pull-right">
                                    <a href="{{ url('packages') }}" class="btn btn-primary"><i class="fa fa-close"></i> {{ trans('menu.close') }}</a>
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
