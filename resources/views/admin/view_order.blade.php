@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">

                    <thead>
                        <tr>
                            <th>Tên khách hàng</th>
                            <th>Email</th>
                            <td>Số điện thoại</td>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->customer_email }}</td>
                            <td>{{ $customer->customer_phone }}</td>
                            <th style="width:30px;"></th>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br>

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">

                    <thead>
                        <tr>
                            <th>Tên người nhận hàng</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Ghi chú</th>
                            <th>Hình thức thanh toán</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $shipping->shipping_name }}</td>
                            <td>{{ $shipping->shipping_email }}</td>
                            <td>{{ $shipping->shipping_address }}</td>
                            <td>{{ $shipping->shipping_phone }}</td>
                            <td>{{ $shipping->shipping_notes }}</td>
                            <td>
                                @if ($shipping->shipping_method == 0)
                                    Chuyển khoản
                                @else
                                    Tiền mặt
                                @endif
                            </td>
                            <th style="width:30px;"></th>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br>

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">

                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Mã giảm giá</th>
                            <th>Phí vận chuyển</th>
                            <th>Số lượng</th>
                            <th>Giá sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach ($order_details as $key => $details)
                            @php
                                $i++;
                                $subtotal = $details->product_price * $details->product_sales_quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $details->product_name }}</td>
                                <td>
                                    @if ($details->product_coupon != 'No')
                                        {{ $details->product_coupon }}
                                    @else
                                        Không có mã giảm giá
                                    @endif
                                </td>
                                <td>{{ number_format($details->product_feeship, 0, ',', '.') . ' VND' }}</td>
                                <td>{{ $details->product_sales_quantity }}</td>
                                <td>{{ number_format($details->product_price, 0, ',', '.') . ' VND' }}</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') . ' VND' }}</td>
                                <th style="width:30px;"></th>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="7">
                                <h5>
                                    @php
                                        $total_coupon = 0;
                                    @endphp
                                    @if ($coupon_condition == 1)
                                        @php
                                            $total_after_coupon = ($total * $coupon_number) / 100;
                                            echo 'Tổng tiền sau khi giảm giá: ' .
                                                number_format($total_after_coupon, 0, ',', '.') .
                                                ' VND';
                                            $total_coupon = $total - $total_after_coupon + $details->product_feeship;
                                        @endphp
                                    @else
                                        @php
                                            echo 'Tổng tiền sau khi giảm giá: ' .
                                                number_format($total_coupon, 0, ',', '.') .
                                                ' VND';
                                            $total_coupon = $total - $coupon_number + $details->product_feeship;
                                        @endphp
                                    @endif
                                    <br>

                                    Phí ship: {{ number_format($details->product_feeship, 0, ',', '.') . ' VND' }}
                                    <br>
                                    Thanh toán: {{ number_format($total_coupon, 0, ',', '.') . ' VND' }}
                                </h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <form>
                                    @csrf
                                    {{-- @foreach ($order as $key => $or)
                                        @if ($or->order_status == 1)
                                            <select class="form-control order_details">
                                                <option value="">-----Chọn hình thức đơn hàng-----</option>
                                                <option id="{{ $or->order_id }}" value="1">Chưa xử lý</option>
                                                <option id="{{ $or->order_id }}" value="2">Đã xử lý - Đang giao hàng
                                                </option>
                                                <option id="{{ $or->order_id }}" value="3">Hủy đơn hàng - tạm giữ
                                                </option>
                                            </select>
                                
                            @elseif ($or->order_status == 2)
                                <select class="form-control order_details">
                                    @csrf
                                    <option value="">-----Chọn hình thức đơn hàng-----</option>
                                    <option id="{{ $or->order_id }}" value="1">Chưa xử lý</option>
                                    <option id="{{ $or->order_id }}" value="2" selected>Đã xử lý - Đang giao hàng
                                    </option>
                                    <option id="{{ $or->order_id }}" value="3">Hủy đơn hàng - tạm giữ</option>
                                </select>
                            @else
                                <select class="form-control order_details">
                                    @csrf
                                    <option value="">-----Chọn hình thức đơn hàng-----</option>
                                    <option id="{{ $or->order_id }}" value="1">Chưa xử lý</option>
                                    <option id="{{ $or->order_id }}" value="2">Đã xử lý - Đang giao hàng</option>
                                    <option id="{{ $or->order_id }}" value="3" selected>Hủy đơn hàng - tạm giữ
                                    </option>
                                </select>
                                @endif
                                @endforeach --}}
                                    @foreach ($order as $key => $or)
                        <tr>
                            <td>
                                <select class="form-control order_details">
                                    <option value="">-----Chọn hình thức đơn hàng-----</option>
                                    <option id="{{ $or->order_id }}" value="1"
                                        {{ $or->order_status == 1 ? 'selected' : '' }}>Chưa xử lý</option>
                                    <option id="{{ $or->order_id }}" value="2"
                                        {{ $or->order_status == 2 ? 'selected' : '' }}>Đã xử lý - Đang giao hàng</option>
                                    <option id="{{ $or->order_id }}" value="3"
                                        {{ $or->order_status == 3 ? 'selected' : '' }}>Hủy đơn hàng - tạm giữ</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach

                        </form>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
