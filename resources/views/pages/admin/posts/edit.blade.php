@extends ('layouts.admin.main')
@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">
                        <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3">Chỉnh Sửa Bài Viết</h5>
                            <a href="{{ route('post.index') }}" class="btn btn-primary text-capitalize me-md-4 mb-2 mb-md-0">
                                Danh sách
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="p-3">
                                    <form id="postEditForm" action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') <!-- Sử dụng phương thức PUT để cập nhật bài viết -->

                                        <div class="mb-3">
                                            <label for="title" class="form-label">Tiêu đề</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}"> <!-- Hiển thị tiêu đề của bài viết -->
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug" value="{{ $post->slug }}"> <!-- Hiển thị slug của bài viết -->
                                            @error('slug')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="user_id" class="form-label">Tác giả</label>
                                            <select class="form-select" id="user_id" name="user_id">
                                                @foreach ($authors as $id => $name)
                                                    <option value="{{ $id }}" @if ($post->user_id == $id) selected @endif>{{ $name }}</option>
                                                    <!-- Chọn tác giả đã được lưu trong bài viết -->
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="post_category_id" class="form-label">Danh mục</label>
                                            <select class="form-select" id="post_category_id" name="post_category_id">
                                                @foreach ($categories as $id => $name)
                                                    <option value="{{ $id }}" @if ($post->post_category_id == $id) selected @endif>{{ $name }}</option>
                                                    <!-- Chọn danh mục đã được lưu trong bài viết -->
                                                @endforeach
                                            </select>
                                            @error('post_category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Nội dung bài viết</label>
                                            <textarea id="editor" name="content">{{ $post->content }}</textarea> <!-- Hiển thị nội dung của bài viết -->
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
                                                <input class="form-check-input" type="radio" id="active" name="status" value="1" @if ($post->status == 1) checked @endif>
                                                <!-- Chọn trạng thái đã được lưu trong bài viết -->
                                                <label class="form-check-label" for="active">Hiển thị</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" name="status" value="0" @if ($post->status == 0) checked @endif>
                                                <!-- Chọn trạng thái đã được lưu trong bài viết -->
                                                <label class="form-check-label" for="inactive">Ẩn</label>

                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('post.index') }}"><button type="button" class="btn btn-secondary me-2">Hủy</button></a>
                                            <!-- Đổi từ "Đóng" thành "Hủy" -->
                                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                            <!-- Đổi từ "Thêm" thành "Cập Nhật" -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <img id="previewImage" class="w-100" src="{{ asset('images/' . $post->image) }}" alt="Preview">
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
