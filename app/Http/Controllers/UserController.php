<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $admin = Admin::with('roles')->orderBy('admin_id', 'desc')->paginate(10);
        return view('admin.users.all_users')->with(compact('admin')); 
    }

    public function add_user()
    {
        return view('admin.users.add_user');
    }

    public function assign_roles(Request $request)
    {
        $data = $request->all();
        $user = Admin::where('admin_email', $data['admin_email'])->first();
        $user->roles()->detach();
        if($request['author_role']){
            $user->roles()->attach(Roles::where('name', 'author')->first());
        }
        if($request['user_role']){
            $user->roles()->attach(Roles::where('name', 'user')->first());
        }
        if($request['admin_role']){
            $user->roles()->attach(Roles::where('name', 'admin')->first());
        }
        return redirect()->back();
    }

    public function store_user(Request $request)
    {
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = Hash::make($data['admin_password']);
        $admin->save();
        $admin->roles()->attach(Roles::where('name', 'user')->first());
        Session::put('message', 'Thêm người dùng thành công');
        return Redirect::to('users');
    }
    
//Customer
    public function edit_user_info()
    {
        $customer_id = Session::get('customer_id');
        $customer_info = DB::table('tbl_customers')
            ->where('customer_id', $customer_id)
            ->first();

        return view('pages.tab.user.info_user', compact('customer_info'));
    }
    public function edit_user_password()
    {
        return view('pages.tab.user.change_password');
    }

    public function update_user_password(Request $request)
    {
        if($request->new_password != $request->confirm_password) {
            Session::put('message', 'Mật khẩu xác nhận không khớp');
            return redirect()->back();
        }
        $customer_id = Session::get('customer_id');
        $customer_info = DB::table('tbl_customers')
            ->where('customer_id', $customer_id)
            ->first();

        if (md5($request->current_password) != $customer_info->customer_password) {
            return redirect()->back()->with('message', 'Mật khẩu hiện tại không đúng');
        } else {
            DB::table('tbl_customers')
                ->where('customer_id', $customer_id)
                ->update([
                    'customer_password' => md5($request->new_password)
                ]);

            return redirect()->back()->with('message', 'Đổi mật khẩu thành công');
        }
        
    }

    public function update_user_info(Request $request)
    {
        $customer_id = Session::get('customer_id');
    
        // Update database
        DB::table('tbl_customers')
            ->where('customer_id', $customer_id)
            ->update([
                'customer_email' => $request->customer_email,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone
            ]);
    
        // Refresh session
        Session::put([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone
        ]);
    
        return redirect()->back()->with('message', 'Cập nhật thành công');
    }
    // load customer info từ csdl
}
