<style>
    .special-link a, .theme-btn-1{
        padding: 10px 20px;
        background: #66A931;
        color: #fff;
        border-radius: 8px;
        display: inline-block;
    }
    .btn-transparent {
        padding: 10px 20px;
        border-radius: 8px;
        display: inline-block;
    }
    .header-search-1-form, .ltn__utilize-menu-search-form {
        /* position: relative !important; */
    }
    .header-search-1-form.search-open {
        overflow: visible !important;
    }
    .search-suggestions {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        right: 0 !important;
        background: #fff !important;
        border: 1px solid #ddd !important;
        z-index: 999999 !important;
        max-height: 400px !important;
        overflow-y: auto !important;
        display: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
        text-align: left !important;
    }
    .suggestion-item {
        display: flex !important;
        padding: 10px !important;
        border-bottom: 1px solid #eee !important;
        cursor: pointer !important;
        align-items: center !important;
        text-decoration: none !important;
        color: inherit !important;
    }
    .suggestion-item:last-child {
        border-bottom: none;
    }
    .suggestion-item:hover {
        background: #f9f9f9;
        color: #66A931;
    }
    .suggestion-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 15px;
        border-radius: 4px;
    }
    .suggestion-info {
        flex: 1;
    }
    .suggestion-name {
        font-weight: 600;
        display: block;
        font-size: 14px;
        margin-bottom: 2px;
    }
    .suggestion-price {
        color: #66A931;
        font-size: 13px;
        font-weight: 700;
    }
    .search-all-btn {
        display: block;
        padding: 10px;
        text-align: center;
        background: #f8f9fa;
        color: #66A931;
        font-weight: 600;
        border-top: 1px solid #eee;
    }

    /* Toaster Styles */
    #toaster-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999999;
    }
    .toaster {
        background: #66A931;
        color: #fff;
        padding: 15px 25px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        animation: slideIn 0.3s ease forwards;
        min-width: 250px;
    }
    .toaster.error {
        background: #e74c3c;
    }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>

<div id="toaster-container"></div>
    <header class="ltn__header-area ltn__header-5 ltn__header-transparent-- gradient-color-4---">
        <!-- ltn__header-top-area start -->
        {{--<div class="ltn__header-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="ltn__top-bar-menu">
                            <ul>
                                <li><a href="locations.html"><i class="icon-placeholder"></i> 15/A, Nest Tower, NYC</a></li>
                                <li><a href="mailto:info@webmail.com?Subject=Flower%20greetings%20to%20you"><i class="icon-mail"></i> info@webmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="top-bar-right text-right text-end">
                            <div class="ltn__top-bar-menu">
                                <ul>
                                    <li>
                                        <!-- ltn__language-menu -->
                                        <div class="ltn__drop-menu ltn__currency-menu ltn__language-menu">
                                            <ul>
                                                <li><a href="#" class="dropdown-toggle"><span class="active-currency">English</span></a>
                                                    <ul>
                                                        <li><a href="#">Arabic</a></li>
                                                        <li><a href="#">Bengali</a></li>
                                                        <li><a href="#">Chinese</a></li>
                                                        <li><a href="#">English</a></li>
                                                        <li><a href="#">French</a></li>
                                                        <li><a href="#">Hindi</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <!-- ltn__social-media -->
                                        <div class="ltn__social-media">
                                            <ul>
                                                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                                
                                                <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                                <li><a href="#" title="Dribbble"><i class="fab fa-dribbble"></i></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
        <!-- ltn__header-top-area end -->

        <!-- ltn__header-middle-area start -->
        <div class="ltn__header-middle-area  ltn__sticky-bg-white ltn__logo-right-menu-option plr--9---">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="site-logo-wrap">
                            <div class="site-logo">
                                <a href="{{ route('home') }}"><img
                                        src="{{ route('imagecache', ['template'=>'original','filename' => $ws->logo_alt()]) }}"
                                        alt="{{ $ws->website_title ?? '' }}"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col header-menu-column menu-color-white---">
                        <div class="header-menu d-none d-xl-block">
                            <nav>
                                <div class="ltn__main-menu">
                                    <ul>
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        <li><a href="{{ route('about') }}">About</a></li>
                                        <li><a href="{{ route('shop') }}">Shop</a> </li>
                                        <li><a href="{{ route('news') }}">News</a></li>
                                        <li><a href="{{ route('contact') }}">Contact</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <div class="ltn__header-options ltn__header-options-2 mb-sm-20">
                        <!-- header-search-1 -->
                        <div class="header-search-wrap">
                            <div class="header-search-1">
                                <div class="search-icon">
                                    <i class="icon-search for-search-show"></i>
                                    <i class="icon-cancel  for-search-close"></i>
                                </div>
                            </div>
                            <div class="header-search-1-form">
                                <form method="get" action="{{ route('shop') }}" id="global-search-form">
                                    <input type="text" name="search" id="global-search-input" value="" placeholder="Search here..." autocomplete="off" />
                                    <button type="submit">
                                        <span><i class="icon-search"></i></span>
                                    </button>
                                </form>
                                <div id="search-suggestions-container" class="search-suggestions"></div>
                            </div>
                        </div>
                        <!-- user-menu -->
                        <div class="ltn__drop-menu user-menu">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-user"></i></a>
                                    <ul>
                                        @if(Auth::check())
                                        @php $user = auth()->user(); @endphp
                                        @if ($user->hasRole('admin'))
                                        <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                        @endif
                                        <li><a href="{{ route('user.dashboard') }}">Member Dashboard</a></li>
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="#">Wishlist</a></li>
                                        <li><a href="{{ route('logout') }}">Log out</a></li>
                                        @else
                                        <li><a href="{{ route('login') }}">Log in</a></li>
                                        <li><a href="{{ route('login') }}">Register</a></li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- mini-cart -->
                        <div class="mini-cart-icon">
                            <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                                <i class="icon-shopping-cart"></i>
                                <sup id="cart-count">{{ $cartCount ?? 0 }}</sup>
                            </a>
                        </div>
                        <div class="special-link d-none d-xl-block ms-3"><a href="{{ route('contact') }}">Help Desk</a></div>
                        <!-- Mobile Menu Button -->
                        <div class="mobile-menu-toggle d-xl-none">
                            <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
                                <svg viewBox="0 0 800 600">
                                    <path
                                        d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                        id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path
                                        d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                        id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) ">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-middle-area end -->
    </header>
<!-- Mini-cart content -->
<div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">
        <div class="ltn__utilize-menu-head">
            <span class="ltn__utilize-menu-title">Cart</span>
            <button class="ltn__utilize-close">×</button>
        </div>

        <div class="mini-cart-product-area ltn__scrollbar">
            @forelse($cartItems as $item)
            <div class="mini-cart-item clearfix">
                <div class="mini-cart-img">
                    <a href="{{ route('productDetails', $item->product->slug) }}">
                        <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $item->product->fi()]) }}" alt="{{ $item->product->name_en }}">
                    </a>
                    <span class="mini-cart-item-delete ">
                        <i class="icon-cancel cart-product-remove"  data-id="{{ $item->id }}"></i>
                    </span>
                </div>
                <div class="mini-cart-info">
                    <h6><a href="{{ route('productDetails', $item->product->slug) }}">{{ $item->product->name_en }}</a></h6>
                    <span class="mini-cart-quantity">{{ $item->quantity }} x {{ number_format($item->product->final_price, 2) }} ৳</span>
                </div>
            </div>
            @empty
            <p class="text-center">Your cart is empty!</p>
            @endforelse
        </div>

        <div class="mini-cart-footer">
            <div class="mini-cart-sub-total">
                <h5>Subtotal: <span>{{ number_format($cartItems->sum(fn($i) => $i->quantity * $i->product->selling_price), 2) }} ৳</span></h5>
            </div>
            <div class="btn-wrapper">
                <a href="{{ route('new.checkout') }}" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                {{--<a href="{{ route('new.checkout') }}" class="theme-btn-2 btn btn-effect-2">Checkout</a>--}}
            </div>
            <!-- <p>Free Shipping on All Orders Over $100!</p> -->
        </div>
    </div>
</div>
    <!-- Utilize Cart Menu End -->

    <!-- Utilize Mobile Menu Start -->
    <div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">
            <div class="ltn__utilize-menu-head">
                <div class="site-logo">
                    <a href="index.html"><img src="img/logo.png" alt="Logo"></a>
                </div>
                <button class="ltn__utilize-close">×</button>
            </div>
            <div class="ltn__utilize-menu-search-form">
                <form action="{{ route('shop') }}" method="GET">
                    <input type="text" name="search" id="mobile-search-input" placeholder="Search..." autocomplete="off">
                    <button><i class="fas fa-search"></i></button>
                </form>
                <div id="mobile-search-suggestions-container" class="search-suggestions"></div>
            </div>
            <div class="ltn__utilize-menu">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="{ route('news') }}">News</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="ltn__utilize-buttons ltn__utilize-buttons-2">
                <ul>

                    @if(Auth::check())
                    @php $user = auth()->user(); @endphp
                    @if ($user->hasRole('admin'))
                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    @endif
                    <li>
                        <a href="#" title="My Account">
                            <span class="utilize-btn-icon">
                                <i class="far fa-user"></i>
                            </span>
                            Member Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" title="Wishlist">
                            <span class="utilize-btn-icon">
                                <i class="far fa-heart"></i>
                                <sup>3</sup>
                            </span>
                            Wishlist
                        </a>
                    </li>
                    @else
                    <li><a href="{{ route('login') }}">Sign in</a></li>
                    @endif

                </ul>
            </div>
            <div class="ltn__social-media-2">
                <ul>
                    <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                    <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Utilize Mobile Menu End -->

    <div class="ltn__utilize-overlay"></div>
    @push('js')
    <script>
    // Toaster function (Global)
    function showToaster(message, type = 'success') {
        const toaster = $(`<div class="toaster ${type}">${message}</div>`);
        $('#toaster-container').append(toaster);

        setTimeout(() => {
            toaster.css('animation', 'fadeOut 0.5s ease forwards');
            setTimeout(() => toaster.remove(), 500);
        }, 3000);
    }

    $(document).ready(function() {

        // Close drawer functionality for dynamically loaded content
        $(document).on('click', '.ltn__utilize-close, .ltn__utilize-overlay', function (e) {
            e.preventDefault();
            $('body').removeClass('ltn__utilize-open');
            $('.ltn__utilize').removeClass('ltn__utilize-open');
            $('.ltn__utilize-overlay').fadeOut();
            $('.mobile-menu-toggle').find('a').removeClass('close');
        });

        // Add to Cart AJAX
        $(document).off("click", ".add-to-cart-btn").on("click", ".add-to-cart-btn", function (e) {
            e.preventDefault();
            let id = $(this).data("id");
            let $btn = $(this);

            // Look for quantity input
            let qty = 1;
            let $qtyInput = $('.cart-plus-minus-box');
            if ($qtyInput.length > 0) {
                qty = parseInt($qtyInput.val()) || 1;
            }

            $btn.find('i').addClass('fa-spin fa-spinner');

            $.ajax({
                url: "{{ route('cart.quick.add') }}",
                type: "GET",
                data: { 
                    id: id,
                    qty: qty 
                },
                success: function (res) {
                    $btn.find('i').removeClass('fa-spin fa-spinner');
                    if(res.success) {
                        $('#cart-count').text(res.cartCount);
                        $('#ltn__utilize-cart-menu').html(res.miniCartHtml);
                        showToaster(res.message);
                    }
                },
                error: function() {
                    $btn.find('i').removeClass('fa-spin fa-spinner');
                    showToaster('Something went wrong!', 'error');
                }
            });
        });
        // Remove item from cart AJAX
        $(document).off('click', '.cart-product-remove').on('click', '.cart-product-remove', function(e) {
            e.preventDefault();
            var cartId = $(this).data('id');
            if (!cartId) return;

            $.ajax({
                url: '/cart/remove/item/' + cartId,
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                success: function(res) {
                    if (res.status) {
                        $('#cart-count').text(res.cartCount);
                        $('#ltn__utilize-cart-menu').html(res.miniCartHtml);
                        showToaster(res.message);

                        // If we are on the cart page, we might need a reload or a more specific update
                        if(window.location.pathname === '/cart') {
                            location.reload();
                        }
                    }
                }
            });
        });

        // Handle quantity changes
        $(document).on('change', '.cart-plus-minus-box', function() {
            let cartId = $(this).data('id');
            let quantity = parseInt($(this).val()) || 1;

            $.ajax({
                url: '/cart/update-quantity/' + cartId,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    quantity: quantity
                },
                success: function(res) {
                    if (res.status) {
                        $('#cart-count').text(res.cartCount);
                        // Refresh mini cart if needed
                        $.get("{{ route('home') }}", function(data) {
                            let newMiniCart = $(data).find('#ltn__utilize-cart-menu').html();
                            $('#ltn__utilize-cart-menu').html(newMiniCart);
                        });
                        if(window.location.pathname === '/cart') {
                            location.reload();
                        }
                    }
                }
            });
        });

        // Search Suggestions Logic
        function handleSearchSuggestions(inputSelector, containerSelector) {
            let timeout = null;
            $(document).off('input', inputSelector).on('input', inputSelector, function() {
                let query = $(this).val();
                let container = $(containerSelector);
                clearTimeout(timeout);
                if (query.length < 2) {
                    container.hide().empty();
                    return;
                }
                timeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('search.suggestions') }}",
                        method: "GET",
                        data: { search: query },
                        success: function(res) {
                            container.empty();
                            if (res.html && res.html.trim() !== '') {
                                container.html(res.html);
                                container.show();
                            } else {
                                container.hide();
                            }
                        }
                    });
                }, 300);
            });
            $(document).off('focus', inputSelector).on('focus', inputSelector, function() {
                if ($(this).val().length >= 2 && $(containerSelector).children().length > 0) {
                    $(containerSelector).show();
                }
            });
        }

        handleSearchSuggestions('#global-search-input', '#search-suggestions-container');
        handleSearchSuggestions('#mobile-search-input', '#mobile-search-suggestions-container');

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.header-search-1-form, .ltn__utilize-menu-search-form').length) {
                $('.search-suggestions').hide();
            }
        });

        // Sticky Header Logic
        let lastScrollTop = 0;
        let header = $('.ltn__header-middle-area');
        let headerContainer = $('.ltn__header-area');
        let headerHeight = header.outerHeight();

        $(window).on('scroll', function() {
            let st = $(this).scrollTop();
            if (st > 200) {
                headerContainer.css('height', headerHeight);
                if (st > lastScrollTop) {
                    header.removeClass('sticky-active');
                } else {
                    header.addClass('sticky-active');
                }
            } else {
                headerContainer.css('height', 'auto');
                header.removeClass('sticky-active');
            }
            lastScrollTop = st;
        });
    });
    </script>
    @endpush