<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function AuthLogin(){
        // $admin_id = Session::get('admin_id');
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function manage_banner()
    {
        $all_slide = Slider::orderBy('slider_id', 'DESC')->paginate(10);
        return view('admin.slider.list_slider')->with(compact('all_slide'));
    }

    public function add_slider()
    {
        return view('admin.slider.add_slider');
    }

    public function insert_slider(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();

        $get_image = $request->file('slider_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/slider', $new_image);

            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_desc = $data['slider_desc'];
            $slider->slider_status = $data['slider_status'];
            $slider->save();
            Session::put('message', 'Thêm slide thành công');
            return Redirect::to('add-slider');
        }
    }
    public function unactive_slider($slider_id)
    {
        $this->AuthLogin();
        $slider = Slider::find($slider_id);
        if ($slider) {
            $slider->slider_status = 1;  // Đặt trạng thái không kích hoạt
            $slider->save();
        }
        Session::put('message', 'Slide không được kích hoạt');
        return Redirect::to('/manage-banner');
    }

    public function active_slider($slider_id)
    {
        $this->AuthLogin();
        $slider = Slider::find($slider_id);
        if ($slider) {
            $slider->slider_status = 0;  // Đặt trạng thái kích hoạt
            $slider->save();  // Lưu thay đổi vào CSDL
        }
        Session::put('message', 'Slide được kích hoạt');
        return Redirect::to('/manage-banner');
    }
    public function delete_slider($slider_id)
    {
        $this->AuthLogin();
        $slider = Slider::find($slider_id);
        if ($slider) {
            $slider->delete();
        }
        Session::put('message', 'Xóa slide thành công');
        return Redirect::to('/manage-banner');
    }
}
