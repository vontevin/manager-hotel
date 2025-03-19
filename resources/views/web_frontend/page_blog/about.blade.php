@extends('web_frontend.master_web.fornt_master')

@section('Contact', 'Contact')

@section('content')
    <!-- main-slider -->
    @include('web_frontend.frontwebs.main_slider')
<!-- /About page-->       
<section class="w3l-content-3 card">
    <div class="content-3-mian py-5 card">
        <div class="title-content text-center mb-5">
            <h6 class="sub-title title-with-lines">About Our Hotel</h6>
            <h3 class="hny-title">Discover Comfort and Elegance</h3>
            <p class="fea-para">Our hotel offers a perfect blend of luxury, comfort, and convenience for a memorable stay.</p>
        </div>         
        <div class="container py-lg-5">
            <div class="content-info-in row">
                <div class="col-lg-6">
                    <img src="{{asset('hotel')}}/images/room17.jpg" alt="" class="img-fluid">
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5 about-right-faq align-self  pl-lg-5">
                    <div class="title-content text-left mb-2">
                        <h6 class="sub-title title-with-lines">About Us</h6>
                        <h3 class="hny-title">Experience Luxury and Comfort for Over 25 Years</h3>
                    </div>
                    <p class="mt-3">
                        សូមស្វាគមន៍មកកាន់ <a href="https://maps.app.goo.gl/w3xuqLvvdPfe1zpF7" style="color: #e90000; font-size: 20px">(សណ្ឋាគារ វឌ្ឍនៈរាសី)</a>
                        ដែលយើងខ្ញុំផ្តល់អាទិភាពទៅលើភាពសុខស្រួល និងការពេញចិត្តរបស់អ្នក។ ជាមួយនឹងបទពិសោធន៍ជាង 25 ឆ្នាំនៅក្នុងឧស្សាហកម្មបដិសណ្ឋារកិច្ច 
                        យើងផ្តល់ជូននូវសេវាកម្មពិសេស និងកន្លែងស្នាក់នៅដ៏ប្រណិត។ ក្រុមការងាររបស់យើងប្តេជ្ញាធ្វើឱ្យការស្នាក់នៅរបស់អ្នកមិនអាចបំភ្លេចបាន ដោយផ្តល់ជូននូវសេវាកម្មជាច្រើន 
                        និងសេវាកម្មផ្ទាល់ខ្លួន ដើម្បីធានាថាអ្នកមានអារម្មណ៍នៅផ្ទះ។ ពីជម្រើសនៃការទទួលទានអាហារដ៏ប្រណិត 
                        រហូតដល់ការព្យាបាលស្ប៉ាដែលសម្រាកកាយ យើងមានអ្វីគ្រប់យ៉ាងដែលអ្នកត្រូវការសម្រាប់ការសម្រាកដ៏ល្អឥតខ្ចោះ។
                    </p>
                <a href="{{url('room')}}" class="btn btn-style btn-primary mt-md-5 mt-4">Read More</a>
            </div>
        </div>
    </div>
</section>
<!-- //About page-->

<!-- middle -->
<div class="middle py-5">
    <div class="container py-xl-5 py-lg-3">
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