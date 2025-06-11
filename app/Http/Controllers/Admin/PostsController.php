<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{


    public function index(Request $request)
    {
        $search = $request->input('search');
        $postCategoryId = $request->input('post_category_id'); // Đổi tên biến để phù hợp với cột trong bảng

        $query = Posts::with('author', 'category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($postCategoryId) {
            $query->where('post_category_id', $postCategoryId); // Sử dụng đúng tên cột
        }

        $posts = $query->paginate(10);
        $categories = PostCategory::all(); // Đổi tên model

        return view('pages.admin.posts.index', [
            'title' => 'Danh sách bài viết',
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = User::where('usertype', 1)->pluck('name', 'id');
        $categories = PostCategory::where('status', 1)->pluck('name', 'id');
        return view('pages.admin.posts.add', [
            'title' => "Thêm bài viết",
            'authors' => $authors,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'slug' => 'nullable|max:255|unique:posts,slug',
            'user_id' => 'required|exists:users,id',
            'post_category_id' => 'required|exists:post_categories,id',
            'content' => 'required',
            'description' => 'required',
            'image' => 'required|image',
            'status' => 'required|in:0,1',
        ], [
            'title.required' => 'Tiêu đề không được để trống.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'user_id.required' => 'Vui lòng chọn một tác giả.',
            'post_category_id.required' => 'Vui lòng chọn một danh mục bài viết.',
            'content.required' => 'Nội dung không được để trống.',
            'description.required' => 'Mô tả ngắn không được để trống.',
            'image.required' => 'Vui lòng chọn một tập tin hình ảnh.',
            'image.image' => 'Tập tin bạn chọn không phải là hình ảnh.',
            'status.required' => 'Vui lòng chọn trạng thái của bài viết.',
            'status.in' => 'Trạng thái bài viết không hợp lệ.',
        ]);

        // Handle image upload
        $imagePath = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath =  $imageName;
        }
        // Create slug from the title if slug is not provided
        // Create new post
        $post = new Posts([
            'title' => $request->title,
            'slug' => $request->slug,
            'user_id' => $request->user_id,
            'post_category_id' => $request->post_category_id,
            'content' => $request->content,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        // Save post
        $post->save();

        // Redirect to post index page with success message
        return redirect()->route('post.index')->with('success', 'Bài viết đã được thêm mới thành công.');
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Posts::with('author', 'category')->find($id);
        return view('pages.admin.posts.detail', [
            'title' => 'Chi tiết bài viết',
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Posts::findOrFail($id); // Tìm bài viết cần chỉnh sửa
        $authors = User::where('usertype', 1)->pluck('name', 'id');
        $categories = PostCategory::where('status', 1)->pluck('name', 'id');

        return view('pages.admin.posts.edit', [
            'title' => 'Chỉnh sửa bài viết', // Đổi tiêu đề thành "Chỉnh sửa bài viết"
            'post' => $post,
            'authors' => $authors,
            'categories' => $categories
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|max:255',
            'user_id' => 'required|exists:users,id',
            'post_category_id' => 'required|exists:post_categories,id',
            'content' => 'required',
            // 'description' => 'required',
            'image' => 'nullable|image',
            'status' => 'required|in:0,1',
        ], [
            'title.required' => 'Tiêu đề không được để trống.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'user_id.required' => 'Vui lòng chọn một tác giả.',
            'user_id.exists' => 'Tác giả không hợp lệ.',
            'post_category_id.required' => 'Vui lòng chọn một danh mục bài viết.',
            'post_category_id.exists' => 'Danh mục bài viết không hợp lệ.',
            'content.required' => 'Nội dung không được để trống.',
            // 'description.required' => 'mô tả ngắn không được để trống.',
            'image.image' => 'Tập tin bạn chọn không phải là hình ảnh.',
            'status.required' => 'Vui lòng chọn trạng thái của bài viết.',
            'status.in' => 'Trạng thái bài viết không hợp lệ.',
        ]);

        $post = Posts::findOrFail($id);

        // Kiểm tra xem người dùng đã tải lên ảnh mới hay không
        if ($request->hasFile('image')) {
            // Nếu có ảnh mới được tải lên, thực hiện xử lý như bình thường
            // Lưu ý: Bạn cần kiểm tra và xóa ảnh cũ tại đây nếu muốn thay thế ảnh cũ bằng ảnh mới
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $post->image = $imageName;
        }
        $post->title = $request->title;
        $post->user_id = $request->user_id;
        $post->post_category_id = $request->post_category_id;
        $post->content = $request->content;
        // $post->description = $request->description;
        $post->status = $request->status;
        $post->save();
        // Redirect back to the index page with a success message
        return redirect()->route('post.index')->with('success', 'Bài viết đã được cập nhật thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Posts::findOrFail($id);
        $post->delete();
        return redirect()->route('post.index')->with('success', 'Xóa thành công.');
    }
    public function togglepostStatus(Request $request, $id)
    {
        $post = Posts::findOrFail($id);
        $newStatus = $request->input('status');
        $post->status = $newStatus;
        $post->save();

        return response()->json(['status' => $newStatus]);
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        Posts::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}
