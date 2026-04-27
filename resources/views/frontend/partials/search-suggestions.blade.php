@if(count($products) > 0)
    @foreach($products as $product)
        <a href="{{ route('productDetails', $product->slug) }}" class="suggestion-item">
            <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $product->fi()]) }}" class="suggestion-img" alt="{{ $product->name_en }}">
            <div class="suggestion-info">
                <span class="suggestion-name">{{ $product->name_en }}</span>
                <span class="suggestion-price">{{ number_format($product->selling_price, 2) }} ৳</span>
            </div>
        </a>
    @endforeach
    <a href="{{ route('shop', ['search' => $query]) }}" class="search-all-btn">Search all results for "{{ $query }}"</a>
@else
    <div class="p-3 text-center no-result-msg">
        <span>No products found for "<strong>{{ $query }}</strong>"</span>
    </div>
@endif
