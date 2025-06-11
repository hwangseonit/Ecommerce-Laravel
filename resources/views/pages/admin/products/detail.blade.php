@extends('layouts.admin.main')

@section('content')
    @include('components.admin.alert')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">
                        <div
                            class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3">Chi tiết sản phẩm</h5>
                            <a href="{{ route('products.index') }}" class="btn btn-primary text-capitalize me-4">
                                Danh sách
                            </a>
                        </div>
                    </div>
                    <div class="row gx-4 mt-2 m-0">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{ asset('images/' . $product->image_url) }}" alt="{{ $product->image_url }}"
                                    class="w-100 border-radius-lg shadow-sm">
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-1">
                                    {{ $product->name }}
                                </h5>
                                <p class="mb-0 font-weight-normal text-sm">
                                    <span class="product-details-price">{{ $product->price_range }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên
                                            biến thể</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Màu</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Dung lượng</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Số lượng</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($variations as $variation)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('images/' . $variation->image_url) }}"
                                                            class="avatar avatar-sm me-3 border-radius-lg"
                                                            alt="variant_image">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $variation->variant_name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            {{ number_format($variation->price, 0, '.', '.') }} ₫</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $variation->attributes->where('attribute_id', 1)->first()->attribute_value ?? 'N/A' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $variation->attributes->where('attribute_id', 2)->first()->attribute_value ?? 'N/A' }}GB
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $variation->stock }}</p>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <div class="product-details ">
                            <h4 class="text-uppercase product-details-name">
                                {{ $product->name }}
                            </h4>
                            <div>
                                <h3 id="product-price">{{ $product->price_range }}</h3>
                            </div>
                            <p>
                                <a class="category-detail text-decoration-none text-hover" href="">Danh mục:
                                    {{ $product->category->category_name }}</a>
                            </p>
                            <div class="row mb-3">
                                @php
                                    $displayedCapacities = [];
                                @endphp
                                @foreach ($product->variants as $variant)
                                    @php
                                        $capacity =
                                            $variant->attributes->where('attribute_id', 2)->first()->attribute_value ??
                                            'N/A';
                                    @endphp
                                    @if (!in_array($capacity, $displayedCapacities))
                                        <div class="col-md-2 mb-3">
                                            <div class="option-group">
                                                <div class="option" data-capacity="{{ $capacity }}">
                                                    {{ $capacity }}</div>
                                            </div>
                                        </div>
                                        @php
                                            $displayedCapacities[] = $capacity;
                                        @endphp
                                    @endif
                                @endforeach
                            </div>
                            <div class="row mb-3">
                                @php
                                    $displayedColors = [];
                                @endphp
                                @foreach ($product->variants as $variant)
                                    @php
                                        $color =
                                            $variant->attributes->where('attribute_id', 1)->first()->attribute_value ??
                                            'N/A';
                                    @endphp
                                    @if (!in_array($color, $displayedColors))
                                        <div class="col-md-2 mb-3">
                                            <div class="option-group">
                                                <div class="color-option" data-color="{{ $color }}">
                                                    <img src="{{ asset('images/' . $variant->image_url) }}" class="w-100"
                                                        alt="{{ $variant->image_url }}">
                                                    <span> {{ $color }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $displayedColors[] = $color;
                                        @endphp
                                    @endif
                                @endforeach
                            </div>
                            <p class="mb-1">Kho: <span id="product-stock">{{ $product->total_stock }}</span></p>
                            <p>{!! $product->short_description !!}</p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-7">
                        <div id="product-description" class="short-description">
                            {!! $product->long_description !!}
                        </div>
                        <div class="text-center">
                            <button id="toggle-description" class="btn btn-primary p-0">Xem thêm</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <p>{!! $product->specifications !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                .NumberFormat().format(selectedVariant.price) + ' ₫';
                            document.getElementById('product-stock').textContent = selectedVariant
                                .stock;
                        }
                    }
                });
            });
        });
    </script>
@endsection
