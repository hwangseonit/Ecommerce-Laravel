@extends('layouts.admin.main')
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
                            <div>
                                <a href="{{ route('attributes.index') }}"><button type="button"
                                        class="btn btn-primary text-capitalize me-4">
                                        Danh sách
                                    </button>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="p-3">
                                    <form id="productAddForm" action="{{ route('product.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label for="name" class="form-label">Tên thuộc tính</label>
                                                <input type="text" class="form-control" id="name" name="name">
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="productType" class="form-label">Loại sản phẩm</label>
                                                <select class="form-select" id="productType" name="productType"
                                                    onchange="toggleVariantInputs()">
                                                    <option value="simple">Sản phẩm đơn giản</option>
                                                    <option value="variant">Sản phẩm có biến thể</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-12" id="addAttributeInputs" style="display: none;">
                                                <button type="button" class="btn btn-primary" onclick="addAttributeRow()">+
                                                    Thêm thuộc tính </button>
                                            </div>
                                            <div class="mb-3 col-6" id="attributeInputs" style="display: none;">
                                                <label for="attribute" class="form-label">Thuộc Tính</label>
                                                <input type="text" class="form-control" id="attribute" name="attribute">
                                            </div>
                                            <div class="mb-3 col-6" id="variantInputs" style="display: none;">
                                                <label for="value" class="form-label">Giá trị</label>
                                                <input type="text" class="form-control" id="value" name="value">
                                            </div>

                                            <div class="mb-3 col-6" id="base_priceInputs">
                                                <label for="base_price" class="form-label">Giá</label>
                                                <input type="number" class="form-control" id="base_price"
                                                    name="base_price">
                                            </div>
                                            <div class="mb-3 col-6"id="discounted_priceInputs">
                                                <label for="discounted_price" class="form-label">Giá giảm</label>
                                                <input type="number" class="form-control" id="discounted_price"
                                                    name="discounted_price">
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Mô Tả</label>
                                                <textarea class="form-control" id="description" name="description"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="short_description" class="form-label">Mô Tả Ngắn</label>
                                                <textarea class="form-control" id="short_description" name="short_description"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="specs" class="form-label">Thông số</label>
                                                <textarea class="form-control" id="specs" name="specs"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="image" class="form-label">Ảnh</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="thumbnail_image" class="form-label">Ảnh mô tả</label>
                                                <input type="file" class="form-control" id="thumbnail_image"
                                                    name="thumbnail_image">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('product.index') }}"><button type="button"
                                                    class="btn btn-secondary me-2">Đóng</button></a>
                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3 col-6">
                                    <label for="category_id" class="form-label">Loại sản phẩm</label>
                                    <select class="form-select" id="category_id" name="category_id">
                                        <option value="Đỏ">Đỏ</option>
                                        <option value="Xanh">Xanh</option>
                                        <option value="Vàng">Vàng</option>
                                    </select>
                                </div>
                                <img id="previewImage" class="w-100" src="{{ asset('images/no_images.jpg') }}"
                                    alt="Preview">
                            </div>
                        </div>
                        <script>
                            function toggleVariantInputs() {
                                var selectBox = document.getElementById("productType");
                                var variantInputs = document.getElementById("variantInputs");

                                if (selectBox.value === "variant") {
                                    variantInputs.style.display = "block";
                                    attributeInputs.style.display = "block";
                                    addAttributeInputs.style.display = "block";
                                    base_priceInputs.style.display = "none";
                                    discounted_priceInputs.style.display = "none";

                                } else {
                                    attributeInputs.style.display = "none";
                                    variantInputs.style.display = "none";
                                    addAttributeInputs.style.display = "none";
                                    base_priceInputs.style.display = "block";
                                    discounted_priceInputs.style.display = "block";

                                }
                            }

                            function previewImage(event) {
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var output = document.getElementById('previewImage');
                                    output.src = reader.result;
                                }
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
