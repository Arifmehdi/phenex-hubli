<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image"
    data-bg="{{ asset($bgImage) }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h6 class="section-subtitle ltn__secondary-color">// Welcome to {{ env('APP_NAME') }}</h6>
                        <h1 class="section-title white-color">{{ $title }}</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>{{ $pageName ?? $title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>