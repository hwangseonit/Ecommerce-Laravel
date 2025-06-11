@extends ('layouts.admin.main')
@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">
                        <div
                            class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3">Thêm Bài Viết</h5>
                            <a href="{{ route('post.index') }}">
                                <button type="button" class="btn btn-primary text-capitalize me-md-4 mb-2 mb-md-0">Danh sách</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <img id="previewImage" class="w-100 mb-3" src="{{ asset('images/no_images.jpg') }}" alt="Preview">
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="p-3">
                                    <form id="postAddForm" action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Tiêu đề</label>
                                            <input type="text" class="form-control" id="title" name="title">
                                            @error('title')
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
                                            <label for="user_id" class="form-label">Tác giả</label>
                                            <select class="form-select" id="user_id" name="user_id">
                                                @foreach ($authors as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="post_category_id" class="form-label">Danh mục</label>
                                            <select class="form-select" id="post_category_id" name="post_category_id">
                                                @foreach ($categories as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('post_category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Mô tả ngắn</label>
                                            <input type="text" class="form-control" id="description" name="description">
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Nội dung bài viết</label>
                                            <textarea id="editor" name="content"></textarea>
                                            @error('content')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Ảnh</label>
                                            <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng thái</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" name="status" value="1" checked>
                                                <label class="form-check-label" for="active">Hiển thị</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" name="status" value="0">
                                                <label class="form-check-label" for="inactive">Ẩn</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('post.index') }}">
                                                <button type="button" class="btn btn-secondary me-2">Đóng</button>
                                            </a>
                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('previewImage');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
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

        document.getElementById('title').addEventListener('input', function() {
            var title = this.value;
            var slug = toSlug(title);
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection
