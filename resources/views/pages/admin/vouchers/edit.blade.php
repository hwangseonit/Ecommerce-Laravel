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
                            <h5 class="text-white text-capitalize ps-3 mb-0">Chỉnh sửa voucher</h5>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST" class="px-3">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Code</label>
                                        <input type="text" name="code"
                                            class="form-control @error('code') is-invalid @enderror"
                                            value="{{ old('code', $voucher->code) }}">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantity">Số lượng</label>
                                        <input type="number" name="quantity"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            value="{{ old('quantity', $voucher->quantity) }}">
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Ngày bắt đầu</label>
                                        <input type="date" name="start_date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            value="{{ old('start_date', $voucher->start_date) }}">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">Ngày kết thúc</label>
                                        <input type="date" name="end_date"
                                            class="form-control @error('end_date') is-invalid @enderror"
                                            value="{{ old('end_date', $voucher->end_date) }}">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount_percentage">Giảm giá (%)</label>
                                        <input type="text" name="discount_percentage"
                                            class="form-control @error('discount_percentage') is-invalid @enderror"
                                            value="{{ old('discount_percentage', intval($voucher->discount_percentage)) }}">
                                        @error('discount_percentage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_discount_amount">Giảm tối đa</label>
                                        <input type="text" name="max_discount_amount"
                                            class="form-control @error('max_discount_amount') is-invalid @enderror"
                                            value="{{ old('max_discount_amount', intval($voucher->max_discount_amount))}}">
                                        @error('max_discount_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
