@extends('layouts.admin.main')
@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">
                        <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3">{{ $title }}</h5>
                            <div class="d-flex flex-column flex-md-row">
                                <a href="{{ route('attributes.create') }}" class="btn btn-primary text-capitalize me-md-3 mb-2 mb-md-0">
                                    Thêm thuộc tính
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-primary text-capitalize">
                                    Danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <h2>Thông tin sản phẩm</h2>
                        <form id="product-form" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Tên sản phẩm:</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name">
                                        @error('product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_description" class="form-label">Mô tả:</label>
                                        <textarea class="form-control" id="editor" name="product_description"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_short_description" class="form-label">Mô tả ngắn:</label>
                                        <textarea class="form-control" id="editor2" name="product_short_description"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_specification" class="form-label">Thông số:</label>
                                        <textarea class="form-control" id="editor3" name="product_specification"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_type" class="form-label">Sản phẩm:</label>
                                        <select class="form-select" id="product_type" name="product_type" onchange="toggleAttributes()">
                                            <option value="0">Đơn giản</option>
                                            <option value="1">Có biến thể</option>
                                        </select>
                                    </div>
                                    <div class="row" id="simple-product-fields">
                                        <div class="mb-3 col-12 col-md-6">
                                            <label for="product_base_price" class="form-label">Giá gốc:</label>
                                            <input type="number" step="0.01" class="form-control" id="product_base_price" name="product_base_price">
                                            @error('product_base_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-12 col-md-6">
                                            <label for="store_quantity" class="form-label">Kho:</label>
                                            <input type="number" id="store_quantity" name="store_quantity" class="form-control">
                                            @error('store_quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="product_attributes" class="d-none">
                                        <h2>Thuộc tính sản phẩm</h2>
                                        <div id="attributes">
                                            <div class="attribute row">
                                                <div class="col-12 col-md-6">
                                                    <label for="attribute_1" class="form-label">Thuộc tính:</label>
                                                    <select id="attribute_1" name="attributes[]" onchange="updateVariants()" class="form-select">
                                                        @foreach ($attributes as $attribute)
                                                            <option value="{{ $attribute->id }}">{{ $attribute->attribute_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="attribute_values_1" class="form-label">Giá trị:</label>
                                                    <input type="text" name="attribute_values[]" id="attribute_values_1" oninput="updateVariants()" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" onclick="addAttribute()" class="btn btn-primary mt-3">Thêm thuộc tính</button>
                                        <h2>Biến thể sản phẩm</h2>
                                        <div id="variants">
                                            <!-- Các biến thể sẽ được tạo động tại đây -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Danh mục sản phẩm</label>
                                        <select class="form-select" id="category_id" name="category_id">
                                            @foreach ($productCategories as $productCategory)
                                                <option value="{{ $productCategory->id }}">{{ $productCategory->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="main_image_url" class="form-label">Ảnh chính:</label>
                                        <img id="main_image" class="w-100" src="{{ asset('images/no_images.jpg') }}" alt="main_image">
                                        <input type="file" class="form-control d-none" id="main_image_url" name="main_image_url" onchange="previewMainImage(this)">
                                        <label for="main_image_url" class="btn btn-primary btn-icon mt-3">
                                            <i class="fas fa-upload"></i> Tải ảnh chính
                                        </label>
                                        @error('main_image_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="sub_images_urls" class="form-label">Ảnh phụ:</label>
                                        <div class="row" id="sub_images_preview"></div>
                                        <input type="file" class="form-control" id="sub_images_urls" name="sub_images_urls[]" onchange="previewSubImages(this)" multiple>
                                        <label for="sub_images_urls" class="btn btn-primary btn-icon mt-3"> <i class="fas fa-upload"></i> Tải ảnh phụ </label>
                                        @error('sub_images_urls')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-0">Sản phẩm hot</p><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hot" value="1">
                                            <label class="form-check-label">Có</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hot" value="0" checked>
                                            <label class="form-check-label">Không</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-0">Trạng thái</p><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="active" name="status" value="1" checked>
                                            <label class="form-check-label" for="active">Hiển thị</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="inactive" name="status" value="0">
                                            <label class="form-check-label" for="inactive">Ẩn</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button type="submit" class="btn btn-primary mt-3">Thêm sản phẩm</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                            function previewMainImage(input) {
                                const mainImage = document.getElementById('main_image');
                                if (input.files && input.files[0]) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        mainImage.src = e.target.result;
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }

                            function previewSubImages(input) {
                                const subImagesPreview = document.getElementById('sub_images_preview');
                                subImagesPreview.innerHTML = '';
                                if (input.files && input.files.length > 0) {
                                    for (let i = 0; i < input.files.length; i++) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const img = document.createElement('img');
                                            img.src = e.target.result;
                                            img.classList.add('w-25', 'mx-0', 'my-1');
                                            subImagesPreview.appendChild(img);
                                        }
                                        reader.readAsDataURL(input.files[i]);
                                    }
                                }
                            }

                            function toggleAttributes() {
                                const productType = document.getElementById('product_type').value;
                                const productAttributes = document.getElementById('product_attributes');
                                const simpleProductFields = document.getElementById('simple-product-fields');

                                if (productType === '1') {
                                    productAttributes.classList.remove('d-none');
                                    simpleProductFields.classList.add('d-none');
                                    document.getElementById('product_base_price').required = false;
                                    document.getElementById('store_quantity').required = false;
                                } else {
                                    productAttributes.classList.add('d-none');
                                    simpleProductFields.classList.remove('d-none');
                                    document.getElementById('product_base_price').required = true;
                                    document.getElementById('store_quantity').required = true;
                                }
                            }

                            let attributeCount = 1;

                            function addAttribute() {
                                attributeCount++;
                                const attributesDiv = document.getElementById('attributes');
                                const newAttribute = document.createElement('div');
                                newAttribute.classList.add('attribute');
                                newAttribute.innerHTML = `
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="attribute_${attributeCount}" class="form-label">Thuộc tính:</label>
                                            <select id="attribute_${attributeCount}" name="attributes[]" onchange="updateVariants()" class="form-select">
                                                @foreach ($attributes as $attribute)
                                                    <option value="{{ $attribute->id }}">{{ $attribute->attribute_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="attribute_values_${attributeCount}" class="form-label">Giá trị:</label>
                                            <input type="text" name="attribute_values[]" id="attribute_values_${attributeCount}" oninput="updateVariants()" class="form-control">
                                        </div>
                                        
                                    </div>
                                `;
                                attributesDiv.appendChild(newAttribute);
                            }
                            function updateVariants() {
                                const attributesDiv = document.getElementById('attributes');
                                const variantsDiv = document.getElementById('variants');
                                const attributeElements = attributesDiv.getElementsByClassName('attribute');
                                let attributeData = [];

                                for (let i = 0; i < attributeElements.length; i++) {
                                    const select = attributeElements[i].querySelector('select');
                                    const input = attributeElements[i].querySelector('input[type="text"]');
                                    if (select && input) {
                                        attributeData.push({
                                            attribute: select.options[select.selectedIndex].text,
                                            attributeId: select.value,
                                            values: input.value.split('|').map(value => value.trim())
                                        });
                                    }
                                }

                                let combinations = getCombinations(attributeData);
                                variantsDiv.innerHTML = '';
                                combinations.forEach((combination, index) => {
                                    const sku = generateSKU(combination);
                                    const variantDiv = document.createElement('div');
                                    variantDiv.classList.add('variant');
                                    variantDiv.innerHTML = `
                                        <div class="variant row">
                                            <div class="col-3">
                                                <label for="main_image_variant_${index + 1}_preview" class="form-label">Ảnh chính:</label>
                                                <img id="main_image_variant_${index + 1}_preview" class="w-100" src="{{ asset('images/no_images.jpg') }}" alt="main_image">
                                                <input type="file" id="variants_${index}_main_image" name="variants[${index}][main_image]" class="form-control d-none" onchange="previewMainImage_variant(this, ${index + 1})">
                                                <label for="variants_${index}_main_image" class="btn btn-primary btn-icon mt-3">
                                                    <i class="fas fa-upload"></i> Tải ảnh chính
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="sku_${index + 1}" class="form-label">SKU:</label>
                                                <input type="text" id="sku_${index + 1}" name="variants[${index}][sku]" value="${sku}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="price_${index + 1}" class="form-label">Giá:</label>
                                                <input type="number" step="0.01" id="price_${index + 1}" name="variants[${index}][price]" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="stock_${index + 1}" class="form-label">Kho:</label>
                                                <input type="number" id="stock_${index + 1}" name="variants[${index}][stock]" class="form-control">
                                            </div>
                                            ${combination.map(attr => `
                                                                                                                                                                        <input type="hidden" name="variants[${index}][attributes][]" value="${attr.attributeId}">
                                                                                                                                                                        <input type="hidden" name="variants[${index}][attribute_values][]" value="${attr.value}">
                                                                                                                                                                    `).join('')}
                                        </div>
                                    `;
                                    variantsDiv.appendChild(variantDiv);
                                });
                            }

                            function previewMainImage_variant(input, index) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        document.getElementById(`main_image_variant_${index}_preview`).src = e.target.result;
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }

                            function slugify(str) {
                                const from =
                                    "ÁÀẢÃẠÂẤẦẨẪẬĂẮẰẲẴẶÉÈẺẼẸÊẾỀỂỄỆÍÌỈĨỊÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÚÙỦŨỤƯỨỪỬỮỰÝỲỶỸỴĐáàảãạâấầẩẫậăắằẳẵặéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđ";
                                const to =
                                    "AAAAAAAAAAAAAAAAAEEEEEEEEEEEIIIIIOOOOOOOOOOOOOOOOOUUUUUUUUUUUYYYYYDaaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd";
                                const mapping = {};
                                for (let i = 0; i < from.length; i++) {
                                    mapping[from.charAt(i)] = to.charAt(i);
                                }

                                const slug = str.split('').map(char => mapping[char] || char)
                                    .join('')
                                    .toLowerCase()
                                    .replace(/[^a-z0-9]+/g, '_')
                                    .replace(/^_|_$/g, '');

                                return slug;
                            }

                            function getCombinations(attributes) {
                                if (attributes.length === 0) return [];
                                let result = attributes[0].values.map(value => [{
                                    attribute: attributes[0].attribute,
                                    attributeId: attributes[0].attributeId,
                                    value
                                }]);
                                for (let i = 1; i < attributes.length; i++) {
                                    const currentValues = attributes[i].values;
                                    const newResult = [];
                                    result.forEach(combination => {
                                        currentValues.forEach(value => {
                                            newResult.push([...combination, {
                                                attribute: attributes[i].attribute,
                                                attributeId: attributes[i].attributeId,
                                                value
                                            }]);
                                        });
                                    });
                                    result = newResult;
                                }
                                return result;
                            }

                            function generateSKU(combination) {
                                return combination.map(attr => slugify(attr.value)).join('_');
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
