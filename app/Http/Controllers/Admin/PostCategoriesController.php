<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PostCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postCategories = PostCategory::all();
        return view('pages.admin.postCategories.index', [
            'title' => 'Danh sách loại bài viết',
            'postCategories' => $postCategories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.postCategories.add', [
            'title' => 'Thêm loại bài viết',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name',
            'slug' => 'required|string|max:255|unique:post_categories,slug',
            'status' => 'required|integer|in:0,1',
        ], [
            'name.required' => 'Vui lòng nhập tên Loại bài viết.',
            'name.unique' => 'Tên Loại bài viết đã tồn tại.',
            'name.max' => 'Tên Loại bài viết không được vượt quá 255 ký tự.',
            'slug.required' => 'Vui lòng nhập Slug.',
            'slug.unique' => 'Slug đã tồn tại.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
     
        ]);

        // Create new post category
        $postCategory = new PostCategory([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ]);

        // Save post category
        $postCategory->save();

        // Redirect to post category index page with success message
        return redirect()->route('postCategory.index')->with('success', 'Thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    { {
            return view('pages.admin.postCategories.detail', [
                'title' => 'Danh sách bài viết'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $postCategory = PostCategory::find($id);
        return view('pages.admin.postCategories.edit', [
            'title' => 'Sửa loại bài viết',
            'postCategory' => $postCategory,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the post category by ID
        $postCategory = PostCategory::findOrFail($id);
    
        // Validate form data
        $rules = [
            'status' => 'required|integer|in:0,1',
            'image' => 'required|image',
        ];
    
        // Kiểm tra nếu người dùng đã thay đổi tên loại bài viết
        if ($request->has('name') && $request->name !== $postCategory->name) {
            $rules['name'] = 'required|string|max:255|unique:post_categories,name';
        }
    
        $request->validate($rules, [
            'name.required' => 'Vui lòng nhập tên Loại bài viết.',
            'name.unique' => 'Tên Loại bài viết đã tồn tại.',
            'name.max' => 'Tên Loại bài viết không được vượt quá 255 ký tự.',
            'image.required' => 'Vui lòng chọn ảnh.',
            'image.image' => 'Ảnh không hợp lệ.',
        ]);
    
        // Create slug from the name
        $slug = $postCategory->slug;
        if ($request->has('name') && $request->name !== $postCategory->name) {
            $slug = Str::slug($request->name, '-');
        }
    
        // Update the post category
        $postCategory->fill([
            'name' => $request->name ?? $postCategory->name,
            'slug' => $slug,
            'status' => $request->status,
        ])->save();
    
        // Redirect to post category index page with success message
        return redirect()->route('postCategory.index')->with('success', 'Sửa thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postCategory = PostCategory::findOrFail($id);
        $postCategory->delete();
        return redirect()->route('postCategory.index')->with('success', 'Xóa thành công.');
    }
}
