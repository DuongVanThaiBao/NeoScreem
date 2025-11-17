<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Hiển thị trang thành viên NeoScreem.
     */
    public function showMembership()
    {
        // Bạn sẽ cần tạo một view mới tên là 'profile.membership'
        return view('user.membership', ['user' => Auth::user()]);
    }

    /**
     * Hiển thị trang lịch sử mua hàng.
     */
    public function showHistory()
    {
        // Bạn sẽ cần tạo một view mới tên là 'profile.history'
        return view('user.history', ['user' => Auth::user()]);
    }


    /**
     * Cập nhật thông tin cá nhân (Họ tên, Email).
     */
    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        // 1. Validate dữ liệu
        $request->validate([
            'fullName' => 'required|string|max:255',
            // Rule 'unique' sẽ bỏ qua email của chính user này
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ], [
            'fullName.required' => 'Họ và tên không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
        ]);

        // 2. Cập nhật và lưu
        $user->name = $request->fullName;
        $user->email = $request->email;
        $user->save();

        // 3. Trả về với thông báo thành công
        return back()->with('status', 'Cập nhật thông tin thành công!');
    }

    /**
     * Cập nhật mật khẩu.
     */
    public function updatePassword(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|string|min:6',
            'confirmPassword' => 'required|same:newPassword',
        ], [
            'oldPassword.required' => 'Bạn chưa nhập mật khẩu cũ.',
            'newPassword.required' => 'Bạn chưa nhập mật khẩu mới.',
            'newPassword.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'confirmPassword.same' => 'Mật khẩu xác thực không khớp.',
        ]);

        $user = Auth::user();

        // 2. Kiểm tra mật khẩu cũ có đúng không
        if (!Hash::check($request->oldPassword, $user->password)) {
            // Trả về với thông báo lỗi
            return back()->withErrors(['oldPassword' => 'Mật khẩu cũ không chính xác.']);
        }

        // 3. Cập nhật mật khẩu mới
        $user->password = Hash::make($request->newPassword);
        $user->save();

        // 4. Trả về với thông báo thành công
        return back()->with('status', 'Đổi mật khẩu thành công!');
    }

    public function updateAvatar(Request $request)
    {
        // 1. Validate file
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Bắt buộc, là ảnh, max 2MB
        ]);

        $user = $request->user();

        // 2. Xóa avatar cũ nếu có
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // 3. Lưu file mới vào 'storage/app/public/avatars'
        // File sẽ có tên ngẫu nhiên, ví dụ: 'avatars/random_string.jpg'
        $path = $request->file('avatar')->store('avatars', 'public');

        // 4. Cập nhật đường dẫn vào CSDL
        $user->update(['avatar' => $path]);

        // 5. Quay lại với thông báo
        return redirect()->route('profile')->with('status', 'Cập nhật ảnh đại diện thành công!');
    }
}
