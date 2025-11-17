<!-- FOOTER AREA START -->
<footer class="ltn__footer-area">
    <div class="footer-top-area section-bg-1 plr--5">
        <div class="container-fluid">
            <div class="row">

                <!-- About + Address -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget footer-about-widget">
                        <div class="footer-logo">
                            <div class="site-logo">
                                <img src="{{ asset('frontend/img/logo.png') }}" alt="Logo">
                            </div>
                        </div>
                        <p>Hubli connects farmers, distributors, and businesses through a smart supply chain network across Bangladesh.</p>

                        <div class="footer-address">
                            <ul>
                                <li>
                                    <div class="footer-address-icon">
                                        <i class="icon-placeholder"></i>
                                    </div>
                                    <div class="footer-address-info">
                                        <p>Banani, Dhaka 1213, Bangladesh</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="footer-address-icon">
                                        <i class="icon-call"></i>
                                    </div>
                                    <div class="footer-address-info">
                                        <p><a href="tel:+8801700000000">+880 1700-000000</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="footer-address-icon">
                                        <i class="icon-mail"></i>
                                    </div>
                                    <div class="footer-address-info">
                                        <p><a href="mailto:info@hubli.com">info@hubli.com</a></p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="ltn__social-media mt-20">
                            <ul>
                                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Company Links -->
                <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">Company</h4>
                        <div class="footer-menu">
                            <ul>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('news') }}">News</a></li>
                                <li><a href="{{ route('shop') }}">Our Products</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">Services</h4>
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#">Order Tracking</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Return Policy</a></li>
                                <li><a href="#">Delivery Info</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Customer Care -->
                <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">Customer Care</h4>
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Support Center</a></li>
                                <li><a href="#">Report Issue</a></li>
                                <li><a href="{{ route('contact') }}">Contact Support</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="col-xl-3 col-md-6 col-sm-12 col-12">
                    <div class="footer-widget footer-newsletter-widget">
                        <h4 class="footer-title">Newsletter</h4>
                        <p>Subscribe to get updates, new products, and special offers.</p>

                        <div class="footer-newsletter">
                            <form action="#" method="post" style="display: flex; gap: 10px;">
                                <input type="email" name="email" placeholder="Email*" 
                                    style="flex: 1; padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
                                <button class="theme-btn-1 btn" type="submit" 
                                        style="padding: 10px 20px; border-radius: 5px;">
                                    <i class="fas fa-location-arrow"></i>
                                </button>
                            </form>
                        </div>


                        <h5 class="mt-30">We Accept</h5>
                        <img src="{{ asset('frontend/img/icons/payment-4.png') }}" alt="Payment">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="ltn__copyright-area ltn__copyright-2 section-bg-2 ltn__border-top-2--- plr--5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-12">
                    <p>© {{ date('Y') }} Hubli Bangladesh – All Rights Reserved.</p>
                </div>
                <div class="col-md-6 col-12 text-end">
                    <p>Developed by <strong>Phenexsoft</strong></p>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- FOOTER AREA END -->
