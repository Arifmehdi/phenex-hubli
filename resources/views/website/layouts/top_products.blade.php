<ul>
    @foreach($topClickedProducts as $item)
    <li>
        <div class="top-rated-product-item clearfix">
            <div class="top-rated-product-img">
                <a href="{{ route('productDetails', $item->slug) }}">
                    <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $item->fi()]) }}" alt="{{ $item->name_en }}">
                </a>
            </div>

            <div class="top-rated-product-info">
                <h6>
                    <a href="{{ route('productDetails', $item->slug) }}">
                        {{ $item->name_en }}
                    </a>
                </h6>

                <div class="product-price">
                    <span>{{ number_format($item->selling_price, 2) }} ৳</span>
                    {{--@if($item->discount > 0.00)
                        <del style="font-size: 10px; color: #888;">{{ number_format($item->final_price, 2) }} ৳</del>
                    @endif--}}
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>