@extends('layouts.admin.main')

@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3">
                    <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <h5 class="text-white text-capitalize ps-3 mb-0">Danh sách sản phẩm</h5>
                        <div class="d-flex flex-column flex-md-row">
                            <form id="searchForm" action="{{ route('products.index') }}" method="GET" class="d-flex mb-2 mb-md-0 me-md-3">
                                <div class="input-group">
                                    <input id="searchInput" type="text" name="search" class="form-control" placeholder="Tìm kiếm" value="{{ request('search') }}">
                                </div>
                            </form>
                            <!-- Form lọc biến thể -->
                            <form id="has_variantsForm" action="{{ route('products.index') }}" method="GET" class="d-flex mb-2 mb-md-0 me-md-3">
                                <div class="input-group">
                                    <select id="has_variants" name="has_variants" class="form-select" onchange="this.form.submit()">
                                        <option value="">Tất cả biến thể</option>
                                        @foreach ($uniqueHasVariants as $variant)
                                            <option value="{{ $variant }}" {{ request('has_variants') == $variant ? 'selected' : '' }}>
                                                {{ $variant == 1 ? 'Có biến thể' : 'Không biến thể' }}
                                            </option>
                                        @endforeach
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
                            <div class="d-flex flex-column flex-md-row">
                                <a href="{{ route('discounts.index') }}" class="btn btn-primary mb-2 mb-md-0 me-md-3">Danh sách giảm giá</a>
                                <a href="{{ route('product.create') }}" class="btn btn-primary  mb-2 mb-md-0">Thêm mới</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sản phẩm</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giá</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Loại sản phẩm</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Biến thể</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Số lượng</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($products))
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><input type="checkbox" class="product-checkbox ms-3" value="{{ $product->id }}"></td>
                                            <td>
                                                <a href="{{ route('product.show', $product->id) }}" class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('images/' . $product->image_url) }}" class="avatar avatar-sm me-3 border-radius-lg" alt="{{ $product->image_url }}">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm ellipsis">{{ $product->name }}</h6>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $product->price_range }} vnđ</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $product->category->category_name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $product->has_variants ? 'Có' : 'Không' }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $product->total_stock }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge bg-gradient-{{ $product->status ? 'success' : 'danger' }}">{{ $product->status ? 'Hiển thị' : 'Ẩn' }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning text-capitalize text-xs mb-0">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="8" class="text-center">Chưa có sản phẩm</td></tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="ms-3 mt-3">
                            <button id="select-all-btn" class="btn btn-primary p-2 me-3">Chọn tất cả</button>
                            <button id="delete-selected" class="btn btn-primary p-2">Xóa</button>
                            <button id="discount-selected" class="btn btn-primary p-2">Thêm giảm giá</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $products->links() }}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Chọn tất cả checkbox khi bấm vào nút "Chọn tất cả"
            document.getElementById('select-all-btn').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                const selectAll = document.getElementById('select-all');
                const isChecked = !selectAll.checked;

                checkboxes.forEach((checkbox) => {
                    checkbox.checked = isChecked;
                });

                selectAll.checked = isChecked;
            });

            // Chọn tất cả checkbox
            document.getElementById('select-all').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });
            });

            // Xóa các sản phẩm đã chọn
            document.getElementById('delete-selected').addEventListener('click', function() {
                const selectedProducts = [];
                document.querySelectorAll('.product-checkbox:checked').forEach((checkbox) => {
                    selectedProducts.push(checkbox.value);
                });

                if (selectedProducts.length > 0) {
                    if (confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?')) {
                        fetch('{{ route('products.bulkDelete') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    ids: selectedProducts
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
                    alert('Vui lòng chọn ít nhất một sản phẩm để xóa.');
                }
            });

            // Thêm giảm giá cho các sản phẩm đã chọn
            document.getElementById('discount-selected').addEventListener('click', function() {
                const selectedProducts = [];
                document.querySelectorAll('.product-checkbox:checked').forEach((checkbox) => {
                    selectedProducts.push(checkbox.value);
                });

                if (selectedProducts.length > 0) {
                    const form = document.createElement('form');
                    form.method = 'GET';
                    form.action = '{{ route('discounts.create') }}';

                    selectedProducts.forEach(productId => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'products[]';
                        input.value = productId;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                } else {
                    alert('Vui lòng chọn ít nhất một sản phẩm để thêm giảm giá.');
                }
            });
        });
    </script>
@endsection
