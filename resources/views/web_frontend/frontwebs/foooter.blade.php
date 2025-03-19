<!-- footer-66 -->
<footer class="w3l-footer-66">
    <section class="footer-inner-main">
        <div class="footer-hny-grids py-5">
            <div class="container py-lg-4">
                <div class="text-txt">
                    <div class="row newsletter-grids-footer">
                        <div class="col-lg-6 newsletter-text pr-lg-5">
                            <h3 class="hny-title two">{{ trans('menu.newsletter_title') }}</h3>
                            <h4>{{ trans('menu.newsletter_description') }}</h4>
                        </div>
                        <div class="col-lg-6 newsletter-right">
                            <form action="#" method="post" class="footer-newsletter">
                                <input type="email" name="email" class="form-input" placeholder="{{ trans('menu.enter_email') }}">
                                <button type="submit" class="btn">{{ trans('menu.subscribe_button') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="row sub-columns">
                            <div class="col-lg-4 col-md-6 sub-one-left pr-lg-4">
                                <h2><a class="navbar-brand" href="index.html">
                                    <span>{{trans('menu.h')}}</span>{{trans('menu.otel')}}
                                    </a></h2>
                                    <p class="pr-lg-4">{{ trans('menu.hotel_description') }}</p>
                                    <div class="columns-2">
                                        <ul class="social">
                                            <li><a href="https://www.facebook.com" target="_blank"><span class="fa fa-facebook" aria-hidden="true"></span></a></li>
                                            <li><a href="https://www.linkedin.com" target="_blank"><span class="fa fa-linkedin" aria-hidden="true"></span></a></li>
                                            <li><a href="https://twitter.com" target="_blank"><span class="fa fa-twitter" aria-hidden="true"></span></a></li>
                                            <li><a href="https://plus.google.com" target="_blank"><span class="fa fa-google-plus" aria-hidden="true"></span></a></li>
                                            <li><a href="https://github.com" target="_blank"><span class="fa fa-github" aria-hidden="true"></span></a></li>
                                        </ul>
                                    </div>
                            </div>
                            <div class="col-lg-4 col-md-6 sub-one-left">
                                <h6>{{trans('menu.our_services')}}</h6>
                                <div class="mid-footer-gd sub-two-right">
                                    <ul>
                                        <li><a href="about.html"><span class="fa fa-angle-double-right mr-2"></span> {{ trans('menu.about_us') }}</a></li>
                                        <li><a href="#"><span class="fa fa-angle-double-right mr-2"></span> {{ trans('menu.accommodations') }}</a></li>
                                        <li><a href="#"><span class="fa fa-angle-double-right mr-2"></span> {{ trans('menu.dining_options') }}</a></li>
                                        <li><a href="#"><span class="fa fa-angle-double-right mr-2"></span> {{ trans('menu.spa_wellness') }}</a></li>
                                    </ul>
                                    <ul>
                                        <li><a href="#"><span class="fa fa-angle-double-right mr-2"></span> {{ trans('menu.events_meetings') }}</a></li>
                                        <li><a href="#"><span class="fa fa-angle-double-right mr-2"></span> {{ trans('menu.special_offers') }}</a></li>
                                        <li><a href="#support"><span class="fa fa-angle-double-right mr-2"></span> {{ trans('menu.career_opportunities') }}</a></li>
                                        <li><a href="{{ route('contact') }}"><span class="fa fa-angle-double-right mr-2"></span> {{ trans('menu.contact_us') }}</a></li>
                                    </ul>
                                </div>
                                </div>
                                    <div class="col-lg-4 col-md-6 sub-one-left">
                                        <h6>{{ trans('menu.contact_info') }}</h6>
                                        <div class="sub-contact-info">
                                            <p>{{ trans('menu.address') }}: <a href="https://maps.app.goo.gl/w3xuqLvvdPfe1zpF7" style="color: white">{{ trans('menu.hotel_address') }}.</a></p>
                                            <p class="my-3">{{ trans('menu.phone') }}: <strong><a href="tel:012432082">012432082</a></strong></p>
                                            <p>{{ trans('menu.email') }}:<strong> <a href="mailto:info@example.com">info@example.com</a></strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="below-section">
                    <div class="container">
                        <div class="copyright-footer">
                            <div class="columns text-lg-left">
                                <p>© 2024 {{ trans('menu.hotel_name') }}. {{ trans('menu.rights_reserved') }} || <a href="#">{{ trans('menu.hotel_full_name') }}</a></p>
                            </div>
                            <ul class="columns text-lg-right">
                                <li><a href="#">{{ trans('menu.privacy_policy') }}</a></li>
                                <li>|</li>
                                <li><a href="#">{{ trans('menu.terms_of_use') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- copyright -->
        <!-- move top -->
        <button onclick="topFunction()" id="movetop" title="Go to top">
            <span class="fa fa-long-arrow-up" aria-hidden="true"></span>
        </button>
        <script>
            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function () {
            scrollFunction()
            };

            function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").style.display = "block";
            } else {
                document.getElementById("movetop").style.display = "none";
            }
            }

            // When the user clicks on the button, scroll to the top of the document
            function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
            }
        </script>
        <!-- /move top -->

    </section>
</footer>
<!--//footer-66 -->
