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
                            <h5 class="text-white text-capitalize ps-3 mb-0">Hóa đơn chi tiết</h5>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary text-capitalize me-4">
                                Danh sách
                            </a>
                        </div>
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header bg-primary p-3 ">
                                                <h5 class="mb-0  text-white">Đơn Hàng Của Bạnn</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-8 text-start p-0">
                                                        <strong>Sản phẩm</strong>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <strong>Tổng</strong>
                                                    </div>
                                                </div>
                                                <hr class="my-1">

                                                <!-- Product Details -->
                                                @foreach ($order->items as $item)
                                                    <div class="row">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-2 p-0"><img
                                                                            src="{{ asset('images/' . $item->product->image_url) }}"
                                                                            alt="{{ $item->product->name }}"
                                                                            class="img-fluid rounded"></div>
                                                                    <div class="col-10 small-font">
                                                                        <span
                                                                            class="product-name">{{ $item->product->name }}</span>
                                                                        <br>
                                                                        @if ($item->variant)
                                                                            @foreach ($item->variant->attributes as $attribute)
                                                                                <span
                                                                                    class="d-block text-muted">{{ $attribute->attribute->attribute_name }}:
                                                                                    {{ $attribute->attribute_value }}</span>
                                                                            @endforeach
                                                                        @endif
                                                                        <br>
                                                                        <span><strong>Giá:</strong>
                                                                            {{ number_format($item->price, 0, ',', '.') }}₫</span>
                                                                        <span>× {{ $item->quantity }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 text-end">
                                                                <span>{{ number_format($item->total_price, 0, ',', '.') }}₫</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="my-2">
                                                @endforeach

                                                <!-- Subtotal -->
                                                <div class="d-flex justify-content-between pt-2 small-font">
                                                    <span>Tạm tính:</span>
                                                    <strong>{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                                                </div>

                                                <!-- Discount -->
                                                @if ($order->discount_amount > 0)
                                                    <div class="d-flex justify-content-between pt-2 small-font">
                                                        <span>Giảm giá:</span>
                                                        <strong>-{{ number_format($order->discount_amount, 0, ',', '.') }}₫</strong>
                                                    </div>
                                                @endif

                                                <!-- Total -->
                                                <div class="d-flex justify-content-between pt-2 small-font">
                                                    <strong>Tổng cộng:</strong>
                                                    <strong>{{ number_format($order->final_amount, 0, ',', '.') }}₫</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Confirmation Details -->
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-2 small-font">
                                                <span>Mã đơn hàng:</span>
                                                <strong>{{ $order->order_code }}</strong>
                                            </div>
                                            <div class="mb-2 small-font">
                                                <span>Trạng thái đơn hàng:</span>
                                                <strong>{{ $order->status }}</strong>
                                            </div>
                                            <div class="mb-2 small-font">
                                                <span>Ngày:</span>
                                                <strong>{{ $order->created_at->format('d/m/Y') }}</strong>
                                            </div>
                                            <div class="mb-2 small-font">
                                                <span>Email:</span>
                                                <strong>{{ auth()->user()->email }}</strong>
                                            </div>
                                            <div class="mb-2 small-font">
                                                <span>Tổng cộng:</span>
                                                <strong>{{ number_format($order->final_amount, 0, ',', '.') }}₫</strong>
                                            </div>
                                            <div class="mb-2 small-font">
                                                <span>Phương thức thanh toán:</span>
                                                <strong>{{ $order->payment_method == 'Cod' ? 'Trả tiền mặt khi nhận hàng' : 'Thanh toán qua VNPAY' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment and Shipping Address -->
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0 py-2">Địa chỉ thanh toán</h5>
                                        </div>
                                        <div class="card-body small-font">
                                            <p><strong>Họ và tên:</strong> {{ $order->full_name }}</p>
                                            <p><strong>Địa chỉ:</strong> {{ $wardName }}, {{ $districtName }},
                                                {{ $provinceName }}</p>
                                            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
                                            <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
