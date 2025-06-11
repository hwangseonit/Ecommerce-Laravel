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
                            <a href="{{ route('banner.create') }}"><button type="button"
                                    class="btn btn-primary text-capitalize me-4">
                                    Thêm mới
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">

                                <tbody>
                                    @if ($banners->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">Chưa có banner</td>
                                        </tr>
                                    @else
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Ảnh</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Trạng thái</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        @foreach ($banners as $banner)
                                            <tr>
                                                <td class="col-8">
                                                    <div data-bs-toggle="modal" data-bs-target="#imageBannerModal">
                                                        <img src="{{ asset('images/' . $banner->image) }}"
                                                            class="w-100 me-3 border-radius-lg" alt="user1">
                                                    </div>
                                                </td>
                                                <td class="text-center text-sm ">
                                                    <button
                                                        class="btn btn-sm toggle-status mb-0 {{ $banner->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                        data-id="{{ $banner->id }}" data-status="{{ $banner->status }}">
                                                        {{ $banner->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('banner.edit', $banner->id) }}">
                                                            <button type="button"
                                                                class="btn btn-warning text-capitalize text-xs mb-0 me-2">Sửa</button>
                                                        </a>
                                                        <form id="delete-form-{{ $banner->id }}"
                                                            action="{{ route('banner.destroy', $banner->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                onclick="confirmDelete('{{ $banner->id }}')"
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
                                                        // {{-- banner  --}}
                                                        $(document).ready(function() {
                                                            $('.toggle-status').click(function() {
                                                                var button = $(this);
                                                                var bannerId = button.data('id');
                                                                var currentStatus = button.data('status');
                                                                var newStatus = currentStatus == 1 ? 0 : 1;
                                                    
                                                                // Lấy CSRF Token từ thẻ meta
                                                                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                                    
                                                                $.ajax({
                                                                    url: '/admin/banners/toggleBannerStatus/' + bannerId,
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
                                                                        alert('Đã xảy ra lỗi khi cập nhật trạng thái banner.');
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    </script>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
