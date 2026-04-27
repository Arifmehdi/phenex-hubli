<div class="ltn__utilize-menu-inner ltn__scrollbar">
    <div class="ltn__utilize-menu-head">
        <span class="ltn__utilize-menu-title">Cart</span>
        <button class="ltn__utilize-close">×</button>
    </div>

    <div class="mini-cart-product-area ltn__scrollbar">
        @php
            $cartItems = \App\Models\Cart::getCartItems();
        @endphp
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
                <span class="mini-cart-quantity">{{ $item->quantity }} x {{ number_format($item->product->selling_price, 2) }} ৳</span>
            </div>
        </div>
        @empty
        <p class="text-center">Your cart is empty!</p>
        @endforelse
    </div>

    <div class="mini-cart-footer">
        <div class="mini-cart-sub-total">
            @php
                $total = $cartItems->sum(fn($i) => $i->quantity * $i->product->selling_price);
            @endphp
            <h5>Subtotal: <span>{{ number_format($total, 2) }} ৳</span></h5>
        </div>
        <div class="btn-wrapper">
            <a href="{{ route('new.checkout') }}" class="theme-btn-1 btn btn-effect-1">View Cart</a>
            <a href="{{ route('new.checkout') }}" class="theme-btn-2 btn btn-effect-2">Checkout</a>
        </div>
    </div>
</div>
