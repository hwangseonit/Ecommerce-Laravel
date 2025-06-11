@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')

    <div class="container mt-5">
        <div class="row">
            <!-- Danh mục sản phẩm cho desktop -->
            <div class="col-md-3 col-sm-6 d-none d-md-block border-end">
                <aside>
                    <div class="card categories-vertical">
                        <ul class="list-group btn-danger-custom">
                            <div class="card-header fw-bold text-uppercase">
                                <i class="fas fa-list-ul me-2"></i>Danh mục
                            </div>
                            <a href="{{ route('productsClient.productByCategory') }}"
                                class="list-group-item list-group-item-action">Tất Cả</a>
                            @foreach ($categories as $category)
                                <a href="{{ route('productsClient.productByCategory', ['slug' => $category->slug]) }}"
                                    class="list-group-item list-group-item-action">{{ $category->category_name }}</a>
                            @endforeach
                        </ul>
                    </div>
                </aside>
                <aside class="top-products">
                    <p class="my-3 fw-bold text-uppercase">Top sản phẩm yêu thích</p>
                    @foreach ($mostViewedProducts as $product)
                        <div class="product-widget mb-3">
                            <div class="row">
                                <div class="col-4 col-md-4">
                                    <a href="{{ route('productsClient.show', $product->id) }}">
                                        <div class="">
                                            <img src="{{ asset('images/' . $product->image_url) }}"
                                                class="card-img-top img-fluid" alt="{{ $product->name }}">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-8 col-md-8">
                                    <a href="{{ route('productsClient.show', $product->id) }}"
                                        class="text-decoration-none text-dark-custom product-widget-name">{{ $product->name }}</a>
                                    <p style="font-size: 14px;" class="card-text m-0">{{ $product->price_range }}</p>
                                    @if ($product->old_price)
                                        <del style="font-size: 12px;">{{ number_format($product->old_price, 0, ',', '.') }}
                                            VND</del>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </aside>
            </div>

            <!-- Danh mục sản phẩm cho điện thoại -->
            <div class="col-12 d-md-none">
                <div class="filter-cate">
                    <div class="ft-cate d-flex overflow-auto">
                        <a href="{{ route('productsClient.productByCategory') }}" data-id="0" class="active">
                            Tất cả
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('productsClient.productByCategory', ['slug' => $category->slug]) }}"
                                data-id="{{ $category->id }}" class="">
                                {{ $category->category_name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-sm-12 ps-0">
                <div class="row g-3 mb-3">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                            <div class="card rounded-0 bg-hove">
                                <a href="{{ route('productsClient.show', $product->id) }}">
                                    <div class="product-img">
                                        <img src="{{ asset('images/' . $product->image_url) }}"
                                            class="card-img-top img-fluid" alt="{{ $product->name }}">
                                    </div>
                                </a>
                                <div class="card-body text-center">
                                    <a href="{{ route('productsClient.show', $product->id) }}"
                                        class="text-decoration-none text-dark-custom product-name">
                                        {{ $product->name }}
                                        @if ($product->discount_percentage)
                                            <!-- Biểu tượng "Sale" -->
                                            <div
                                                class="position-absolute top-0 end-0 bg-danger text-white text-center p-2 rounded-start">
                                                {{ $product->discount_percentage }}%
                                            </div>
                                        @endif
                                    </a>
                                    <div class="product-price-wrapper">
                                        <p class="card-text m-0">{{ $product->price_range }}</p>
                                        @if ($product->old_price)
                                            <div class="price-sale">
                                                <del class="product-old-price">{{ number_format($product->old_price, 0, ',', '.') }}
                                                    ₫</del>
                                            </div>
                                        @else
                                            <div class="price-sale empty-sale"></div>
                                        @endif
                                    </div>
                                    <div
                                        class="product-btn d-flex flex-column flex-sm-row justify-content-center align-items-center">
                                        <a href="{{ route('productsClient.show', $product->id) }}"
                                            class="text-decoration-none mb-2 mb-sm-0">
                                            <button class="btn btn-danger me-md-1">
                                                <i class="fa fa-shopping-cart me-1"></i>
                                                <span class="small">Giỏ hàng</span>
                                            </button>
                                        </a>

                                        <a href="{{ route('favorites.add', $product->id) }}" class="text-decoration-none">
                                            <button class="btn btn-secondary">
                                                <i class="fas fa-heart me-1 ms-md-1"></i>
                                                <span class="small">Yêu thích</span>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
