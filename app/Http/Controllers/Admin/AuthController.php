<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        // Kiểm tra đã lưu đăng nhập chưa thì chuyển đến Dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function postLogin(Request $request)
    {
        // validate - kiểm tra dữ liệu đầu vào
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );

        // first(): lấy ra record đầu tiên khi truy vấn dữ liệu
        $user = User::where('username', $request->username)->first();

        // Nếu không tìm thấy người dùng trong bảng users
        if (!$user) {
            return back()
                ->with('message', 'Username không tồn tại')
                ->withInput();
        }

        // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        // do mật khẩu dùng Hash::make() để mã hóa, nên cần so sánh phải dùng với hàm Hash::check()
        $check = Hash::check($request->password, $user->password); // true hoặc false

        // trường hợp mật khẩu không khớp
        if (!$check) {
            // điều hướng về trước (login) với session flash 'message'
            return back()->with('message', 'Mật khẩu không đúng')->withInput();
        }

        // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);

        // sử dụng intended để điều hướng về URL mà người dùng muốn truy cập
        // nếu không có thì điều hướng về dashboard
        return redirect()->intended(route('admin.dashboard'));
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        // Đăng xuất user
        Auth::logout();

        // Xóa session hiện tại
        $request->session()->invalidate();

        // Tạo lại CSRF token mới
        $request->session()->regenerateToken();

        // Redirect về trang login
        return redirect()->route('admin.login');
    }

    // Hiển thị trang Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.auth.forgotpassword');
    }

    // Xử lý quên mật khẩu
    public function postForgotPassword(Request $request)
    {
        // TODO: Xử lý gửi email đặt lại mật khẩu
        return back()->with('success', 'Nếu email tồn tại, chúng tôi đã gửi hướng dẫn đặt lại mật khẩu.');
    }

    // Hiển thị trang Đổi mật khẩu
    public function changePassword()
    {
        return view('admin.auth.changepassword');
    }

    // Xử lý đổi mật khẩu
    public function postChangePassword(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate(
            [
                'current_password'      => 'required',
                'new_password'          => 'required|min:6|confirmed',
                'new_password_confirmation' => 'required',
            ],
            [
                'required'  => ':attribute không được để trống',
                'min'       => ':attribute phải có ít nhất :min ký tự',
                'confirmed' => ':attribute xác nhận không khớp',
            ],
            [
                'current_password'      => 'Mật khẩu hiện tại',
                'new_password'          => 'Mật khẩu mới',
                'new_password_confirmation' => 'Xác nhận mật khẩu mới',
            ]
        );

        $user = Auth::user();

        // Kiểm tra mật khẩu cũ có chính xác hay không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->with('error', 'Mật khẩu hiện tại không chính xác')
                ->withInput();
        }

        // Mã hóa mật khẩu mới và cập nhật vào database
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
