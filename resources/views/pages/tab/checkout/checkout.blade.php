@extends('layout')
@section('tabcontent')
    <div class="container my-5">
        <div class="row">
            <!-- Cột trái: Thông tin thanh toán -->
            <div class="col-lg-6">
                <div class="checkout-section">
                    <h5 class="mb-4">Thông tin thanh toán</h5>
                    <form method="POST">
                        @csrf
                        @if (Session::get('fee'))
                            <input type="hidden" name="order_fee" class="order_fee" value="{{ Session::get('fee') }}">
                        @else
                            <input type="hidden" name="order_fee" class="order_fee" value="10000">
                        @endif
                        @if (Session::get('coupon'))
                            @foreach (Session::get('coupon') as $key => $cou)
                                <input type="hidden" name="order_coupon" class="order_coupon"
                                    value="{{ $cou['coupon_code'] }}">
                            @endforeach
                        @else
                            <input type="hidden" name="order_coupon" class="order_coupon" value="No">
                        @endif


                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên *</label>
                            <input type="text" name="shipping_name" class="form-control shipping_name" id="fullname"
                                placeholder="Nhập họ và tên" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email"name="shipping_email" class="form-control shipping_email" id="email"
                                placeholder="Nhập email" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ *</label>

                            <input type="text" name="shipping_address" class="form-control shipping_address"
                                id="address" placeholder="Nhập địa chỉ" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại *</label>
                            <input type="tel" name="shipping_phone" class="form-control shipping_phone" id="phone"
                                placeholder="Nhập số điện thoại" required>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú đơn hàng (tuỳ chọn)</label>
                            <textarea class="form-control shipping_notes" name="shipping_notes" id="note" rows="3"
                                placeholder="Ghi chú về đơn hàng"></textarea>
                        </div>
                        {{-- <button type="submit" class="btn btn-primary w-100">Xác nhận thông tin</button> --}}
                        <!-- Phương thức thanh toán -->
                        <div class="mb-3">
                            <label for="note" class="form-label">Phương thức thanh toán *</label>

                            <select name="payment_select"
                                class="form-control input-sm m-bot15 choose payment_select">
                                <option value="0">Chuyển khoản</option>
                                <option value="1">Thanh toán khi nhận hàng</option>
                            </select>
                        </div>
                        <button type="button" name="send_order" class="btn btn-primary w-100 send_order">Đặt hàng</button>
                    </form>

                </div>
            </div>

            <!-- Cột phải: Bảng sản phẩm -->
            <div class="col-lg-6">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @elseif (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="table-summary mb-4">
                    <form>
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn tỉnh/thành phố</label>
                            <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                <option value="">--- Chọn tỉnh/thành phố ---</option>
                                @foreach ($city as $key => $ci)
                                    <option value="{{ $ci->matp }}">{{ $ci->name_city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn quận huyện</label>
                            <select name="province" id="province" class="form-control input-sm m-bot15 choose province">
                                <option value="">--- Chọn quận huyện ---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword2">Chọn xã phường</label>
                            <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                <option value="">--- Chọn xã phường ---</option>
                            </select>
                        </div>
                        <input style="margin-top: 10px" type="button" value="Tính phí vận chuyển" name="calculate_order"
                            class="btn btn-primary btn-sm calculate_delivery">
                    </form>
                </div>
                <div class="table-summary mb-4">
                    <h5 class="mb-3">Sản phẩm</h5>
                    <table class="table table-bordered">
                        <form action="{{ URL::to('/update-cart') }}" method="POST">
                            @csrf

                            <thead>
                                <tr>
                                    <td class="description">Tên sản phẩm</td>

                                    <td class="quantity">Số lượng</td>
                                    <td>Giá sản phẩm</td>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($content as $v_content)
                                <tr>
                                    <td>{{ $v_content->name }}</td>
                                    <td>{{ $v_content->qty }}</td>
                                    <td>{{ number_format($v_content->price) . ' ' . 'VND' }}</td>
                                </tr>
                            @endforeach --}}
                                @if (Session::has('cart') != null)
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach (Session::get('cart') as $key => $cart)
                                        @php
                                            $subtotal = $cart['product_price'] * $cart['product_qty'];
                                            $total += $subtotal;
                                        @endphp
                                        <tr>

                                            <td class="cart_description">
                                                <h4><a href="" class="truncate"></a></h4>
                                                <p>{{ $cart['product_name'] }}</p>
                                            </td>

                                            <td class="cart_quantity">
                                                <div class="cart_quantity_button">
                                                    @csrf
                                                    <input class="cart_quantity" type="number"
                                                        name="cart_qty[{{ $cart['session_id'] }}]"
                                                        value="{{ $cart['product_qty'] }}" min="1"
                                                        autocomplete="off" size="1" style="width: 70px">
                                                </div>
                                            </td>
                                            <td class="cart_total">
                                                <p class="cart_total_price">
                                                    {{ number_format($subtotal, 0, ',', '.') }} VND
                                                </p>
                                            </td>

                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="3">
                                            <div class="total_area">
                                                
                                                    Tổng tiền:
                                                        <span>{{ number_format($total, 0, ',', '.') . ' VND' }}</span>
                                                   <br>
                                                    Mã giảm:
                                                        @if (Session::get('coupon'))
                                                            @foreach (Session::get('coupon') as $key => $cou)
                                                                @if ($cou['coupon_condition'] == 1)
                                                                    <span>{{ $cou['coupon_number'] }} %</span>
                                                                    <p>
                                                                        @php
                                                                            $total_coupon =
                                                                                ($total * $cou['coupon_number']) / 100;
                                                                            echo '<li>Tổng giảm: <span>' .
                                                                                number_format($total_coupon,0,',','.',) . ' VND </span>  </li>';
                                                                        @endphp
                                                                    </p>
                                                                    <p>
                                                                        @php
                                                                            $total_after_coupon =
                                                                                $total - $total_coupon;
                                                                            // echo number_format($total,0,',','.') . ' VND';
                                                                        @endphp
                                                                    </p>
                                                                @else
                                                                    <span>{{ number_format($cou['coupon_number'], 0, ',', '.') }}
                                                                        VND</span>
                                                                    <p>
                                                                        @php
                                                                            $total_after_coupon =
                                                                                $total - $cou['coupon_number'];
                                                                            // echo number_format($total,0,',','.') . ' VND';
                                                                        @endphp
                                                                    </p>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    <br>
                                                    {{-- <li>Thành tiền:
                                                                <span>{{ number_format($total, 0, ',', '.') . ' VND' }}</span>
                                                            </li> --}}
                                                    {{-- <li>Thuế<span></span></li> --}}
                                                    @if (Session::get('fee'))
                                                        
                                                            <a class="cart_quantity_delete"
                                                                href="{{ URL::to('/del-fee/') }}">
                                                                <i class="fa fa-trash-o"></i></a>
                                                            Phí vận chuyển
                                                            <span>{{ number_format(Session::get('fee'), 0, ',', '.') }}
                                                                VND </span>
                                                       
                                                        <?php
                                                        $total_after_fee = $total + Session::get('fee');
                                                        ?>
                                                    @endif

                                                    @php
                                                        if (Session::get('fee') && !Session::get('coupon')) {
                                                            $total_after = $total_after_fee;
                                                        } elseif (!Session::get('fee') && Session::get('coupon')) {
                                                            $total_after = $total_after_coupon;
                                                        } elseif (Session::get('fee') && Session::get('coupon')) {
                                                            $total_after = $total_after_coupon + Session::get('fee');
                                                        } elseif (!Session::get('fee') && !Session::get('coupon')) {
                                                            $total_after = $total;
                                                        }
                                                    @endphp

                                                
                                                {{-- <a class="btn btn-default check_out" href="">Thanh toán</a> --}}

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >
                                            <div class="d-flex justify-content-between mt-3">
                                                <span>Tổng giá:</span>
                                                
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            <span class="total-price">{{ number_format($total_after, 0, ',', '.') }} VND </span>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <center>
                                                <p>Không có sản phẩm nào trong giỏ hàng</p>
                                            </center>
                                        </td>
                                    </tr>
                                @endif
                                
                            </tbody>
                            
                    </table>
                    
                </div>


            </div>
        </div>
    </div>
@endsection
