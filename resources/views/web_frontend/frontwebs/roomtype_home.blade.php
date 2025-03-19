
<div class="container body-item swiper">
    <div class="card-wrapper">
        <div class="title-content text-center mb-5">
            <h6 class="sub-title title-with-lines">{{ trans('menu.welcometoourhotel') }}</h6>
            <h4 class="hny-title">{{ trans('menu.discoverourroomtypes') }}</h4>
            <p class="fea-para">{{ trans('menu.experienceunparalleledcomfort') }}</p>
        </div>        
        <url class="card-list swiper-wrapper">
            @foreach ($roomtypes as $roomtype)
                    <li class="card-item swiper-slide">
                        <div class="card-link deal-content">
                            <img src="{{ Storage::url($roomtype->image) }}"  alt="Card Image" class="card-image">
                            <h2 class="deal-hotel-name" style="margin-top: 12px">{{ Str::limit ( $roomtype->name , 21) }}</h2>
                            <div class="deal-rating">★★★★☆
                                <div class="rating-text">{{ trans('menu.guest_rating', ['rating' => 3.5, 'max' => 5]) }}</div>
                            </div>
                            
                            
                            <h2 class="card-title">{{ Str::limit ($roomtype->description, 50) }}</h2>
                            <div class="deal-pricing" style="margin-top: 25px;">
                                <span style="color: rgb(255, 255, 255)">From</span>
                                
                                @php
                                    $currency = session('currency', 'USD'); // Default to USD if no currency is set
                                    $exchangeRate = 4100; // Example exchange rate
                                @endphp
                                <h4 class="deal-price" style="color: black"> 
                                    @if ($currency == 'KHR')
                                        {{ number_format($roomtype->price * $exchangeRate) }} ៛
                                    @else
                                        ${{ $roomtype->price }}
                                    @endif
                                </h4>
                                {{-- <span class="deal-original-price" style="color: black">$480</span> --}}
                            </div>                
                            <a href="{{ url('room') }}" class="hny-title" style="font-size: 18px; margin-left: 45px">{{trans('menu.book_nows')}}</a>                           
                        </div>
                    </li>
            @endforeach
        </url>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>
</div>

