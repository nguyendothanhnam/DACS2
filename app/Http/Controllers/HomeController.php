<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index() {

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        
        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id', 'desc')->paginate(15);

        // return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product);
        return view('pages.home')->with(compact('cate_product','brand_product','all_product'));
    }
    public function show_home() {
        return view('layout');
    }
    public function showlayoutproduct() {
        //Slide
        $slider = Slider::orderBy('slider_id','DESC')->take(4)->get();

        // san pham moi nhat
        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id', 'desc')->limit(10)->get();
        // sản phẩm danh mục gaming
        $gaming_product = DB::table('tbl_product')->where('category_id','1')->orderby('product_id', 'desc')->limit(10)->get();
        // sản phẩm danh mục office
        $office_product = DB::table('tbl_product')->where('category_id','2')->orderby('product_id', 'desc')->limit(10)->get();
        // sản phẩm danh mục gear
        $gear_product = DB::table('tbl_product')->where('category_id','3')->orderby('product_id', 'desc')->limit(10)->get();


        return view('pages.tab.home.tabhome')->with('all_product',$all_product)->with('gaming_product',$gaming_product)->with('office_product',$office_product)
        ->with('slider',$slider);
        
    }
    // public function send_mail(){
    //     // $to_name = "Thành Nam";
    //     // $to_email ="hinenevil@gmail.com";
    //     // // $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$rand_id);

    //     // $data = array("name"=>"Mail từ tài khoản khách hàng","body"=>"Mail gửi về vấn đề sản phẩm");
    //     // Mail::send('pages.send_mail', $data,function($message) use ($to_name, $to_email){
    //     //     $message->to($to_email)->subject("Quên mật khẩu");
    //     //     $message->from('namndt.23it@vku.udn.vn',$to_name);
    //     // });
        
    //     return redirect('/')->with('message','');
    // }

    public function search(Request $request)
    {
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->paginate(15);

        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product);
    }
}
