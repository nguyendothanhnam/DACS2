<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Coupon;

class CartController extends Controller
{
    // public function save_cart(Request $request ){

    //     $productId = $request->productid_hidden;
    //     $quantity = $request->qty;
    //     $product_info = DB::table('tbl_product')->where('product_id', $productId)->first( );
    //     // echo '<pre>';
    //     // print_r($product_info);
    //     // echo '</pre>';

    //     // Cart::add('293ad', 'Product 1', 1, 9.99, 550);

    //     $data['id'] = $product_info->product_id;
    //     $data['qty'] = $quantity;
    //     $data['name'] = $product_info->product_name;
    //     $data['price'] = $product_info->product_price;
    //     $data['weight'] = $product_info->product_price;
    //     $data['options']['image'] = $product_info->product_image;

    //     Cart::add($data);
    //     // Cart::destroy();
    //     // Cart::setGlobalTax(10);

    //     return Redirect::to('/show-cart');
    //     // // return Redirect::to('/gio-hang');
        
    //     // Cart::add('293ad', 'Product 1', 1, 9.99);
    //     // Cart::destroy();

        
    // }
    // public function show_cart(){
        
    //     return view('pages.tab.cart.tabcart');
    // }
    // public function delete_to_cart($rowId){
    //     Cart::update($rowId, 0);
    //     return Redirect::to('/show-cart');
    // }


    // public function update_cart_quantity(Request $request){
    //     $rowId = $request->rowId_cart;
    //     $qty = $request->cart_quantity;
    //     Cart::update($rowId, $qty);
    //     return Redirect::to('/show-cart');
    // }
    // // public function update_all_cart_quantity(Request $request){
    // //     Cart::update($rowId, $qty);
    // // }
    public function save_cart(Request $request ){

        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id', $productId)->first( );

        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = 1;
        $data['options']['image'] = $product_info->product_image;

        Cart::add($data);
        Cart::setGlobalTax(10);

        return Redirect::to('/show-cart');
        // return Redirect::to('/gio-hang');
        
        // Cart::add('293ad', 'Product 1', 1, 9.99);
        // Cart::destroy();

    }

    public function show_cart(Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();

        return view('pages.tab.cart.tabcart')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }

    public function delete_to_cart($rowId){
        Cart::remove($rowId);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;

        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable==0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_id' => $data['cart_product_id'],
                    'product_name' => $data['cart_product_name'],
                    'product_image' => $data['cart_product_image'],
                    'product_price' => $data['cart_product_price'],
                    'product_qty' => $data['cart_product_qty'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_image' => $data['cart_product_image'],
                'product_price' => $data['cart_product_price'],
                'product_qty' => $data['cart_product_qty'],
            );
        }           
        Session::put('cart',$cart);
        Session::save();
    }

    public function gio_hang(Request $request){
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status','0')
            ->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')
            ->where('brand_status','0')
            ->orderby('brand_id', 'desc')->get();

        return view('pages.tab.cart.tabcart')
        ->with('category',$cate_product)
        ->with('brand',$brand_product);
    }

    public function del_product($session_id){
        $cart = Session::get('cart');
               
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','Xóa sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','Xóa sản phẩm thất bại');
        }
    }

    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']==$key && $qty>0){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','Cập nhật giỏ hàng thành công');
        }else{
            return Redirect()->back()->with('message','Cập nhật giỏ hàng thất bại');
        }
    }

    public function del_all_product(){
        $cart = Session::get('cart');
        if($cart==true){
            Session::forget('cart');
            Session::forget('coupon');
            return Redirect()->back()->with('message','Xóa tất cả sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','Xóa tất cả sản phẩm thất bại');
        }
        // Session::forget('cart');
        // return Redirect()->back()->with('message','Xóa tất cả sản phẩm thành công');
    }

    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->first();
        if ($coupon) {
            $coupon_session = Session::get('coupon', []);
            $is_avaiable = false;
        
            foreach ($coupon_session as $sess_coupon) {
                if ($sess_coupon['coupon_code'] == $coupon->coupon_code) {
                    $is_avaiable = true;
                    break;
                }
            }
        
            if (!$is_avaiable) {
                $cou[] = [
                    'coupon_code' => $coupon->coupon_code,
                    'coupon_condition' => $coupon->coupon_condition,
                    'coupon_number' => $coupon->coupon_number,
                ];
                Session::put('coupon', $cou);
                return Redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
            } else {
                return Redirect()->back()->with('error', 'Mã giảm giá đã được sử dụng');
            }
        } else {
            return Redirect()->back()->with('error', 'Mã giảm giá không đúng');
        }
        
    }
}
