<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Feeship;
use App\Models\Customer;
use App\Models\Coupon;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function manage_order(){
        $order = Order::orderBy('created_at','desc')->paginate(10);
        return view('admin.manage_order')->with(compact('order'));
    }

    public function view_order($order_code){
        $order_details = OrderDetails::where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();

        foreach($order_details as $key => $order_d){
            $product_coupon = $order_d->product_coupon;
            
        }
        
        if($product_coupon != 'No'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;
        }
            
        return view('admin.view_order')
        ->with(compact('order_details','customer','shipping','coupon_condition','coupon_number', 'order'));
    }

    public function update_order(Request $request){
        // $data = $request->all();
        // $order = Order::find($data['order_id']);
        // $order->order_status = $data['order_status'];
        // $order->save();
        // Lấy dữ liệu từ request
    $data = $request->all();
    $order = Order::find($data['order_id']); // Tìm đơn hàng theo ID

    if ($order) {
        // Cập nhật trạng thái đơn hàng
        $order->order_status = $data['order_status'];
        $order->save();

        // Gửi email nếu trạng thái mới là "Đang giao hàng"
        if ($order->order_status == 2) {
            // Lấy thông tin vận chuyển từ quan hệ
            $shipping = $order->shipping; // Sử dụng quan hệ trong model

            if ($shipping) {
                $this->send_mail($shipping->shipping_email, $shipping->shipping_name);
            }
        }

        return redirect()->back()->with('message', 'Cập nhật trạng thái đơn hàng thành công.');
    }

    return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
    }

    public function send_mail($to_email, $to_name){
        $data = [
            "name" => $to_name,
            "body" => "Đơn hàng của bạn hiện đang được giao. Xin cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi!"
        ];
    
        Mail::send('pages.tab.mail.send_mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject("Thông báo giao hàng");
            $message->from('namndt.23it@vku.udn.vn', 'LapWibu');
        });
        return redirect('/')->with('message','');
    }
}
