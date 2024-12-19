<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function index() {
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        
        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderBy('tbl_product.product_id','desc')->get();
        
        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id', 'desc')->paginate(15);

        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product);
    }
    public function show_home() {
        return view('layout');
    }
    public function showlayoutproduct() {
        // san pham moi nhat
        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id', 'desc')->limit(10)->get();
        // sản phẩm danh mục gaming
        $gaming_product = DB::table('tbl_product')->where('category_id','1')->orderby('product_id', 'desc')->limit(10)->get();
        // sản phẩm danh mục office
        $office_product = DB::table('tbl_product')->where('category_id','2')->orderby('product_id', 'desc')->limit(10)->get();
        // sản phẩm danh mục gear
        $gear_product = DB::table('tbl_product')->where('category_id','3')->orderby('product_id', 'desc')->limit(10)->get();


        return view('pages.tab.home.tabhome')->with('all_product',$all_product)->with('gaming_product',$gaming_product)->with('office_product',$office_product);
        
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->paginate(15);

        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product);
    }
}
