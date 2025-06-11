<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.productCategories.index', [
            'title' => 'Danh sách danh mục',
            'productCategories' => ProductCategory::orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.productCategories.add', [
            'title' => 'Thêm mới danh mục',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|max:255|unique:product_categories,category_name',
            'status' => 'required|in:0,1',
        ], [
            'category_name.required' => 'Tiêu đề không được để trống.',
            'category_name.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'category_name.unique' => 'Tên danh mục đã tồn tại.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);
    
        // Lưu productCategories mới vào cơ sở dữ liệu
        $productCategory = new ProductCategory();
        $productCategory->category_name = $validatedData['category_name'];
        $productCategory->status = $validatedData['status'];
        $productCategory->slug = Str::slug($productCategory->category_name);
        $productCategory->save();

        // Sau khi save() thì ID mới tồn tại, nên cập nhật lại slug
        $productCategory->slug = Str::slug($productCategory->category_name) . '-' . $productCategory->id;
        $productCategory->save();
            
        return redirect()->route('productCategories.index')->with('success', 'Danh mục đã được thêm mới thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    { 
        // Logic to display a specific resource can be added here if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productCategory = ProductCategory::find($id);
        return view('pages.admin.productCategories.edit', [
            'title' => 'Sửa danh mục',
            'productCategory' => $productCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        $validatedData = $request->validate([
            'category_name' => 'required|max:255', // No need for unique if the name does not have to be unique when updating
            'status' => 'required|in:0,1',
        ], [
            'category_name.required' => 'Tiêu đề không được để trống.',
            'category_name.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);
    
        // Check if the category name has been changed
        if ($productCategory->category_name !== $validatedData['category_name']) {
            // If the name has been changed, check for uniqueness
            $request->validate([
                'category_name' => 'required|max:255|unique:product_categories,category_name',
            ], [
                'category_name.unique' => 'Tên danh mục đã tồn tại.',
            ]);
        }
    
        // Update the product category information
        $productCategory->category_name = $validatedData['category_name'];
        $productCategory->status = $validatedData['status'];
        $productCategory->save();
    
        return redirect()->route('productCategories.index')->with('success', 'Cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        $productCategory->delete();
        return redirect()->route('productCategories.index')->with('success', 'Xóa thành công.');
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, $id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        $newStatus = $request->input('status');
        $productCategory->status = $newStatus;
        $productCategory->save();
    
        return response()->json(['status' => $newStatus]);
    }
}
