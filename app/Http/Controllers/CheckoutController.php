<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Wards;
use App\Models\City;
use App\Models\Province;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;

class CheckoutController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function login_checkout(Request $request){

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        return view('pages.tab.login-register.login-register')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;
        $customer_id = DB::table('tbl_customers')->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');
    }

    public function checkout(Request $request){
       
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        
        $city = City::orderby('matp','ASC')->get();
        
        return view('pages.tab.checkout.checkout')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with(compact('city'));;
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_notes'] = $request->shipping_notes;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/payment');
    }

    public function payment(Request $request){

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        return view('pages.checkout.payment')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }

    public function order_place(Request $request){

        //insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::subtotal();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
        // $body_massage = 'mã đơn hàng  '.$order_id.'tổng tiền: '.$order_data['order_total']; 

        //insert order detail
        foreach(Cart::content() as $v_content){
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }

        if($data['payment_method'] == 1){
            echo 'Thanh toán bằng thẻ ATM';
        }elseif($data['payment_method'] == 2){
            Cart::destroy();
            $cate_product = DB::table('tbl_category_product')
            ->where('category_status','0')
            ->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand')
            ->where('brand_status','0')
            ->orderby('brand_id', 'desc')->get();

            // Send email to customer
            app('App\Http\Controllers\HomeController')->send_mail();
            
            return view('pages.checkout.handcash')
            ->with('category',$cate_product)
            ->with('brand',$brand_product);
        }else{
            echo 'Thanh toán bằng thẻ ghi nợ';
        }

        // Session::put('payment_id',$payment_id);
        // return Redirect::to('/payment');
    }

    public function logout_checkout(Request $request){
        Session::flush();
        return Redirect('/login-checkout');
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
        if($result){
            Session::put('customer_email',$result->customer_email);
            Session::put('customer_phone',$result->customer_phone);
            Session::put('customer_name',$result->customer_name);            
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }else{
            return Redirect::to('/login-checkout');
        }
    }

    public function manage_order(){
        $this->AuthLogin();
        $all_order_info = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manage_order = view('admin.manage_order')->with('all_order_info',$all_order_info);
        return view('admin_layout')->with('admin.manage_order',$manage_order);
    }

    public function view_order($orderID){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        // ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')
        ->first();
        $manage_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manage_order_by_id);
        
    }

    public function select_delivery_home(Request $request){
        $data = $request->all();
        if ($request->action == 'city') {
            $select_province = Province::where('matp', (string)$data['ma_id'])->orderBy('maqh', 'ASC')->get();
            $output = '<option value="">--- Chọn quận huyện ---</option>';
            foreach ($select_province as $key => $province) {
                $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
            }
            
            echo $output;
        } elseif ($request->action == 'province') {
            $select_wards = Wards::where('maqh', $data['ma_id'])->orderBy('xaid', 'ASC')->get();
            $output = '<option value="">--- Chọn xã phường ---</option>';
            foreach ($select_wards as $ward) {
                $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
            }
            echo $output;
        }
    }

    public function calculate_fee(Request $request){
        $data = $request->all();
        // dd($data);
        if($data['matp']){
            // $feeship = Feeship::where('fee_matp', $data['matp'])
            // ->where('fee_maqh', $data['maqh'])
            // ->where('fee_xaid', $data['xaid'])->get();
            $feeship = Feeship::where('fee_matp', $data['matp'])
                  ->where('fee_maqh', $data['maqh'])
                  ->where('fee_xaid', $data['xaid'])
                  ->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                    foreach($feeship as $key => $fee){
                        Session::put('fee', $fee->fee_feeship);
                        Session::save();
                    }
                    echo $fee->fee_feeship;
                }else{
                    Session::put('fee', 10000);
                    Session::save();
                }
            }
        }
        
    }

    public function del_fee(){
        Session::forget('fee');
        return redirect()->back();
    }

    public function confirm_order(Request $request){
        
        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),5);

        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $order->created_at = now();
        $order->save();

        if(Session::get('cart')){
            foreach(Session::get('cart') as $key => $cart){
                $order_details = new OrderDetails();
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
    }


}
