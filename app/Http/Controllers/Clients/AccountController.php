<?php
// app/Http/Controllers/Clients/AccountController.php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        $title = 'Tài khoản - KhanhUD Moblie';
        $user = Auth::user();
        return view('pages.client.account.index', compact('user', 'title'));
    }


    public function update(Request $request, $id)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ], [
            'name.required' => 'Vui lòng nhập tên người dùng.',
            'name.max' => 'Tên người dùng không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Chỉ chấp nhận các định dạng ảnh: jpeg, png, jpg, gif,webp.',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        if($user->email != $request->email) {
            return redirect()->route('account.index')->with('error', 'Không được phép thay đổi email vui lòng liên hệ admin.');
        }

        // Check if the email has been changed
        if ($request->email !== $user->email) {
            // If email has been changed, validate uniqueness
            $request->validate([
                'email' => 'unique:users,email',
            ], [
                'email.unique' => 'Địa chỉ email đã tồn tại.',
            ]);
        }

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

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
        return redirect()->route('account.index')->with('success', 'Cập nhật thành công.');
    }

    public function showChangePasswordForm()
    {
        $title = 'Đổi mật khẩu | KhanhUD Mobile';
        return view('pages.client.account.change_password', compact('title'));
    }

    public function changePassword(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);
    
        // Kiểm tra mật khẩu hiện tại
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }
    
        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return redirect()->route('account.index')->with('success', 'Đổi mật khẩu thành công.');
    }
}
