@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="section p-4">
        <div class="container">
            <div class="row container">
                <div>
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
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Trước</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
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
                                    <h3 id="product-price" class="product-price">{{ $product->price_range }}</h3>
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
                                        @php
                                            $capacity =
                                                $variant->attributes->where('attribute_id', 2)->first()
                                                    ->attribute_value ?? 'N/A';
                                        @endphp
                                        @if (!in_array($capacity, $displayedCapacities))
                                            <div class="col-md-2 mb-3">
                                                <div class="option-group">
                                                    <div class="option" style="font-weight: 500"
                                                        data-capacity="{{ $capacity }}">
                                                        {{ $capacity }}
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $displayedCapacities[] = $capacity;
                                            @endphp
                                        @endif
                                    @endforeach
                                </div>
                                @if ($product->has_variants === 1)
                                    <div class="row mb-3">
                                        @php
                                            $displayedColors = [];
                                        @endphp
                                        @foreach ($product->variants as $variant)
                                            @php
                                                $color =
                                                    $variant->attributes->where('attribute_id', 1)->first()
                                                        ->attribute_value ?? 'N/A';
                                            @endphp
                                            @if (!in_array($color, $displayedColors))
                                                <div class="col-md-2 mb-3">
                                                    <div class="option-group">
                                                        <div class="color-option" style="font-weight: 500"
                                                            data-color="{{ $color }}">
                                                            <img src="{{ asset('images/' . $variant->image_url) }}"
                                                                class="w-100" alt="{{ $variant->image_url }}">
                                                            <span>{{ $color }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $displayedColors[] = $color;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                <div class="me-3 mb-3">
                                    <p class="mb-1" style="font-weight: 500">Số lượng:</p>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="variant_id" id="variant_id">
                                        <input type="hidden" name="price" id="product_price_value">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-md-4 w-25 input-group p-0">
                                                <input class="form-control" type="number" name="quantity" min="1"
                                                    value="1">
                                            </div>
                                            <div class="col-md-8">
                                                <button class="btn btn-danger" type="submit"><i
                                                        class="fa fa-shopping-cart"></i> Thêm giỏ hàng</button>
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
                    <!-- Carousel cho sản LIÊN QUAN -->
                    <!-- Carousel cho sản phẩm liên quan -->
                    @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                        <div class="row mb-3">
                            <h3 class="section-title mb-1">SẢN PHẨM LIÊN QUAN</h3>
                            <div class="owl-carousel owl-theme">
                                @foreach ($relatedProducts as $product)
                                    <div class="item">
                                        <div class="card">
                                            <a href="{{ route('productsClient.show', $product->id) }}">
                                                <div class="product-img">
                                                    <img src="{{ asset('images/' . $product->image_url) }}"
                                                        class="card-img-top" alt="{{ $product->name }}">
                                                </div>
                                            </a>
                                            <div class="card-body text-center">
                                                <a href="{{ route('productsClient.show', $product->id) }}"
                                                    class="text-decoration-none text-dark-custom product-name">
                                                    {{ $product->name }}
                                                </a>
                                                <p class="card-text m-0">{{ $product->price_range }}</p>
                                                @if ($product->old_price)
                                                    <div class="price-sale">
                                                        <del class="product-old-price">{{ number_format($product->old_price, 0, ',', '.') }}
                                                            VND</del>
                                                    </div>
                                                @endif
                                                <div class="product-btn">
                                                    <a href="{{ route('productsClient.show', $product->id) }}"
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
                            {{-- description --}}
                            <p id="product-description">
                                {!! Str::limit($product->long_description, 500, '...') !!}
                                <span id="more-text" style="display: none;">{!! $product->long_description !!}</span>
                            </p>
                            {{-- <button id="read-more-btn" class="btn btn-primary">Đọc thêm</button> --}}
                            {{-- description --}}
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <p>{!! $product->specifications !!}</p>
                            </div>
                            <div class="row">
                                <div class="card p-0">
                                    <h6 class="card-header title ">Bài viết mới nhất</h6>
                                    <div class="product-widget mb-3">
                                        @foreach ($postnews as $postnew)
                                            <div class="row mt-2">
                                                <div class="col-md-4 pe-0">
                                                    <a href="{{ route('blog.show', $postnew->id) }}">
                                                        <img src="{{ $postnew->image ? asset('images/' . $postnew->image) : asset('images/no_images.jpg') }}"
                                                            class="card-img" alt="Product 1">
                                                    </a>
                                                </div>
                                                <div class="col-md-8 ">
                                                    <div class="btn btn-danger btn-sm ">
                                                        {{ Str::limit($postnew->category->name, 20, '...') }}
                                                    </div>
                                                    <a href="{{ route('blog.show', $postnew->id) }}"
                                                        class="text-decoration-none  small title title-post  truncate-text">{{ $postnew->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container card review-section">
                        <div class="row  ">
                            <div>
                                <div class="card-header">
                                    <h4>Đánh giá sản phẩm</h4>
                                </div>
                                <div class="row my-3 ">
                                    <div class=" col-4 align-content-center  justify-content-center text-center">
                                        <div class="">
                                            <div class="star-rating">
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
                                    </div>
                                    <div class="col-4 align-content-center  justify-content-center text-center">
                                        <div class="">
                                            <div class="progress-block">
                                                <div class="d-flex align-items-center">
                                                    <span>5</span>
                                                    <div class="progress flex-grow-1 mx-2">
                                                        <div class="progress-bar" style="width: 17%;"></div>
                                                    </div>
                                                    <span>11</span>
                                                </div>
                                                <div class="d-flex align-items-center mt-1">
                                                    <span>4</span>
                                                    <div class="progress flex-grow-1 mx-2">
                                                        <div class="progress-bar" style="width: 80%;"></div>
                                                    </div>
                                                    <span>53</span>
                                                </div>
                                                <div class="d-flex align-items-center mt-1">
                                                    <span>3</span>
                                                    <div class="progress flex-grow-1 mx-2">
                                                        <div class="progress-bar" style="width: 3%;"></div>
                                                    </div>
                                                    <span>2</span>
                                                </div>
                                                <div class="d-flex align-items-center mt-1">
                                                    <span>2</span>
                                                    <div class="progress flex-grow-1 mx-2">
                                                        <div class="progress-bar" style="width: 0%;"></div>
                                                    </div>
                                                    <span>0</span>
                                                </div>
                                                <div class="d-flex align-items-center mt-1">
                                                    <span>1</span>
                                                    <div class="progress flex-grow-1 mx-2">
                                                        <div class="progress-bar" style="width: 0%;"></div>
                                                    </div>
                                                    <span>0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-content-center col-4 justify-content-center text-center">
                                        <button class="btn btn-danger">GỬI ĐÁNH GIÁ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="review-item ">
                            <div class="d-flex user-info">
                                <div class="avatar mb-5">V</div>
                                <div>
                                    <div class="username mt-1">Vỹ</div>
                                    <div class="">
                                        <div class="star-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">Mình mới mua trả góp. thủ tục nhanh mà nhân viên nhiệt tình nhé</p>
                                    <div class="d-flex">
                                        <div class="date me-3">Ngày 07/04/2024</div>
                                        <div class="">trả lời</div>
                                    </div>
                                </div>
                            </div>
                            <div class=" ms-4 mt-2">
                                <div class="d-flex user-info">
                                    <div class="avatar">H</div>
                                    <div class="card p-1">
                                        <div class="username">Hoang</div>
                                        <p class="mt-1 mb-0">@Vỹ trả góp qua cty tài Chính nào và trả trước bao nhiêu % vậy
                                            ta
                                        </p>
                                        <div class="date">5 ngày trước</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.btn-danger').addEventListener('click', function (e) {
            e.preventDefault();
            
            let product_id = {{ $product->id }};
            let variant_id = document.getElementById('variant_id').value;
            let quantity = document.querySelector('input[name="quantity"]').value;
            let price = document.getElementById('product_price_value').value;
    
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: product_id,
                    variant_id: variant_id,
                    quantity: quantity,
                    price: price
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Sản phẩm đã được thêm vào giỏ hàng.');
                }
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var readMoreBtn = document.getElementById('read-more-btn');
            var moreText = document.getElementById('more-text');
            var productDescription = document.getElementById('product-description');

            readMoreBtn.addEventListener('click', function() {
                if (moreText.style.display === 'none') {
                    moreText.style.display = 'inline';
                    readMoreBtn.style.display = 'none'; // Ẩn nút "Đọc thêm" sau khi nhấp
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const variants = @json($product->variants);

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
                                }).format(selectedVariant.price) + ' VND';
                            document.getElementById('product-stock').textContent = selectedVariant
                                .stock;
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-B6UOSFBci6Fbub2Mk5z0W2FNQp1fGqJ2XB3Y1W4Y3gE3IbN+5/6/8U9TLX1fSx64" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9+MphmC5S7L7/8PEvwE9k5sXKFNxdjlfWlCq4z/FzZer1KThgFZVxg" crossorigin="anonymous"></script>
@endsection
