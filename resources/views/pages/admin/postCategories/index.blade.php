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
                            <h5 class="text-white text-capitalize ps-3">Danh sách loại bài viết</h5>
                            <a href="{{ route('postCategory.create') }}"><button type="button"
                                    class="btn btn-primary text-capitalize me-4">
                                    Thêm mới
                                </button>
                            </a>

                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">

                                <tbody>
                                    @if ($postCategories->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">Chưa có loại bài viết</td>
                                        </tr>
                                    @else
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Tên
                                                    loại bài viết</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Ngày tạo </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Trạng thái</th>
                                                <th class="text-secondary opacity-7"></th>
                                            </tr>
                                        </thead>
                                        @foreach ($postCategories as $postCategory)
                                            <tr>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0 px-3">{{ $postCategory->name }}
                                                    </p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $postCategory->created_at }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <button
                                                        class="btn btn-sm  mb-0 {{ $postCategory->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                        data-id="{{ $postCategory->id }}"
                                                        data-status="{{ $postCategory->status }}">
                                                        {{ $postCategory->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                    </button>
                                                </td>

                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('postCategory.edit', $postCategory->id) }}">
                                                            <button type="button"
                                                                class="btn btn-warning text-capitalize text-xs mb-0 me-2">
                                                                Sửa
                                                            </button>
                                                        </a>
                                                        <form id="delete-form-{{ $postCategory->id }}"
                                                            action="{{ route('postCategory.destroy', $postCategory->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                onclick="confirmDelete({{ $postCategory->id }})"
                                                                class="btn btn-danger text-capitalize text-xs mb-0">
                                                                Xóa {{ $postCategory->id }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <script>
                                                        function confirmDelete(id) {
                                                            if (confirm('Bạn có chắc muốn xóa?')) {
                                                                document.getElementById('delete-form-' + id).submit();
                                                            }
                                                        }
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
        <!-- Thêm PostCategories Modal -->
        <div class="modal fade" id="addPostCategoriesModal" tabindex="-1" aria-labelledby="addPostCategoriesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPostCategoriesModalLabel">Thêm Loại bài viết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->

        <!-- Sửa Loại bài viết Modal -->
        <div class="modal fade " id="editPostCategoriesModal" tabindex="-1" aria-labelledby="editPostCategoriesLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostCategoriesLabel">Sửa loại bài viết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="postCategoriesEditForm">
                            <input type="hidden" id="id" name="id">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên loại bài viết</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="active" name="status"
                                        value="1" checked>
                                    <label class="form-check-label" for="active">Hiển thị</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="inactive" name="status"
                                        value="0">
                                    <label class="form-check-label" for="inactive">Ẩn</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->

    </div>
@endsection
