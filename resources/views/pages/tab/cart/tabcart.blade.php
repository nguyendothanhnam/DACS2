@extends('layout')
@section('tabcontent')
    <div class="container my-5">
        <h2 class="mb-4">Giỏ Hàng</h2>
        <table class="table table-bordered text-center align-middle shopping-cart-table">
            <?php
            $content = Cart::content();
            ?>
            <thead class="table-dark">
                <form action="{{ URL::to('/update-cart') }}" method="POST">
                    @csrf
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Tiền</th>
                        <th>Xóa</th>
                    </tr>
            </thead>
            <tbody>
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
                            <td><img src="{{ asset('public/uploads/product/' . $cart['product_image']) }}" alt="Product Image"
                                    class="img-fluid cart-art"></td>
                            <td>{{ $cart['product_name'] }}</td>
                            <td>{{ number_format($cart['product_price']) . ' ' . 'VND' }}</td>
                            <td>
                                {{-- <form id="updateCartForm" action="{{ URL::to('/update-cart-quantity') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="number" name="cart_quantity" value="{{ $v_content->qty }}" min="1" class="form-control text-center">
                                <input type="hidden" name="rowId_cart" value="{{ $v_content->rowId }}" class="form-control text-center">
                                <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-primary btn-sm">
                            </form> --}}
                                <div class="cart_quantity_button">
                                    @csrf
                                    <input class="cart_quantity" type="number" name="cart_qty[{{ $cart['session_id'] }}]"
                                        value="{{ $cart['product_qty'] }}" min="1" autocomplete="off" size="1"
                                        style="width: 70px">
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    {{ number_format($subtotal, 0, ',', '.') }} VND
                                </p>
                            </td>
                            <td>
                                {{-- <a href="{{ URL::to('/delete-to-cart/' . $v_content->rowId) }}">
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xóa</button>
                            </a> --}}
                                <a class="cart_quantity_delete"
                                    href="{{ URL::to('/del-product/' . $cart['session_id']) }}"><i
                                        class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    <tr style="border-style: none">
                        <td>
                            <button name="update_qty" onclick="submitCartForm()" class="btn btn-primary check_out">Cập nhật
                                giỏ hàng</button>

                        </td>
                        <td>
                            {{-- <button class="btn btn-primary check_out" href="{{URL::to ('/del-all-product') }}">Xóa tất cả</button> --}}
                            <a class="btn btn-primary check_out" href="{{ URL::to('/del-all-product') }}">Xóa tất cả</a>
                        </td>
                        <td>
                            @if (Session::get('coupon'))
                                <a href="{{ url('/unset-coupon') }}" class="btn btn-primary check_out">Hủy mã giảm giá</a>
                            @endif
                        </td>
                        <td>
                            @if (Session::get('customer'))
                                <a href="{{ url('/checkout') }}" class="btn btn-warning check_out">Đặt hàng</a>
                            @else
                                <a href="{{ url('/login-checkout') }}" class="btn btn-warning check_out">Đặt hàng</a>
                            @endif
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div class="total_area" style="text-align: left">

                                Tổng tiền: <span>{{ number_format($total, 0, ',', '.') . ' VND' }}</span> <br>
                                
                                @if (Session::get('coupon'))
                                Mã giảm:
                                    @foreach (Session::get('coupon') as $key => $cou)
                                        @if ($cou['coupon_condition'] == 1)
                                            <span>{{ $cou['coupon_number'] }} %</span>
                                            <p>
                                                @php
                                                    $total_coupon = ($total * $cou['coupon_number']) / 100;
                                                    echo 'Tổng giảm: <span>' .
                                                        number_format($total_coupon, 0, ',', '.') .
                                                        ' VND </span>';
                                                @endphp
                                            </p>
                                            <p>
                                                @php
                                                    $total = $total - $total_coupon;
                                                    // echo number_format($total,0,',','.') . ' VND';
                                                @endphp
                                            </p>
                                        @else
                                            <span>{{ number_format($cou['coupon_number'], 0, ',', '.') }} VND</span>
                                            <p>
                                                @php
                                                    $total = $total - $cou['coupon_number'];
                                                    // echo number_format($total,0,',','.') . ' VND';
                                                @endphp
                                            </p>
                                        @endif
                                    @endforeach
                                @endif

                                Thành tiền: <span>{{ number_format($total, 0, ',', '.') . ' VND' }}</span>
                                {{-- <li>Thuế<span></span></li>
                                    <li>Phí vận chuyển <span>Free</span></li>
                                    <li>Thành tiền <span></span></li> --}}

                                {{-- <a class="btn btn-default check_out" href="">Thanh toán</a> --}}

                            </div>
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
            </form>
            @if (Session::has('cart') != null)
                <tr>
                    <td style="border-right: 0; border-right-style: none;">
                        <div>
                            <form action="{{ url('/check-coupon') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá">
                                <br>
                                <input type="submit" class="btn btn-primary check_coupon" value="Áp dụng"
                                    name="check_coupon">
                            </form>
                        </div>
                    </td>
                    <td colspan="5"></td>
                </tr>
            @endif
        </table>
        {{-- <div class="d-flex justify-content-between align-items-center mt-4 shopping-cart-actions"> --}}
        {{-- nút cập nhập --}}
        {{-- <button onclick="submitCartForm()" class="btn btn-primary">Cập nhật giỏ hàng</button> --}}
        {{-- <button class="btn btn-primary">Cập nhật</button>
            <button class="btn btn-primary">Xóa tất cả</button>
            @php
                $customer_id = Session::get('customer_id');
            @endphp
            @if ($customer_id != null)
                <form action="{{ URL::to('/checkout') }}" method="GET" class="d-inline">
                    <button type="submit" class="btn btn-warning">Thanh toán</button>
                </form>
            @else
                <form action="{{ URL::to('/login-checkout') }}" method="GET" class="d-inline">
                    <button type="submit" class="btn btn-warning">Thanh toán</button>
                </form>
            @endif

            <div class="fw-bold">Tổng tiền: <span class="text-danger">{{ Cart::subtotal() }}</span></div>
        </div>
    </div> --}}

        <script>
            function submitCartForm() {
                document.getElementById('updateCartForm').submit();
            }
        </script>
    @endsection
