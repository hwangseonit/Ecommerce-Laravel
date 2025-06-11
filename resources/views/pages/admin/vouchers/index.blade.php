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
                            <h5 class="text-white text-capitalize ps-3 mb-0">Danh sách voucher</h5>
                            <a href="{{ route('vouchers.create') }}" class="btn btn-primary text-capitalize me-4">Thêm mới</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Code
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày
                                            bắt đầu</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày
                                            kết thúc</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số
                                            lượng</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Đã
                                            dùng</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giảm
                                            giá (%)</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giảm
                                            tối đa</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $index => $voucher)
                                        <tr>
                                            <td class="ps-4">{{ $index + 1 }}</td>
                                            <td>{{ $voucher->code }}</td>
                                            <td>{{ $voucher->start_date }}</td>
                                            <td>{{ $voucher->end_date }}</td>
                                            <td>{{ $voucher->quantity }}</td>
                                            <td>{{ $voucher->used }}</td>
                                            <td>{{ intval($voucher->discount_percentage) }}%</td>
                                            <td>{{ number_format($voucher->max_discount_amount, 0, ',', '.') }}đ</td>
                                            <td class="text-center">
                                                <a href="{{ route('vouchers.edit', $voucher->id) }}"
                                                    class="btn btn-warning btn-sm">Sửa</a>
                                                <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $vouchers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
