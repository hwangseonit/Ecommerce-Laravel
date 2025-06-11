<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.attributes.index', [
            'title' => 'Danh sách thuộc tính',
            'attributes' =>  Attribute::orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.attributes.add', [
            'title' => 'Thêm thuộc tính',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'attribute_name' => 'required|max:255|unique:attributes,attribute_name',
        ], [
            'attribute_name.required' => 'Tên thuộc tính không được để trống.',
            'attribute_name.max' => 'Tên thuộc tính không được vượt quá 255 ký tự.',
            'attribute_name.unique' => 'Tên thuộc tính đã tồn tại.',
           
        ]);
    
        // Save new attribute to the database
        $attribute = new Attribute();
        $attribute->attribute_name = $validatedData['attribute_name'];
        $attribute->save();
        return redirect()->route('attributes.index')->with('success', 'Thêm mới thành công.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attribute = Attribute::find($id);
        return view('pages.admin.attributes.edit', [
            'title' => "Sửa thuộc tính",
            'attribute' => $attribute,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'attribute_name' => 'required|max:255', // Loại bỏ unique nếu tên không cần phải duy nhất khi cập nhật
        ], [
            'attribute_name.required' => 'Tên thuộc tính không được để trống.',
            'attribute_name.max' => 'Tên thuộc tính không được vượt quá 255 ký tự.',
        ]);
    
        // Lưu attributes mới vào cơ sở dữ liệu
        $attribute = Attribute::findOrFail($id);
    
        // Kiểm tra xem tên đã được sửa hay không
        if ($attribute->attribute_name !== $validatedData['attribute_name']) {
            // Nếu tên đã được sửa, kiểm tra tính duy nhất
            $request->validate([
                'attribute_name' => 'required|max:255|unique:attributes,attribute_name',
            ], [
                'attribute_name.unique' => 'Tên danh mục đã tồn tại.',
            ]);
        }
    
        // Cập nhật thông tin của danh mục sản phẩm
        $attribute->attribute_name = $validatedData['attribute_name'];
    
        $attribute->save();
    
        return redirect()->route('attributes.index')->with('success', 'Cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return redirect()->route('attributes.index')->with('success', 'Xóa thành công.');
    }
    public function updateStatus(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        $newStatus = $request->input('status');
        $attribute->status = $newStatus;
        $attribute->save();
    
        return response()->json(['status' => $newStatus]);
    }
}
