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
                            <h5 class="text-white text-capitalize ps-3 mb-0">Thêm giảm giá</h5>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <form action="{{ route('discounts.store') }}" method="POST" class="px-3">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="event_name">Tên sự kiện</label>
                                        <input type="text" name="event_name"
                                            class="form-control @error('event_name') is-invalid @enderror"
                                            value="{{ old('event_name') }}">
                                        @error('event_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="product_ids[]"
                                                value="{{ $product->id }}" id="product{{ $product->id }}">
                                            <label class="form-check-label" for="product{{ $product->id }}">
                                                {{ $product->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @error('product_ids')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endforeach
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Ngày bắt đầu</label>
                                        <input type="date" name="start_date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            value="{{ old('start_date') }}">
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
                                            value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount_percentage">Giảm giá (%)</label>
                                        <input type="text" name="discount_percentage"
                                            class="form-control @error('discount_percentage') is-invalid @enderror"
                                            value="{{ old('discount_percentage') }}">
                                        @error('discount_percentage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
