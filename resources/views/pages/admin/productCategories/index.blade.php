@extends ('layouts.admin.main')
@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 ">
                        <div
                            class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3">{{ $title }}</h5>
                            <a href="{{ route('productCategories.create') }}"><button type="button"
                                    class="btn btn-primary text-capitalize me-4">
                                    Thêm mới
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên
                                            Loại Sản Phẩm</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Trạng Thái</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ngày tạo</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productCategories as $productCategory)
                                        <tr>
                                            <td>
                                                <h6 class="px-3 mb-0 text-sm">{{ $productCategory->category_name }}</h6>
                                            </td>

                                            <td class="text-center text-sm ">
                                                <button
                                                    class="btn btn-sm toggle-status mb-0 {{ $productCategory->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                    data-id="{{ $productCategory->id }}"
                                                    data-status="{{ $productCategory->status }}">
                                                    {{ $productCategory->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                </button>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php 
                                                    if ($productCategory->created_at) {
                                                        ?>
                                                <span
                                                    class="">{{ $productCategory->created_at->format('d/m/Y') }}</span>
                                                <?php
                                                    }
                                                    ?>

                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('productCategories.edit', $productCategory->id) }}">
                                                        <button type="button"
                                                            class="btn btn-warning text-capitalize text-xs mb-0 me-2">Sửa</button>
                                                    </a>
                                                    <form id="delete-form-{{ $productCategory->id }}"
                                                        action="{{ route('productCategories.destroy', $productCategory->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="confirmDelete('{{ $productCategory->id }}')"
                                                            class="btn btn-danger text-capitalize text-xs mb-0">Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                                <script>
                                                    function confirmDelete(id) {
                                                        if (confirm('Bạn có chắc muốn xóa?')) {
                                                            document.getElementById('delete-form-' + id).submit();
                                                        }
                                                    }
                                                    // {{-- productCategorie  --}}
                                                    $(document).ready(function() {
                                                        $('.toggle-status').click(function() {
                                                            var button = $(this);
                                                            var productCategoryId = button.data('id');
                                                            var currentStatus = button.data('status');
                                                            var newStatus = currentStatus == 1 ? 0 : 1;

                                                            // Lấy CSRF Token từ thẻ meta
                                                            var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                            $.ajax({
                                                                url: '/admin/danh-muc/sua-trang-thai/' + productCategoryId,
                                                                type: 'PUT',
                                                                data: {
                                                                    status: newStatus,
                                                                    _token: csrfToken // Thêm CSRF Token vào dữ liệu gửi
                                                                },

                                                                success: function(response) {
                                                                    // Cập nhật trạng thái và văn bản của nút
                                                                    button.data('status', newStatus);
                                                                    button.text(newStatus == 1 ? 'Hiển thị' : 'Ẩn');

                                                                    // Xóa lớp màu của nút hiện tại
                                                                    button.removeClass('btn-success btn-danger');

                                                                    // Thêm lớp màu mới cho nút dựa trên trạng thái mới
                                                                    if (newStatus == 1) {
                                                                        button.addClass('btn-success');
                                                                    } else {
                                                                        button.addClass('btn-danger');
                                                                    }
                                                                },
                                                                error: function() {
                                                                    alert('Đã xảy ra lỗi khi cập nhật trạng thái.');
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
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
    </div>
@endsection
