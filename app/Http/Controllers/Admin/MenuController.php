<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menus;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getParent()
    {
        return Menus::where('parent_id', 0)->get();
    }
    public function index()
    {
        return view('pages.admin.menus.index', [
            'title' => "Danh sách menus",
            'menus' =>  Menus::orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.menus.add', [
            'title' => "Thêm menu",
            'parentMenus' => $this->getParent()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:menus,slug',
            'status' => 'required',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là một chuỗi.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là một chuỗi.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ]);


        $menu = new Menus();
        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->slug = $request->slug;
        $menu->status = $request->status;
        $menu->save();
        // Redirect back with success message
        return redirect()->route('menu.index')->with('success', 'Menu đã được thêm thành công.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menus::find($id);
        return view('pages.admin.menus.edit', [
            'title' => "Sửa menu",
            'parentMenus' => $this->getParent(),
            'menu' => $menu,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'slug' => 'required|string|max:255|unique:menus,slug,' . $id,
            'status' => 'required',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là một chuỗi.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là một chuỗi.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ]);


        // Find the menu by its ID
        $menu = Menus::findOrFail($id);
        // Update the menu with the validated data
        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->slug = $request->slug;
        $menu->status = $request->status;
        $menu->save();

        // Redirect back to the index page with a success message
        return redirect()->route('menu.index')->with('success', 'Menu đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menus::findOrFail($id);
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Xóa thành công.');
    }
}
