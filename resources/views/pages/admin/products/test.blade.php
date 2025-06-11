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
                            <div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#listAttribute">
                                Danh sách thuộc tính
                            </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addAttribute">
                                    Thêm thuộc tính
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="addAttribute" data-bs-backdrop="static" data-bs-keyboard="false"
                                    tabindex="-1" aria-labelledby="addAttributeLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAttributeLabel">Thêm thuộc tính</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="test">
                                                    <label for="name" class="form-label">Tên thuộc tính:</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        required>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('product.index') }}" class="btn btn-primary text-capitalize me-4">
                                    Danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <h2>Thông tin sản phẩm</h2>
                        <form id="product-form" action="add_product.php" method="post">
                            <div class="row">
                                <div class="col-8">
                                    <div class="">
                                        <label for="name" class="form-label">Tên sản phẩm:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                        <label for="description" class="form-label">Mô tả:</label>
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                        <label for="description" class="form-label">Mô tả ngắn:</label>
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                        <label for="description" class="form-label">Thông số:</label>
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                        <div class="product-options col-6">
                                            <label for="product_type" class="form-label">Sản phẩm:</label>
                                            <select class="form-select" id="product_type" name="product_type"
                                                onchange="toggleAttributes()">
                                                <option value="0">Đơn giản</option>
                                                <option value="1">Có biến thể</option>
                                            </select>
                                        </div>
                                        <label for="base_price" class="form-label">Giá gốc:</label>
                                        <div class="col-6">
                                            <input type="text" class="form-control " id="base_price" name="base_price"
                                                required>
                                        </div>
                                        <div id="product_attributes" class="d-none">
                                            <h2>Thuộc tính sản phẩm</h2>
                                            <div id="attributes">
                                                <div class="attribute row">
                                                    <div class="col-6">
                                                        <label for="attribute_1" class="form-label">Thuộc tính:</label>
                                                        <select id="attribute_1" name="attributes[]"
                                                            onchange="updateVariants()" class="form-select">
                                                            <option value="1">Màu sắc</option>
                                                            <option value="2">Dung lượng</option>
                                                            <option value="3">Kích thước</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="" class="form-label">Giá trị:</label>
                                                        <input type="text" name="attribute_values[]"
                                                            oninput="updateVariants()" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" onclick="addAttribute()"
                                                class="btn btn-primary mt-3">Thêm
                                                thuộc tính</button>
                                            <h2>Biến thể sản phẩm</h2>
                                            <div id="variants">
                                                <!-- Các biến thể sẽ được tạo động tại đây -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="mb-3 ">
                                            <label for="category_id" class="form-label">Danh mục sản phẩm</label>
                                            <select class="form-select" id="category_id" name="category_id">
                                                <option value="Đỏ">Đỏ</option>
                                                <option value="Xanh">Xanh</option>
                                                <option value="Vàng">Vàng</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="main_image_url" class="form-label">Ảnh chính:</label>
                                            <img id="main_image" class="w-100" src="{{ asset('images/no_images.jpg') }}"
                                                alt="main_image">
                                            <input type="file" class="form-control d-none" id="main_image_url"
                                                name="main_image_url" onchange="previewMainImage(this)" required>
                                            <label for="main_image_url" class="btn btn-primary btn-icon mt-3">
                                                <i class="fas fa-upload"></i> Tải ảnh chính
                                            </label>
                                        </div>


                                        <div class="mb-3">
                                            <label for="sub_images_urls" class="form-label">Ảnh phụ:</label>
                                            <img id="sub_images" class="w-25" src="{{ asset('images/no_images.jpg') }}"
                                                alt="sub_images">
                                            </label>
                                            <div class="row" id="sub_images_preview"></div>
                                            <input type="file" class="form-control d-none" id="sub_images_urls"
                                                name="sub_images_urls[]" onchange="previewSubImages(this)" multiple
                                                required>
                                            <label for="sub_images_urls" class="btn btn-primary btn-icon mt-3"> <i
                                                    class="fas fa-upload"></i> Tải ảnh phụ </label>
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

                                if (productType === '1') {
                                    // Nếu người dùng chọn "Có biến thể", hiển thị phần thuộc tính sản phẩm
                                    productAttributes.classList.remove('d-none');
                                } else {
                                    // Nếu người dùng chọn "Đơn giản", ẩn phần thuộc tính sản phẩm
                                    productAttributes.classList.add('d-none');
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
                                            <label for="attribute_${attributeCount}" class="form-label  ">Thuộc tính:</label>
                                    <select id="attribute_${attributeCount}" name="attributes[]" onchange="updateVariants()" class="form-select ">
                                        <option value="1">Màu sắc</option>
                                        <option value="2">Dung lượng</option>
                                        <option value="3">Kích thước</option>
                                    </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="" class="form-label  ">Giá trị:</label>
                                    <input type="text" name="attribute_values[]" oninput="updateVariants()" class="form-control ">
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

                                // Lấy dữ liệu thuộc tính và giá trị
                                for (let i = 0; i < attributeElements.length; i++) {
                                    const select = attributeElements[i].querySelector('select');
                                    const input = attributeElements[i].querySelector('input[type="text"]');
                                    if (select && input) {
                                        attributeData.push({
                                            attribute: select.options[select.selectedIndex].text,
                                            values: input.value.split('|').map(value => value.trim())
                                        });
                                    }
                                }

                                // Tạo biến thể dựa trên tổ hợp thuộc tính
                                let combinations = getCombinations(attributeData);
                                variantsDiv.innerHTML = ''; // Clear current variants
                                combinations.forEach((combination, index) => {
                                    const sku = generateSKU(combination); // Generate SKU based on attributes
                                    const variantDiv = document.createElement('div');
                                    variantDiv.classList.add('variant');
                                    variantDiv.innerHTML =
                                        ` 
                                        
                                        <div class="variant row">
    <div class="col-3">
        <label for="main_image_variant_${index + 1}" class="form-label">Ảnh chính:</label>
        <img id="main_image_variant_${index + 1}_preview" class="w-100" src="{{ asset('images/no_images.jpg') }}" alt="main_image">
        <input type="file" id="variants[${index}][main_image]" name="variants[${index}][main_image]" required class="form-control d-none" onchange="previewMainImage_variant(this, ${index + 1})">
        <label for="variants[${index}][main_image]" class="btn btn-primary btn-icon mt-3">
            <i class="fas fa-upload"></i> Tải ảnh chính
        </label>
    </div>
    <div class="col-md-12">
        <label for="sku_${index + 1}" class="form-label">SKU:</label>
        <input type="text" id="sku_${index + 1}" name="variants[${index}][sku]" value="${sku}" required class="form-control">
    </div>
    <div class="col-md-6">
        <label for="price_${index + 1}" class="form-label">Giá:</label>
        <input type="text" id="price_${index + 1}" name="variants[${index}][price]" required class="form-control">
    </div>
    <div class="col-md-6">
        <label for="stock_${index + 1}" class="form-label">Tồn kho:</label>
        <input type="text" id="stock_${index + 1}" name="variants[${index}][stock]" required class="form-control">
    </div>
    <div class="col-12">
        <label for="sub_images_variant${index + 1}" class="form-label">Ảnh phụ:</label>
        <div class="row" id="sub_images_variant_${index + 1}_preview">
            <img id="sub_images_variant_${index + 1}_img" class="w-20" src="{{ asset('images/no_images.jpg') }}" alt="sub_images">
        </div>
        <input type="file" id="sub_images_variant_${index + 1}" name="variants[${index}][additional_images][]" multiple required class="form-control d-none" onchange="previewSubImages_variant(this, ${index + 1})">
        <label for="sub_images_variant_${index + 1}" class="btn btn-primary btn-icon mt-3">
            <i class="fas fa-upload"></i> Tải ảnh phụ
        </label>
    </div>
    ${combination.map(attr => `
                                                                                                                                                        <input type="hidden" name="variants[${index}][attributes][]" value="${attr.attribute}">
                                                                                                                                                        <input type="hidden" name="variants[${index}][attribute_values][]" value="${attr.value}">
                                                                                                                                                    `).join('')}
</div>
`;
                                    variantsDiv.appendChild(variantDiv);
                                });

                            }

                            function previewMainImage_variant(input, index) {
                                const preview = document.getElementById(`main_image_variant_${index}_preview`);
                                const file = input.files[0];

                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                };

                                if (file) {
                                    reader.readAsDataURL(file);
                                }
                            }

                            function previewSubImages_variant(input, index) {
                                const subImagesPreview = document.getElementById(`sub_images_variant_${index}_preview`);
                                subImagesPreview.innerHTML = ''; // Clear current preview
                                if (input.files && input.files.length > 0) {
                                    for (let i = 0; i < input.files.length; i++) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const img = document.createElement('img');
                                            img.src = e.target.result;
                                            img.classList.add('w-20', 'mx-0', 'my-1');
                                            subImagesPreview.appendChild(img);
                                        }
                                        reader.readAsDataURL(input.files[i]);
                                    }
                                }
                            }


                            function slugify(str) {
                                // Bảng thay thế ký tự có dấu sang không dấu
                                const from =
                                    "ÁÀẢÃẠÂẤẦẨẪẬĂẮẰẲẴẶÉÈẺẼẸÊẾỀỂỄỆÍÌỈĨỊÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÚÙỦŨỤƯỨỪỬỮỰÝỲỶỸỴĐáàảãạâấầẩẫậăắằẳẵặéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđ";
                                const to =
                                    "AAAAAAAAAAAAAAAAAEEEEEEEEEEEIIIIIOOOOOOOOOOOOOOOOOUUUUUUUUUUUYYYYYDaaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd";

                                const mapping = {};
                                for (let i = 0; i < from.length; i++) {
                                    mapping[from.charAt(i)] = to.charAt(i);
                                }

                                // Thay thế ký tự có dấu bằng không dấu
                                const slug = str.split('').map(char => mapping[char] || char)
                                    .join('')
                                    .toLowerCase()
                                    .replace(/[^a-z0-9]+/g, '_')
                                    .replace(/^_|_$/g, '');

                                return slug;
                            }

                            // Hàm tạo các kết hợp từ các thuộc tính
                            function getCombinations(attributes) {
                                if (attributes.length === 0) return [];
                                let result = attributes[0].values.map(value => [{
                                    attribute: attributes[0].attribute,
                                    value
                                }]);
                                for (let i = 1; i < attributes.length; i++) {
                                    const currentValues = attributes[i].values;
                                    const newResult = [];
                                    result.forEach(combination => {
                                        currentValues.forEach(value => {
                                            newResult.push([...combination, {
                                                attribute: attributes[i].attribute,
                                                value
                                            }]);
                                        });
                                    });
                                    result = newResult;
                                }
                                return result;
                            }

                            // Hàm tạo SKU từ các kết hợp
                            function generateSKU(combination) {
                                // Tạo SKU bằng cách nối các thuộc tính và giá trị và chuyển thành slug
                                return combination.map(attr => slugify(attr.value)).join('_');
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
