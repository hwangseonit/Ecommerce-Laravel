@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="section p-4">
        <div class="container">
            <div class="row ">
                <div class="row mb-3">
                    <div class="col-md-6 col-sm-9">
                        {{-- carousel slide  --}}
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach ($subImagePaths as $key => $subImagePath)
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="{{ $key }}"
                                        @if ($loop->first) class="active" @endif></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner">
                                @foreach ($subImagePaths as $key => $subImagePath)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <img src="{{ asset('images/' . $subImagePath) }}" class="d-block w-100"
                                            alt="{{ $subImagePath }}">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Trước</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Tiếp</span>
                            </button>
                        </div>
                        {{-- carousel slide  --}}
                    </div>
                    <div class="col-md-6">
                        <div class="product-details">
                            <h4 class="text-uppercase product-details-name">{{ $product->name }}</h4>
                            <div>
                                <h3 id="product-price" class="product-price"> {{ $product->price_range }}</h3>
                                @if ($product->old_price)
                                    <div class="price-sale ">
                                        <h5>
                                            <del class="product-old-price">
                                                {{ number_format($product->old_price, 0, ',', '.') }}₫</del>
                                        </h5>

                                    </div>
                                @endif
                            </div>
                            <p>
                                <a class="category-detail text-decoration-none text-hover"
                                    href="{{ route('productsClient.index', ['slug' => $product->category->slug]) }}">Danh
                                    mục:
                                    {{ $product->category->category_name }}</a>
                            </p>
                            <div class="row mb-3">
                                @php
                                    $displayedCapacities = [];
                                @endphp
                                @foreach ($product->variants as $variant)
                                    @foreach ($variant->attributes as $attribute)
                                        @if (
                                            $attribute->attribute->attribute_name == 'Dung Lượng' &&
                                                !in_array($attribute->attribute_value, $displayedCapacities))
                                            <div class="col-md-2 col-3 mb-3">
                                                <div class="option-group">
                                                    <div class="option" style="font-weight: 500"
                                                        data-capacity="{{ $attribute->attribute_value }}">
                                                        {{ $attribute->attribute_value }}
                                                    </div>
                                                </div>
                                                @php
                                                    $displayedCapacities[] = $attribute->attribute_value;
                                                @endphp
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>

                            <div class="row mb-3">
                                @php
                                    $displayedColors = [];
                                @endphp
                                @foreach ($product->variants as $variant)
                                    @foreach ($variant->attributes as $attribute)
                                        @if ($attribute->attribute->attribute_name == 'Màu' && !in_array($attribute->attribute_value, $displayedColors))
                                            <div class="col-md-2 col-3 mb-3">
                                                <div class="option-group" style="width: 50px">
                                                    <div class="color-option" style="font-weight: 500"
                                                        data-color="{{ $attribute->attribute_value }}">
                                                        <img src="{{ asset('images/' . $variant->image_url) }}"
                                                            class="w-100" alt="{{ $variant->image_url }}">
                                                            <span>{{ $attribute->attribute_value }}</span>
                                                    </div>                                            
                                                </div>
                                            </div>
                                            @php
                                                $displayedColors[] = $attribute->attribute_value;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>

                            <div class="me-3 mb-3">
                                <p class="mb-1" style="font-weight: 500">Số lượng:</p>
                                <form id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="variant_id" id="variant_id">
                                    <input type="hidden" name="price" id="product_price_value"
                                        value="{{ $product->base_price }}">
                                    <div class="row d-flex align-items-center ">
                                        <div class="col-md-4 w-25 input-group p-0 mb-md-0 mb-2">
                                            <input class="form-control" type="number" name="quantity" min="1"
                                                value="1">
                                        </div>
                                        <div class="col-md-8 p-md-1 p-0">
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fa fa-shopping-cart"></i> Thêm giỏ hàng
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span id="quantity-error" class="text-danger" style="display: none;"></span>
                                            <span id="variant-error" class="text-danger" style="display: none;"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <p class="mb-1" style="font-weight: 500">Kho: <span
                                    id="product-stock">{{ $product->total_stock }}</span></p>
                            <p>{!! $product->short_description !!}</p>
                        </div>
                    </div>
                </div>
                @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                    <div class="row mb-3">
                        <h3 class="section-title mb-1">SẢN PHẨM LIÊN QUAN</h3>
                        <div class="owl-carousel owl-theme">
                            @foreach ($relatedProducts as $relatedProduct)
                                <div class="item">
                                    <div class="card">
                                        <a href="{{ route('productsClient.show', $relatedProduct->id) }}">
                                            <div class="product-img">
                                                <img src="{{ asset('images/' . $relatedProduct->image_url) }}"
                                                    class="card-img-top" alt="{{ $relatedProduct->name }}">
                                            </div>
                                        </a>
                                        <div class="card-body text-center">
                                            <a href="{{ route('productsClient.show', $relatedProduct->id) }}"
                                                class="text-decoration-none text-dark-custom product-name">{{ $relatedProduct->name }}</a>
                                            <p class="card-text m-0">{{ $relatedProduct->price_range }}</p>
                                            @if ($relatedProduct->old_price)
                                                <div class="price-sale">
                                                    <del
                                                        class="product-old-price">{{ number_format($relatedProduct->old_price, 0, ',', '.') }}₫</del>
                                                </div>
                                            @endif
                                            <div class="product-btn">
                                                <a href="{{ route('productsClient.show', $relatedProduct->id) }}"
                                                    class="text-decoration-none">
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-shopping-cart me1"></i>
                                                        <span class="small">Giỏ hàng</span>
                                                    </button>
                                                </a>
                                                <button class="btn btn-secondary">
                                                    <i class="fas fa-heart me-1"></i>
                                                    <span class="small">Yêu thích</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-7">
                        <div id="product-description" class="short-description">
                            {!! $product->long_description !!}
                        </div>
                        <div class="text-center">
                            <button id="toggle-description" class="btn btn-danger p-0">Xem thêm</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-12">
                                <div style="overflow-x: auto;">
                                    <p>{!! $product->specifications !!}</p>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                            <div class="card p-0">
                                <h6 class="card-header title">Bài viết mới nhất</h6>
                                <div class="product-widget mb-3">
                                    @foreach ($postnews as $postnew)
                                        <div class="row mt-2">
                                            <div class="col-md-4 col-6 pe-0">
                                                <a href="{{ route('blog.show', $postnew->id) }}">
                                                    <img src="{{ $postnew->image ? asset('images/' . $postnew->image) : asset('images/no_images.jpg') }}"
                                                        class="card-img " alt="Product 1">
                                                </a>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <div class="btn btn-danger btn-sm">
                                                    {{ $postnew->category->name }}</div>
                                                <a href="{{ route('blog.show', $postnew->id) }}"
                                                    class="text-decoration-none small title title-post truncate-text">{{ $postnew->title }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container card review-section">
                    <div class="card-header">
                        <h4>Đánh giá sản phẩm</h4>
                    </div>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="star-rating d-flex align-items-center justify-content-center">
                                <span class="fs-1">4/5</span>
                                <div class="mt-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <p>66 đánh giá</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="progress-block">
                                <div class="d-flex align-items-center">
                                    <span>5</span>
                                    <div class="progress flex-grow-1 mx-2">
                                        <div class="progress-bar bg-danger" style="width: 17%;"></div>
                                    </div>
                                    <span>11</span>
                                </div>
                                <!-- Các thanh tiến trình cho các mức đánh giá khác -->
                                <!-- ... -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-danger btn-sm">GỬI ĐÁNH GIÁ</button>
                        </div>
                    </div>
                    <div class="review-item mt-3">
                        <div class="d-flex user-info mb-4">
                            <div class="col-1 avatar">V</div>
                            <div class="ms-3">
                                <div class="username">Vỹ</div>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <p class="mb-0">Mình mới mua trả góp. thủ tục nhanh mà nhân viên nhiệt tình nhé</p>
                                <div class="d-flex align-items-center">
                                    <div class="date me-3">Ngày 07/04/2024</div>
                                    <div class="">trả lời</div>
                                </div>
                            </div>
                        </div>
                        <div class="ms-4 mt-2">
                            <div class="d-flex user-info">
                                <div class=" col-1 avatar">H</div>
                                <div class=" p-1 ms-3">
                                    <div class="username">Hoang</div>
                                    <p class="mt-1 mb-0">@Vỹ trả góp qua cty tài Chính nào và trả trước bao nhiêu % vậy ta</p>
                                    <div class="date">5 ngày trước</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .short-description {
                    overflow: hidden;
                    display: -webkit-box;
                    -webkit-line-clamp: 5;
                    /* Số dòng bạn muốn hiển thị */
                    -webkit-box-orient: vertical;
                }

                .expanded-description {
                    -webkit-line-clamp: unset;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toggleBtn = document.getElementById('toggle-description');
                    const description = document.getElementById('product-description');

                    const variants = @json($product->variants);


                    toggleBtn.addEventListener('click', function() {
                        description.classList.toggle('expanded-description');
                        if (description.classList.contains('expanded-description')) {
                            toggleBtn.textContent = 'Thu gọn';
                        } else {
                            toggleBtn.textContent = 'Xem thêm';
                        }
                    });
                    document.querySelectorAll('.option, .color-option').forEach(option => {
                        option.addEventListener('click', function() {
                            if (option.classList.contains('option')) {
                                document.querySelectorAll('.option').forEach(el => el.classList.remove(
                                    'selected'));
                            } else if (option.classList.contains('color-option')) {
                                document.querySelectorAll('.color-option').forEach(el => el.classList
                                    .remove('selected'));
                            }
                            option.classList.add('selected');

                            const selectedCapacity = document.querySelector('.option.selected')?.dataset
                                .capacity;
                            const selectedColor = document.querySelector('.color-option.selected')?.dataset
                                .color;

                            if (selectedCapacity && selectedColor) {
                                const selectedVariant = variants.find(variant => {
                                    const capacity = variant.attributes.find(attr => attr
                                        .attribute_id == 2)?.attribute_value;
                                    const color = variant.attributes.find(attr => attr
                                        .attribute_id == 1)?.attribute_value;
                                    return capacity == selectedCapacity && color == selectedColor;
                                });

                                if (selectedVariant) {
                                    document.getElementById('product-price').textContent = new Intl
                                        .NumberFormat('vi-VN', {
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }).format(selectedVariant.discounted_price) + ' ₫';
                                    document.getElementById('product-stock').textContent = selectedVariant
                                        .stock;
                                    document.getElementById('variant_id').value = selectedVariant
                                        .id; // Cập nhật giá trị biến thể
                                    document.getElementById('product_price_value').value = selectedVariant
                                        .discounted_price; // Cập nhật giá trị giá
                                    document.getElementById('variant-error').style.display =
                                        'none'; // Ẩn lỗi khi đã chọn biến thể

                                    if (selectedVariant.discounted_price < selectedVariant.price) {
                                        const oldPriceEl = document.createElement('del');
                                        oldPriceEl.classList.add('product-old-price');
                                        oldPriceEl.textContent = new Intl.NumberFormat('vi-VN', {
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }).format(selectedVariant.price) + '₫';
                                        document.querySelector('#product-price').appendChild(oldPriceEl);
                                    }
                                }
                            }
                        });
                    });

                    document.querySelector('#add-to-cart-form').addEventListener('submit', function(e) {
                        e.preventDefault();

                        let quantity = parseInt(document.querySelector('input[name="quantity"]').value);
                        let stock = parseInt(document.getElementById('product-stock').textContent);
                        let variantId = document.getElementById('variant_id').value;

                        if (quantity > stock) {
                            document.getElementById('quantity-error').textContent =
                                'Số lượng mua vượt quá số lượng tồn kho.';
                            document.getElementById('quantity-error').style.display = 'block';
                        } else if (variants.length > 0 && !variantId) {
                            document.getElementById('variant-error').textContent =
                                'Vui lòng chọn thuộc tính sản phẩm.';
                            document.getElementById('variant-error').style.display = 'block';
                        } else {
                            document.getElementById('quantity-error').style.display = 'none';
                            document.getElementById('variant-error').style.display = 'none';
                            this.submit(); // Tiếp tục gửi form nếu không có lỗi
                        }
                    });
                });
            </script>

        </div>
    </div>
@endsection
