<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="card mb-4">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">monetization_on</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Doanh thu {{ $revenue_type }}</p>
                    <h4 class="mb-0">{{ number_format($revenueByDay->sum('total'), 0, ',', '.') }} đ</h4>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3 ps-0">
                    @if ($percentageChange !== null)
                        <p class="mb-0">
                            <span
                                class="text-{{ $percentageChange >= 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">
                                {{ $percentageChange >= 0 ? '+' : '' }}{{ number_format($percentageChange, 2) }}%
                            </span>
                            so với {{ $periodLabel }}
                        </p>
                    @else
                        <p class="mb-0">Không có dữ liệu {{ $periodLabel }}</p>
                    @endif
                </div>
                <hr class="dark horizontal my-0">
                <p class="mb-0 text-center">Doanh thu theo loại sản phẩm</p>
                <div class="row">
                    @foreach ($revenueByCategory as $item)
                        <div class="d-flex justify-content-between small-font">
                            <p class="mb-0">{{ $item->category_name }}:</p>
                            <h6 class="mb-0">{{ number_format($item->total, 0, ',', '.') }}₫</h6>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header p-3 pt-2 ">
                <div
                    class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Tổng khách hàng</p>
                    <h4 class="mb-0">{{ $totalUsers }}</h4>
                </div>
                <hr class="dark horizontal my-0">
                <div class="row">
                    <div class="d-flex justify-content-between  small-font">
                        <p class="mb-0">Khách tìm năng:</p>
                        <h6 class="mb-0">{{ $customersWithoutOrdersInPeriod }}</h6>
                    </div>
                    <div class="d-flex justify-content-between  small-font">
                        <p class="mb-0">Khách quay lại:</p>
                        <h6 class="mb-0">{{ $returningCustomersInPeriod }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 mb-4">
        <div class="card mb-4">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">trending_up</i>
                </div>
                <div class="text-end pt-1">
                    <h6 class="mb-0 text-capitalize">Top 10 Sản phẩm bán chạy {{ $revenue_type }}</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
                    <!-- List of best selling products -->
                    @foreach ($topSellingProducts as $product)
                        <div class="col mb-4">
                            <a href="{{ route('product.show', $product->id) }}">
                                <div class="card">
                                    <img src="{{ asset('images/' . $product->image_url) }}" class="card-img-top"
                                        alt="{{ $product->image_url }}">
                                    <div class="card-body">
                                        <h5 class="card-title ellipsis">{{ $product->name }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">trending_down</i>
                </div>
                <div class="text-end pt-1">
                    <h6 class="mb-0 text-capitalize">Top 10 Sản phẩm bán chậm {{ $revenue_type }}</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
                    @foreach ($unsoldProducts as $product)
                        <div class="col mb-4">
                            <a href="{{ route('product.show', $product->id) }}">
                                <div class="card">
                                    <img src="{{ asset('images/' . $product->image_url) }}" class="card-img-top"
                                        alt="{{ $product->image_url }}">
                                    <div class="card-body">
                                        <h5 class="card-title ellipsis">{{ $product->name }}</h5>
                                    </div>
                            </a>
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
