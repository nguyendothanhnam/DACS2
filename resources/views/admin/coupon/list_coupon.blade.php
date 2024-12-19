@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê mã giảm giá
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session('message', null);
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên mã giảm giá</th>
                            <th>Mã giảm giá</th>
                            <th>Số lượng</th>
                            <th>Điều kiện giảm giá</th>
                            <th>Số giảm</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupon as $key => $cou)
                            <tr>
                                <td>{{ $cou->coupon_id }}</td>
                                <td>{{ $cou->coupon_name }}</td>
                                <td>{{ $cou->coupon_code }}</td>
                                <td>{{ $cou->coupon_time }}</td>
                                <td><span class="text-ellipsis">
                                        <?php
                                    if ($cou ->coupon_condition == 1) {
                                ?>
                                        Giảm theo %
                                        <?php
                                    } else {
                                ?>
                                        Giảm theo tiền
                                        <?php
                                    }   
                                ?>
                                    </span></td>

                                <td><span class="text-ellipsis">
                                        <?php
                                            if ($cou ->coupon_condition == 1) {
                                        ?>
                                        Giảm {{ $cou->coupon_number }} %
                                        <?php
                                            } else {
                                        ?>
                                        Giảm {{ $cou->coupon_number }} VND
                                        <?php
                                            }   
                                        ?>
                                    </span></td>

                                <td>
                                    {{-- <a href="{{ asset('/edit-brand-product/' . $brand_pro->brand_id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                                    </a> --}}
                                    <a onclick="return confirm('Bạn có chắc muốn xóa mã giảm giá này không?')"
                                        href="{{ asset('/delete-coupon/' . $cou->coupon_id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-trash-o text-danger text"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm"></small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li>{{ $coupon->links() }}</li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
