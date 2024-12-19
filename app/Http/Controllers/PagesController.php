<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class PagesController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    // edit_about
    public function update_about(Request $request){
        $this -> AuthLogin();
        $data = array();
        $data['page_desc'] = $request->about_desc;
        DB::table('tbl_pages')->where('page_id', 1)->update($data);
        Session::put('message', 'Cập nhật trang giới thiệu thành công');
        return Redirect::to('/edit-aboutpage');
    }
    public function edit_about(){
        $this -> AuthLogin();
        $about = DB::table('tbl_pages')
            ->where('page_id', 1)
            ->first();
        return view('admin.edit_about_page', [
            'about' => $about
        ]);
    }

    public function update_contact(Request $request){
        $this -> AuthLogin();
        $data = array();
        $data['page_desc'] = $request->about_desc;
        DB::table('tbl_pages')->where('page_id', 2)->update($data);
        Session::put('message', 'Cập nhật trang giới thiệu thành công');
        return Redirect::to('/edit-contactpage');
    }
    public function edit_contact(){
        $this -> AuthLogin();
        $about = DB::table('tbl_pages')
            ->where('page_id', 2)
            ->first();
        return view('admin.edit_contact_page', [
            'about' => $about
        ]);
    }





    public function show_contact() {
        //lấy dữ liệu từ bản tbl_page nơi có page_id
        $contact = DB::table('tbl_pages')
            ->where('page_id', 2)  // Đảm bảo page_id là 1
            ->select('page_desc')
            ->first();  // Lấy một bản ghi duy nhất
    
        if (!$contact) {
            return redirect()->back()->with('error', 'Page not found');
        }
    
        return view('pages.tab.contact.contact', [
            'ct_desc' => $contact->page_desc  // Truyền dữ liệu cột page_desc
        ]);
    }
    public function show_about() {
        // Lấy dữ liệu từ bảng tbl_pages với page_id = 1
        $about = DB::table('tbl_pages')
            ->where('page_id', 1)  // Đảm bảo page_id là 1
            ->select('page_desc')
            ->first();  // Lấy một bản ghi duy nhất
    
        if (!$about) {
            return redirect()->back()->with('error', 'Page not found');
        }
    
        return view('pages.tab.about.about', [
            'ab_desc' => $about->page_desc  // Truyền dữ liệu cột page_desc
        ]);
    }

}
