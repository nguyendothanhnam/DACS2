<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function insert_coupon(Request $request){
        $this -> AuthLogin();
        // if ($request->isMethod('post')) {
        //     $validatedData = $request->validate([
        //         'coupon_name' => 'required|string|max:255',
        //         'coupon_code' => 'required|string|min:10',
        //         'coupon_times' => 'required|string|min:10',
        //         'coupon_condition' => 'required|string|min:10',
        //         'coupon_number' => 'required|string|min:5',
        //     ], [
        //         'coupon_name.required' => 'Tên mã giảm giá không được để trống.',
        //         'coupon_code.required' => 'Mã giảm giá không được để trống.',
        //         'coupon_times.required' => 'Số lượng mã giảm giá không được để trống.',
        //         'coupon_condition.required' => 'Tính năng mã giảm giá không được để trống.',
        //         'coupon_number.required' => '% mã giảm giá không được để trống.',
        //     ]);
        // }
        
        return view('admin.coupon.insert_coupon');
        // $data = array();
        // $data['coupon_name'] = $request->coupon_name;
        // $data['coupon_time'] = $request->coupon_time;
        // $data['coupon_code'] = $request->coupon_code;
        // $data['coupon_number'] = $request->coupon_number;
        // $data['coupon_condition'] = $request->coupon_condition;

        // DB::table('tbl_coupon')->insert($data);
        // Session::put('message','Thêm mã giảm giá thành công');
        // return Redirect::to('all-coupon');
    }
    
    public function insert_coupon_code(Request $request){
        $this -> AuthLogin();

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'coupon_name' => 'required|string|max:255',
                'coupon_code' => 'required|string|min:5',
                'coupon_times' => 'required|string|min:1', 
                'coupon_number' => 'required|string|min:1',
            ], [
                'coupon_name.required' => 'Tên mã giảm giá không được để trống.',
                'coupon_code.required' => 'Mã giảm giá không được để trống.',
                'coupon_times.required' => 'Số lượng mã giảm giá không được để trống.',
                'coupon_number.required' => '% hoặc số tiền giảm mã giảm giá không được để trống.',
            ]);
        }

        $data = $request->all();
        $coupon = new Coupon();
        $coupon->coupon_name = $validatedData['coupon_name'];
        $coupon->coupon_time = $validatedData['coupon_times'];
        $coupon->coupon_code = $validatedData['coupon_code'];
        $coupon->coupon_number = $validatedData['coupon_number'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->save();

        Session::put('message','Thêm mã giảm giá thành công');
        return Redirect::to('insert-coupon');
    }

    public function list_coupon(){
        $this -> AuthLogin();
        $coupon = Coupon::orderBy('coupon_id', 'asc')->paginate(10);
        return view('admin.coupon.list_coupon', compact('coupon'));
    }

    public function delete_coupon($coupon_id){
        $this -> AuthLogin();
        Coupon::find($coupon_id)->delete();
        Session::put('message','Xóa mã giảm giá thành công');
        return Redirect::to('list-coupon');
    }

    public function unset_coupon(){
        $this -> AuthLogin();
        $coupon = Session::get('coupon');
        if($coupon==true){
            Session::forget('coupon');
            return Redirect()->back()->with('message','Xóa mã giảm giá thành công');
        }else{
            return Redirect()->back()->with('message','Xóa mã giảm giá thất bại');
        }
    }
}
