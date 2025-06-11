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
                            <h5 class="text-white text-capitalize ps-3">{{ $title }}</h5>
                            <a href="{{ route('postCategory.index') }}">
                                <button type="button" class="btn btn-primary text-capitalize me-4">Danh sách</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <div class="row">
                            <div class="col-6">
                                <!-- Ở đây bạn có thể hiển thị hình ảnh nếu cần -->
                            </div>
                            <div class="col-6">
                                <div class="p-3">
                                    <form id="postCategoriesAddForm" action="{{ route('postCategory.store') }}"
                                        method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên Loại bài viết</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug">
                                            @error('slug')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng Thái</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" name="status"
                                                    value="1" checked>
                                                <label class="form-check-label" for="active">Hiển Thị</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" name="status"
                                                    value="0">
                                                <label class="form-check-label" for="inactive">Ẩn</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('postCategory.index') }}">
                                                <button type="button" class="btn btn-secondary me-2">Đóng</button>
                                            </a>
                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <script>
                            function toSlug(str) {
                                str = str.toLowerCase();
                                // Remove accents
                                str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                                // Replace spaces with -
                                str = str.replace(/\s+/g, '-');
                                // Remove all non-word chars
                                str = str.replace(/[^\w\-]+/g, '');
                                // Replace multiple - with single -
                                str = str.replace(/\-\-+/g, '-');
                                // Trim - from start and end of text
                                str = str.replace(/^-+/, '').replace(/-+$/, '');
                                return str;
                            }

                            document.getElementById('name').addEventListener('input', function() {
                                var name = this.value;
                                var slug = toSlug(name);
                                document.getElementById('slug').value = slug;
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
