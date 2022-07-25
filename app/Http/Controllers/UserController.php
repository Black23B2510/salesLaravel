<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    //Sign up as a user
    public function getSignUp(){
        //trả về view là trang đăng ký
        return view('pages.signup');
    }

    public function postSignUp(Request $req){
        //Kiểm tra và thông báo lỗi nếu dữ liệu nhập vào không đúng yêu cầu
        $this->validate($req,
        ['email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:20|string',
            'fullname'=>'required',
            'address'=>'required',
            'phone'=>'required|min:10',
            'repassword'=>'required|same:password'
        ],[
            'address.required'=>'Vui lòng nhập địa chỉ',
            'phone.min'=>'Vui lòng nhập đúng số điện thoại',
            'email.email'=>'Vui lòng nhập đúng email',
            'email.unique'=>'Email đã có người sử dụng',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'repassword.same'=>'Mật khẩu không trùng khớp',
            'password.min'=>'Mật khẩu có ít nhất 6 kí tự'
        ]);
        //Tạo mới một biến user có đầy đủ các thuộc tính để lưu vào bảng users trong DB
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);//Mã hóa mật khẩu
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->level = 3; //level=2:Technican, level=1:Admin, level=3:User
        $user->save();
        echo '<script>alert("Tạo tài khoản thành công");window.location.assign("/getLogin");</script>';
        // return redirect()->route('dangnhap')->with('success','Tạo tài khoản thành công');//Trả về trang hiện tại là trang đăng ký sau khi đăng ký thành công
    }

    public function Login(){
        return view('pages.login');
    }
    
    public function postLogin(Request $req){
        $this->validate($req,[
            'email'=>'required|email',
            'password'=>'required|max:20|min:6|string'
        ],[
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Vui lòng nhập đúng email',
            'password.required'=>'Vui lòng nhập đúng mật khẩu'
        ]);
        $login = [
            'email' => $req->input('email'),
            'password' => $req->input('password')
        ];
        if(Auth::attempt($login)){//The attempt method will return true if authentication was successful. Otherwise, false will be returned.
            $user = Auth::user();
            Session::put('user', $user);
            echo '<script>alert("Đăng nhập thành công.");window.location.assign("/");</script>';
        }
        else{
            echo '<script>alert("Đăng nhập thất bại.");window.location.assign("/login");</script>';
        }
    }

    public function logout(){
        Session::forget('user');
        Session::forget('cart');
        return redirect('/');
    }
    
}