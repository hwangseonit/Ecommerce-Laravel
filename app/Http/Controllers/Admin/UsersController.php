<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $usertype = $request->input('usertype');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($usertype) {
            $query->where('usertype', $usertype);
        }

        $users = $query->paginate(10);

        return view('pages.admin.users.index', [
            'title' => 'Danh sách tài khoản',
            'users' => $users
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.users.add', [
            'title' => 'Thêm tài khoản',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp', // Max 2MB
            'usertype' => 'required|integer|in:1,2',
            'status' => 'required|integer|in:0,1',
        ], [
            'name.required' => 'Vui lòng nhập tên người dùng.',
            'name.max' => 'Tên người dùng không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã tồn tại.',
            'email.max' => 'Địa chỉ email không được vượt quá 255 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu.',
            'password_confirmation.min' => 'Mật khẩu xác nhận phải có ít nhất 8 ký tự.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Chỉ chấp nhận các định dạng ảnh: jpeg, png, jpg, gif,webp.',
            'usertype.required' => 'Vui lòng chọn loại tài khoản.',
        ]);
        // Create new user
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'usertype' => $request->usertype,
            'status' => $request->status,
        ]);

        // Kiểm tra xem người dùng có tải lên hình ảnh hay không
        if ($request->hasFile('image')) {
            // Lưu hình ảnh vào thư mục công cộng và cập nhật đường dẫn trong cơ sở dữ liệu
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $user->image = $imageName; // Lưu đường dẫn của ảnh vào cơ sở dữ liệu
        } else {
            $user->image = ''; // Nếu không có hình ảnh được tải lên, đặt giá trị mặc định
        }
        // Save user
        $user->save();

        // Redirect to user index page with success message
        return redirect()->route('user.index')->with('success', 'Thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('pages.admin.users.detail', [
            'title' => 'Chi tiết tài khoản',
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('pages.admin.users.edit', [
            'title' => "Sửa tài khoản",
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'usertype' => 'required|integer|in:1,2',
            'status' => 'required|integer|in:0,1',
        ], [
            'name.required' => 'Vui lòng nhập tên người dùng.',
            'name.max' => 'Tên người dùng không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được vượt quá 255 ký tự.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Chỉ chấp nhận các định dạng ảnh: jpeg, png, jpg, gif,webp.',
            'usertype.required' => 'Vui lòng chọn loại tài khoản.',
        ]);
        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the email has been changed
        if ($request->email !== $user->email) {
            // If email has been changed, validate uniqueness
            $request->validate([
                'email' => 'unique:users,email', // Validate uniqueness
            ], [
                'email.unique' => 'Địa chỉ email đã tồn tại.',
            ]);
        }

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->usertype = $request->usertype;
        $user->status = $request->status;

        // Check if a new image has been uploaded
        if ($request->hasFile('image')) {
            // Save the uploaded image and update the image path in the database
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $user->image = $imageName;
        }

        // Save the updated user details
        $user->save();

        // Redirect to user index page with success message
        return redirect()->route('user.index')->with('success', 'Cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Xóa thành công.');
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Xóa tài khoản thành công.']);
        }
        return response()->json(['error' => 'Không có tài khoản nào được chọn.'], 400);
    }
}
