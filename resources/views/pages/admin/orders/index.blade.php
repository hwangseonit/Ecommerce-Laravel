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
                            <h5 class="text-white text-capitalize ps-3 mb-0">Danh sách đơn hàng</h5>
                            <div class="d-flex me-3">
                                <form id="searchForm" action="{{ route('admin.orders.index') }}" method="GET"
                                    class="d-flex">
                                    <div class="input-group input-group-outline me-3">
                                        <input id="searchInput" type="text" name="search" class="form-control"
                                            placeholder="Tìm kiếm" onfocus="focused(this)" onfocusout="defocused(this)"
                                            value="{{ request('search') }}">
                                    </div>
                                </form>
                                <form id="statusForm" action="{{ route('admin.orders.index') }}" method="GET"
                                    class="d-flex">
                                    <div class="input-group input-group-outline">
                                        <select id="statusFilter" name="status" class="rounded"
                                            onchange="this.form.submit()">
                                            <option value="">Tất cả trạng thái</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="processing"
                                                {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                                            </option>
                                            <option value="completed"
                                                {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="canceled"
                                                {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                        </select>
                                    </div>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        let typingTimer;
                                        let doneTypingInterval = 1000;

                                        $('#searchInput').on('keyup', function() {
                                            clearTimeout(typingTimer);
                                            typingTimer = setTimeout(doneTyping, doneTypingInterval);
                                        });

                                        function doneTyping() {
                                            $('#searchForm').submit();
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã
                                            đơn hàng</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Khách hàng</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Ngày đặt hàng</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tổng tiền</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Trạng thái</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Thay đổi trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($orders) && $orders->count() > 0)
                                        @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0 ps-3">
                                                        {{ $orders->firstItem() + $index }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm order-code">{{ $order->order_code }}
                                                            </h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $order->full_name }}</p>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $order->phone }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $order->created_at->format('d/m/Y') }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ number_format($order->final_amount, 0, ',', '.') }} vnđ</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm bg-gradient-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'completed' ? 'success' : 'danger')) }}">{{ $order->status }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($order->status != 'completed' && $order->status != 'canceled')
                                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <select name="status" class="form-select form-select-sm"
                                                                onchange="this.form.submit()">
                                                                @if ($order->status == 'pending')
                                                                    <option value="pending" selected>Pending</option>
                                                                    <option value="processing">Processing</option>
                                                                    <option value="canceled">Canceled</option>
                                                                @elseif ($order->status == 'processing')
                                                                    <option value="processing" selected>Processing</option>
                                                                    <option value="completed">Completed</option>
                                                                    <option value="canceled">Canceled</option>
                                                                @endif
                                                            </select>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Chưa có đơn hàng phù hợp</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ $orders->links() }}
    </div>
@endsection
