<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\ProductCategory;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $has_variants = $request->input('has_variants');

        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
                // ->orWhere('full_name', 'like', '%' . $search . '%');
        }

        if ($has_variants !== null) {
            $query->where('has_variants', $has_variants);
        }

        $products = $query->with(['category', 'variants'])->orderBy('id', 'desc')->paginate(5);
        $title = 'Danh sách sản phẩm';

        foreach ($products as $product) {
            if ($product->has_variants) {
                $prices = $product->variants->pluck('price')->toArray();
                if (count($prices) == 1) {
                    $product->price_range = number_format($prices[0], 0, ',', '.') . '₫';
                } elseif (count($prices) > 1) {
                    $product->price_range = number_format(min($prices), 0, ',', '.') . ' - ' . number_format(max($prices), 0, ',', '.');
                }
                $product->total_stock = $product->variants->sum('stock');
            } else {
                $product->price_range = number_format($product->base_price, 0, ',', '.') . '₫';
                $product->total_stock = $product->store_quantity;
            }
        }
        // Lấy các giá trị duy nhất của has_variants
        $uniqueHasVariants = Product::select('has_variants')->distinct()->pluck('has_variants');
        return view('pages.admin.products.index', compact('products', 'title', 'uniqueHasVariants'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributes = Attribute::all();
        $productCategories = ProductCategory::all();
        $title = 'Thêm Sản Phẩm Mới';

        return view('pages.admin.products.add', compact('attributes', 'productCategories', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         // Validate form data
         $validated = $request->validate([
             'product_name' => 'required|string|max:255',
             'product_description' => 'nullable|string',
             'product_short_description' => 'nullable|string',
             'product_specification' => 'nullable|string',
             'product_type' => 'required|in:0,1',
             'product_base_price' => 'required_if:product_type,0|nullable|numeric',
             'store_quantity' => 'required_if:product_type,0|nullable|integer',
             'category_id' => 'required|exists:product_categories,id',
             'main_image_url' => 'required|image',
             'sub_images_urls.*' => 'image',
         ], [
             'product_name.required' => 'Vui lòng nhập tên sản phẩm.',
             'product_name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
             'product_type.required' => 'Vui lòng chọn loại sản phẩm.',
             'product_type.in' => 'Loại sản phẩm không hợp lệ.',
             'product_base_price.required_if' => 'Giá cơ bản là bắt buộc khi sản phẩm không có biến thể.',
             'product_base_price.numeric' => 'Giá cơ bản phải là một số.',
             'store_quantity.required_if' => 'Số lượng kho là bắt buộc khi sản phẩm không có biến thể.',
             'store_quantity.integer' => 'Số lượng kho phải là một số nguyên.',
             'category_id.required' => 'Vui lòng chọn loại sản phẩm.',
             'category_id.exists' => 'Loại sản phẩm không tồn tại.',
             'main_image_url.required' => 'Vui lòng tải lên ảnh chính.',
             'main_image_url.image' => 'Vui lòng tải lên một tệp hình ảnh hợp lệ.',
             'sub_images_urls.*.image' => 'Vui lòng tải lên các tệp hình ảnh hợp lệ.',
         ]);
     
         // Xử lý tải ảnh chính
         $mainImage = $request->file('main_image_url');
         $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
         $mainImage->move(public_path('images'), $mainImageName);
     
         // Xử lý tải nhiều ảnh thumbnail
         $subImageUrls = [];
         if ($request->hasFile('sub_images_urls')) {
             foreach ($request->file('sub_images_urls') as $subImage) {
                 $subImageName = time() . '_' . $subImage->getClientOriginalName();
                 $subImage->move(public_path('images'), $subImageName);
                 $subImageUrls[] =  $subImageName;
             }
         }
     
         // Tạo sản phẩm mới và lưu vào cơ sở dữ liệu
         $product = Product::create([
             'name' => $validated['product_name'],
             'short_description' => $validated['product_short_description'],
             'long_description' => $validated['product_description'],
             'specifications' => $validated['product_specification'],
             'is_hot' => $request->input('hot', 0),
             'is_most_viewed' => 0,
             'status' => $request->input('status', 1),
             'has_variants' => $validated['product_type'] == 1,
             'base_price' => $validated['product_base_price'] ?? null,
             'image_url' =>  $mainImageName,
             'sub_images_urls' => json_encode($subImageUrls), // Lưu dưới dạng JSON
             'store_quantity' => $validated['store_quantity'] ?? 0,
             'category_id' => $validated['category_id'],
         ]);
     
         // Lưu thuộc tính sản phẩm vào bảng product_attributes
         if ($request->has('attributes')) {
             foreach ($request->input('attributes') as $key => $attributeId) {
                 ProductAttribute::create([
                     'product_id' => $product->id,
                     'attribute_id' => $attributeId,
                     'attribute_values' => $request->input('attribute_values')[$key],
                 ]);
             }
         }
     
         // Xử lý biến thể sản phẩm
         if ($product->has_variants) {
             foreach ($request->input('variants', []) as $index => $variant) {
                 $imagePath = 'images/no_images.jpg'; // Sử dụng ảnh mặc định
     
                 if ($request->hasFile("variants.{$index}.main_image")) {
                     $mainImage = $request->file("variants.{$index}.main_image");
                     $imageName = time() . '_' . $mainImage->getClientOriginalName();
                     $mainImage->move(public_path('images'), $imageName);
                     $imagePath = $imageName;
                 }
     
                 // Kiểm tra và xác thực giá trị price là số hợp lệ
                 if (!is_numeric($variant['price'])) {
                     return redirect()->back()->withErrors(['price' => 'Giá của biến thể không hợp lệ.']);
                 }
     
                 $productVariant = ProductVariant::create([
                     'product_id' => $product->id,
                     'variant_name' => $variant['sku'],
                     'price' => $variant['price'],
                     'image_url' => $imagePath,
                     'stock' => $variant['stock'] ?? 0,
                 ]);
     
                 foreach ($variant['attributes'] as $key => $attributeId) {
                     $attribute = Attribute::find($attributeId);
                     if ($attribute) {
                         VariantAttribute::create([
                             'variant_id' => $productVariant->id,
                             'attribute_id' => (int)$attributeId,
                             'attribute_value' => $variant['attribute_values'][$key],
                         ]);
                     }
                 }
             }
         }
     
         return redirect()->route('products.index')->with('success', 'Sản phẩm được thêm thành công');
     }
     

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['variants.attributes.attribute', 'category'])->findOrFail($id);
        $subImagePaths = json_decode($product->sub_images_urls, true);

        // Tính tổng số lượng và xác định giá cho từng sản phẩm
        if ($product->has_variants && $product->variants->count() > 0) {
            $prices = $product->variants->pluck('price')->unique();

            if ($prices->count() == 1) {
                $product->price_range = number_format($prices->first(), 0, ',', '.') . '₫';
            } else {
                $totalStock = $product->variants->sum('stock');
                $minPrice = $product->variants->min('price');
                $maxPrice = $product->variants->max('price');
                $product->total_stock = $totalStock;
                $product->price_range = number_format($minPrice, 0, ',', '.') . ' - ' . number_format($maxPrice, 0, ',', '.') . '₫';
            }
        } else {
            $product->total_stock = $product->store_quantity;
            $product->price_range = number_format($product->base_price, 0, ',', '.') . '₫';
        }

        return view('pages.admin.products.detail', [
            'title' => 'Chi tiết sản phẩm',
            'product' => $product,
            'variations' => $product->variants,
            'subImagePaths' => $subImagePaths,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::with(['attributes.attribute', 'attributes.variantAttributes', 'variants.attributes'])->findOrFail($id);
        $attributes = Attribute::all();
        $productCategories = ProductCategory::all();
        $title = 'Chỉnh sửa sản phẩm';

        return view('pages.admin.products.edit', compact('product', 'attributes', 'productCategories', 'title'));
    }




    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_short_description' => 'nullable|string',
            'product_specification' => 'nullable|string',
            'product_type' => 'required|in:0,1',
            'product_base_price' => 'required_if:product_type,0|nullable|numeric',
            'store_quantity' => 'required_if:product_type,0|nullable|integer',
            'category_id' => 'required|exists:product_categories,id',
            'main_image_url' => 'nullable|image',
            'sub_images_urls.*' => 'image',
        ]);

        $product = Product::findOrFail($id);

        $updateData = [
            'name' => $validated['product_name'],
            'short_description' => $validated['product_short_description'],
            'long_description' => $validated['product_description'],
            'specifications' => $validated['product_specification'],
            'is_hot' => $request->input('hot', 0),
            'status' => $request->input('status', 1),
            'base_price' => $validated['product_base_price'],
            'store_quantity' => $validated['store_quantity'],
            'category_id' => $validated['category_id'],
        ];

        if ($request->hasFile('main_image_url')) {
            $mainImage = $request->file('main_image_url');
            $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
            $mainImage->move(public_path('images'), $mainImageName);
            $updateData['image_url'] = $mainImageName;
        }

        if ($request->hasFile('sub_images_urls')) {
            $subImageUrls = [];
            foreach ($request->file('sub_images_urls') as $subImage) {
                $subImageName = time() . '_' . $subImage->getClientOriginalName();
                $subImage->move(public_path('images'), $subImageName);
                $subImageUrls[] = $subImageName;
            }
            $updateData['sub_images_urls'] = json_encode($subImageUrls);
        }

        $product->update($updateData);

        // Lưu thuộc tính sản phẩm vào bảng product_attributes
        if ($request->has('attributes')) {
            $product->attributes()->delete(); // Xóa thuộc tính cũ trước khi cập nhật mới

            foreach ($request->input('attributes') as $key => $attributeId) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attributeId,
                    'attribute_values' => $request->input('attribute_values')[$key],
                ]);
            }
        }

        // Xử lý biến thể sản phẩm
        if ($product->has_variants) {
            $product->variants()->delete(); // Xóa biến thể cũ trước khi cập nhật mới

            foreach ($request->input('variants', []) as $index => $variant) {
                $imagePath = 'images/no_images.jpg'; // Sử dụng ảnh mặc định

                if ($request->hasFile("variants.{$index}.main_image")) {
                    $mainImage = $request->file("variants.{$index}.main_image");
                    $imageName = time() . '_' . $mainImage->getClientOriginalName();
                    $mainImage->move(public_path('images'), $imageName);
                    $imagePath = $imageName;
                }
                // Kiểm tra và xác thực giá trị price là số hợp lệ
                if (!is_numeric($variant['price'])) {
                    return redirect()->back()->withErrors(['price' => 'Giá của biến thể không hợp lệ.']);
                }
                $productVariant = ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $variant['sku'],
                    'price' => $variant['price'],
                    'image_url' => $imagePath,
                    'stock' => $variant['stock'] ?? 0,
                ]);

                foreach ($variant['attributes'] as $key => $attributeId) {
                    $attribute = Attribute::find($attributeId);
                    if ($attribute) {
                        VariantAttribute::create([
                            'variant_id' => $productVariant->id,
                            'attribute_id' => (int)$attributeId,
                            'attribute_value' => $variant['attribute_values'][$key],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm được cập nhật thành công');
    }

    // public function destroy(string $id)
    // {
    //     $product = Product::findOrFail($id);
    //     $product->delete();
    //     return redirect()->route('products.index')->with('success', 'Xóa thành công.');
    // }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        Product::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}
