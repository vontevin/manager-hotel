@extends('web_frontend.master_web.fornt_master')

@push('custom-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endpush


@section('content')
    <!-- main-slider -->
    @include('web_frontend.frontwebs.main_slider')

    <div class="baners py-5">
        <div class="services">
            <h2 class="title-with-lines">{{ trans('menu.title') }}</h2>
            <p class="subtitle">{{ trans('menu.subtitle') }}</p>
            <div class="service-columns">
                <div class="column">
                    <p>
                        {{ trans('menu.title_scrip') }}
                    </p>
                    <a href="{{url('room')}}" class="btn btn-style btn-primary mt-md-5 mt-4">{{trans('menu.book_now')}}</a>
                </div>
                <div class="column">
                    <h3>{{ trans('menu.hotel_services') }}</h3>
                    <ul>
                        <li><i class="fas fa-car"></i> {{ trans('menu.car_rental') }}</li>
                        <li><i class="fas fa-utensils"></i> {{ trans('menu.catering') }}</li>
                        <li><i class="fas fa-concierge-bell"></i> {{ trans('menu.concierge') }}</li>
                        <li><i class="fas fa-envelope"></i> {{ trans('menu.courier') }}</li>
                        <li><i class="fas fa-user-md"></i> {{ trans('menu.doctor_on_call') }}</li>
                        <li><i class="fas fa-tshirt"></i> {{ trans('menu.dry_cleaning') }}</li>
                        <li><i class="fas fa-map-marked-alt"></i> {{ trans('menu.excursions') }}</li>
                        <li><i class="fas fa-flower"></i> {{ trans('menu.flower_arrangement') }}</li>
                        <li><i class="fas fa-iron"></i> {{ trans('menu.ironing') }}</li>
                        <li><i class="fas fa-soap"></i> {{ trans('menu.laundry') }}</li>
                        <li><i class="fas fa-mail-bulk"></i> {{ trans('menu.mail') }}</li>
                        <li><i class="fas fa-concierge-bell"></i> {{ trans('menu.room_service') }}</li>
                        <li><i class="fas fa-shoe-prints"></i> {{ trans('menu.shoeshine') }}</li>
                        <li><i class="fas fa-ticket-alt"></i> {{ trans('menu.ticket_service') }}</li>
                        <li><i class="fas fa-car-side"></i> {{ trans('menu.transfer_limo') }}</li>
                        <li><i class="fas fa-car-electric"></i> {{ trans('menu.tesla_transfer') }} <span class="new">{{ trans('menu.new') }}</span></li>
                        <li><i class="fas fa-bed"></i> {{ trans('menu.turndown_service') }}</li>
                    </ul>
                </div>
                <div class="column">
                    <h3>{{ trans('menu.hotel_facilities') }}</h3>
                    <ul>
                        <li><i class="fas fa-utensils"></i> <a href="#">{{ trans('menu.banquet_facilities') }}</a></li>
                        <li><i class="fas fa-glass-martini"></i> <a href="#">{{ trans('menu.bar') }}</a></li>
                        <li><i class="fas fa-desktop"></i> {{ trans('menu.computer_facility') }}</li>
                        <li><i class="fas fa-handshake"></i> {{ trans('menu.conference_facilities') }}</li>
                        <li><i class="fas fa-wheelchair"></i> {{ trans('menu.disabled_room') }}</li>
                        <li><i class="fas fa-dumbbell"></i> {{ trans('menu.fitness_room') }}</li>
                        <li><i class="fas fa-hot-tub"></i> {{ trans('menu.sauna') }}</li>
                        <li><i class="fas fa-suitcase-rolling"></i> {{ trans('menu.luggage_storage') }}</li>
                        <li><i class="fas fa-smoking-ban"></i> {{ trans('menu.non_smoking_rooms') }}</li>
                        <li><i class="fas fa-parking"></i> {{ trans('menu.parking') }}</li>
                        <li><i class="fas fa-paw"></i> {{ trans('menu.pet_friendly') }}</li>
                        <li><i class="fas fa-utensils"></i> <a href="#">{{ trans('menu.restaurant') }}</a></li>
                        <li><i class="fas fa-wifi"></i> {{ trans('menu.wifi') }}</li>
                    </ul>
                </div>
                
            </div>
        </div>
        
    </div>     
    <!-- Offers & Packages Section -->
    <div class="offers-section">
        <h2 class="offers-title title-with-lines">{{ trans('menu.offers_title') }}</h2>
        <div class="offers-grid">
            <!-- Static Offer Items (No Database) -->
            @foreach ($packages as $package)
                <div class="offer-item">
                    <div class="offer-image">
                        <img src="{{ asset('storage/' . $package->image) }}" alt="Hotel Rewards Program">
                    </div>
                    <div class="offer-content">
                        <h5>{{$package->price}}</h5>
                        <p>{{ Str::limit ($package->description, 130) }}.</p>
                        <a href="{{url('room')}}">Learn more »</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- //About page-->
    <!-- middle -->
    <div class="middle py-5">
        <div class="baners py-xl-5 py-lg-3">
            <div class="welcome-left text-left py-3">
                <div class="title-content">
                    <h6 class="sub-title" style="color: #e90000">Contact Us</h6>
                    <h3 class="hny-title two mb-2">Experience Luxury and Comfort Like Never Before</h3>
                    <p>Have questions about your stay? Give us a call today at <a href="tel:+(885) 95 441 931">+(885) 95 441 931</a></p>
                </div>
                <a href="#" class="btn btn-white mt-md-5 mt-4 mr-sm-2">Explore Our Amenities</a>
                <a href="{{route('contact')}}" class="btn btn-white-active btn-primary mt-md-5 mt-4">Get in Touch</a>
            </div>
        </div>
    </div><br/>
    <!-- //middle -->
    
@endsection