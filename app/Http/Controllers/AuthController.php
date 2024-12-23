<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Admin;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register_auth(){
        return view('admin.customer_auth.register');
    }

    public function login_auth(){
        return view('admin.customer_auth.register');
    }
    public function validation($request){
        return $request->validate([
            'admin_name'=>'required|max:255',
            'admin_phone'=>'required|max:255',
            'admin_email'=>'required|email|max:255',
            'admin_password'=>'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function auth_register(Request $request){
        $data=$request->all();
        $this->validation($request);
        $admin = new Admin();
        $admin->admin_name=$data['admin_name'];
        $admin->admin_phone=$data['admin_phone'];
        $admin->admin_email=$data['admin_email'];
        $admin->admin_password=Hash::make($data['admin_password']);
        $admin->save();
        return Redirect('/register-auth')->with('message_register','Đăng ký thành công');
    }

    public function login(Request $request){
        $data=$request->all();
        $request->validate([
            'admin_email'=>'required|email|max:255',
            'admin_password'=>'required|max:255',
        ]);
        if(Auth::attempt(['admin_email'=>$request->admin_email, 'admin_password'=>$request->admin_password])){
            return Redirect('/dashboard');
        }else{
            return Redirect('/login-auth')->with('message_login','Đăng nhập thất bại');
        }
        
        // return Redirect('/login-auth')->with('message_login','Đăng nhập thành công');
    }

    public function logout_auth (){
        Auth::logout();
        return Redirect('/login-auth');
    }
}
