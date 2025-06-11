@extends('layouts.client.main')
@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-3">ĐƠN HÀNG CỦA TÔI</h3>
        @if($orders->isEmpty())
            <p class="text-center">Bạn chưa có đơn hàng nào.</p>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-danger">
                            <h5 class="mb-0 py-2">Danh Sách Đơn Hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mã Đơn Hàng</th>
                                            <th>Ngày Đặt</th>
                                            <th>Tổng Tiền</th>
                                            <th>Trạng Thái</th>
                                            <th>Chi Tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td> <a href="{{ route('orderReceived', $order->id) }}">{{ $order->order_code }}</a></td>
                                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                <td>{{ number_format($order->final_amount, 0, ',', '.') }}₫</td>
                                                <td>{{ ucfirst($order->status) }}</td>
                                                <td><a href="{{ route('orderReceived', $order->id) }}" class="btn btn-danger btn-sm">Xem</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
