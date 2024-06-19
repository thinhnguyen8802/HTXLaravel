<?php

namespace App\Http\Controllers\BEController;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function viewRegister(){
        return view('backend.page.register');
    }
    public function register(Request $request){
        // Kiểm tra xác thực
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'username.unique' => 'Tên đăng nhập đã được sử dụng.',
            'email.required' => 'Địa chỉ email là bắt buộc.',
            'email.unique' => 'Địa chỉ email đã được đăng ký.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không chính xác!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = new User();
        $data = $request->all();
        $user->username = $data['username'];
        $user->role_id = 1;
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->phone = "";
        $user->name = $data['username'];
        $save = $user->save();
        if($save){
            Auth::login($user);
            $request->session()->flash('success', 'Đăng ký tài khoản thành công thành công');
            return redirect()->route('home');
        }
        else{
            $request->session()->flash('faild', 'Đăng ký tài khoản thành công thất bại');
        }

    }

    public function viewLogin(){
        return view('backend.page.login');
    }

    public function login(Request $request)
    {
        $key = $request->attributes->get('key');
        $loginField =$request->input('login');
        $password = $request->input('password');
        // Xác định xem người dùng nhập username hoặc email
        $loginType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginType => $loginField,
            'password' => $password,
        ];
        if (Auth::attempt($credentials)) {
            Cache::forget($key);
            // Kiểm tra vai trò của người dùng sau khi đăng nhập
            if (Auth::user()->role_id == -1) { // admin
                return redirect()->intended(route('admin.dashboard')); // Điều hướng đến trang quản trị
            }
            else if (Auth::user()->role_id == 0){ //manager
                return redirect()->intended('/manager');
            }
            else{
                return redirect()->intended(route('home'));
            }
            // Nếu không có vai trò admin, đăng xuất và hiển thị thông báo lỗi
            Auth::logout();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Bạn không có quyền truy cập vào trang quản trị.',
            ]);
        }

        // Nếu xác thực không thành công, thực hiện hành động tùy chỉnh ở đây
        return redirect()->back()->withInput()->withErrors([
            'message' => 'Thông tin xác thực không chính xác',
        ]);
    }
    public function logout(Request $request) {
        // $roleId = Auth::user()->role_id;
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->intended(route('login'));

      }
}
