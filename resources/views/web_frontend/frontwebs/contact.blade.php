@extends('web_frontend.master_web.fornt_master')

@section('Contact', 'Contact')

@section('content')
     <!-- main-slider -->
     @include('web_frontend.frontwebs.main_slider')
     <!-- //banner-slider-->

     <!-- //about breadcrumb -->
<section class="w3l-contact-11">
    <div class="form-41-mian py-5 card" style="background-color:#ffffff">
        <div class="container py-lg-4">
            <div class="row align-form-map">
                <div class="col-lg-6 contact-left pr-lg-4">
                    <div class="partners">
                    <div class="cont-details">
                        <div class="title-content text-left">
                            <h6 class="sub-title">Contact KH</h6>
                            <h3 class="hny-title">Get In Touch</h3>
                        </div>
                        <p class="mt-3 mb-4 pr-lg-5">Hi there, We are available 24/7 by fax, e-mail or by phone. Drop us a line so we can talk further about that.</p>
                        <h6 class="mb-4">For more info or inquiry about our products, projects, and pricing, please feel free to get in touch with us.</h6>                        
                    </div>
                    <div class="hours">
                        <h6 class="mt-4">Email:</h6>
                        <p> <a href="mailto:hotelbookin@gmail.com">
                            hotelbookin@gmail.com</a></p>
                        <h6 class="mt-4">Address:</h6>
                        <p><a href="https://maps.app.goo.gl/w3xuqLvvdPfe1zpF7"> VATHANAK REASEY HOTEL
                            9V5P+H9P, NR6, Krong Siem Reap,</a></p>
                        <h6 class="mt-4">Contact:</h6>
                        <p class="margin-top"><a href="tel:+(885) 255 999 8899">+(885)
                            012432082</a></p>
                    </div>
                    </div>
                </div>
                <div class="col-lg-6 form-inner-cont">
                    <div class="title-content text-left">
                        <h3 class="hny-title mb-lg-5 mb-4">Send Us A Message</h3>
                    </div>
                <form action="https://sendmail.w3layouts.com/submitForm" method="post" class="signin-form">
                    <div class="form-input">
                    <input type="text" name="w3lName" id="w3lName" placeholder="Name" />
                    </div>
                    <div class="row con-two">
                    <div class="col-lg-6 form-input">
                    <input type="email" name="w3lSender" id="w3lSender" placeholder="Email" required="" />
                    </div>
                    <div class="col-lg-6 form-input">
                        <input type="text" name="w3lSubect" placeholder="Subject" class="contact-input" />
                    </div>
                    </div>
                    <div class="form-input">
                    <textarea placeholder="Message" name="w3lMessage" id="w3lMessage" required=""></textarea>
                    </div>
                    <div class="submit-button text-lg-right">
                    <button type="submit" class="btn btn-style">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map Embed -->
    <div class="map card">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3881.860265062464!2d103.88336597603376!3d13.35896360626542!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31101793f90791a9%3A0xa0a136c3870c4!2z4Z6f4Z6O4Z-S4Z6L4Z624Z6C4Z624Z6aIOGenOGejOGfkuGejeGek-GfiOGemuGetuGen-GeuA!5e0!3m2!1skm!2skh!4v1726729305064!5m2!1skm!2skh"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
    <br/>
    
</section>
<!-- //contact-form -->
@endsection
