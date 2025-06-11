<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.banners.index', [
            'title' => 'Danh sách banner',
            'banners' =>  Banner::orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.banners.add', [
            'title' => "Thêm banner"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'status' => 'required|in:0,1',
        ], [
            'title.required' => 'Tiêu đề không được để trống.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
            'image.required' => 'Vui lòng chọn một tập tin hình ảnh.',
            'image.image' => 'Tập tin bạn chọn không phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif.',
        ]);



        // Lưu banner mới vào cơ sở dữ liệu
        $banner = new Banner();
        $banner->title = $validatedData['title'];
        $banner->description = $validatedData['description'];
        $banner->status = $validatedData['status'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $banner->image = $imageName; // Lưu đường dẫn của ảnh vào cơ sở dữ liệu
        }

        $banner->save();

        return redirect()->route('banner.index')->with('success', 'Banner đã được thêm mới thành công.');
    }



    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::find($id);
        return view('pages.admin.banners.edit', [
            'title' => "Sửa banner",
            'banner' => $banner,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp', // Thêm validation cho ảnh
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
            'image.image' => 'Tập tin bạn chọn không phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif, webp.',

        ]);

        // Find the banner by its ID
        $banner = Banner::findOrFail($id);
        // Update the title, description, and status
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->status = $request->status;

        // Check if a new image file has been uploaded
        if ($request->hasFile('image')) {
            // Process the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $banner->image = $imageName; // Save the new image file name
        }

        // Save the changes to the database
        $banner->save();

        // Redirect back to the index page with a success message
        return redirect()->route('banner.index')->with('success', 'Banner đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('banner.index')->with('success', 'Xóa thành công.');
    }
    public function toggleBannerStatus(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $newStatus = $request->input('status');
        $banner->status = $newStatus;
        $banner->save();
    
        return response()->json(['status' => $newStatus])->with('success', 'Xóa thành công.');
    }
}
