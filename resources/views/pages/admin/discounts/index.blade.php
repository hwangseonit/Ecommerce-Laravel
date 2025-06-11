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
                            <h5 class="text-white text-capitalize ps-3 mb-0">Danh sách giảm giá</h5>
                            <a href="{{ route('products.index') }}">
                                <button type="button" class="btn btn-primary text-capitalize mb-0 me-4">Danh sách sản phẩm</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên sự kiện</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sản phẩm</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giảm giá (%)</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số tiền giảm</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày bắt đầu</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày kết thúc</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discounts as $discount)
                                        <tr>
                                            <td class="ps-4"><input type="checkbox" class="discount-checkbox" value="{{ $discount->id }}"></td>
                                            <td>{{ $discount->id }}</td>
                                            <td>{{ $discount->event_name }}</td>
                                            <td>{{ $discount->product->name }}</td>
                                            <td>{{ $discount->discount_percentage ?? 'N/A' }}</td>
                                            <td>{{ $discount->discount_amount ?? 'N/A' }}</td>
                                            <td>{{ $discount->start_date }}</td>
                                            <td>{{ $discount->end_date }}</td>
                                            <td class="align-middle">
                                                <a href="{{ route('discounts.edit', $discount->id) }}"
                                                    class="btn btn-warning text-capitalize text-xs mb-0">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="ms-3 mt-3">
                                <button id="select-all-btn" class="btn btn-primary p-2 me-3">Chọn tất cả</button>
                                <button id="delete-selected" class="btn btn-primary p-2">Xóa</button>
                            </div>
                            <div class="ms-3 mt-3">
                                {{ $discounts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Chọn tất cả checkbox khi bấm vào nút "Chọn tất cả"
            document.getElementById('select-all-btn').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.discount-checkbox');
                const selectAll = document.getElementById('select-all');
                const isChecked = !selectAll.checked;

                checkboxes.forEach((checkbox) => {
                    checkbox.checked = isChecked;
                });

                selectAll.checked = isChecked;
            });

            // Chọn tất cả checkbox
            document.getElementById('select-all').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.discount-checkbox');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });
            });

            // Xóa các giảm giá đã chọn
            document.getElementById('delete-selected').addEventListener('click', function() {
                const selectedDiscounts = [];
                document.querySelectorAll('.discount-checkbox:checked').forEach((checkbox) => {
                    selectedDiscounts.push(checkbox.value);
                });

                if (selectedDiscounts.length > 0) {
                    if (confirm('Bạn có chắc chắn muốn xóa các giảm giá đã chọn?')) {
                        fetch('{{ route('discounts.bulkDelete') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    ids: selectedDiscounts
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    location.reload();
                                } else {
                                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                            });
                    }
                } else {
                    alert('Vui lòng chọn ít nhất một giảm giá để xóa.');
                }
            });
        });
    </script>
@endsection
