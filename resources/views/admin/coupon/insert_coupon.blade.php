@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm mã giảm giá
                </header>
                <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session('message', null);
                    }
                    ?>
                <div class="panel-body">
                    
                    <div class="position-center">
                        <form role="form" action="{{ asset('/insert-coupon-code') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                <input type="text" name="coupon_name" class="form-control"
                                    value="{{ old('coupon_name') }}" placeholder="Tên mã giảm giá">
                                @error('coupon_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã giảm giá</label>
                                <input type="text" name="coupon_code" class="form-control"
                                    value="{{ old('coupon_code') }}" placeholder="Tên mã giảm giá">
                                @error('coupon_code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số lượng</label>
                                <input type="text" name="coupon_times" class="form-control"
                                    value="{{ old('coupon_times') }}" placeholder="Tên mã giảm giá">
                                @error('coupon_times')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputPassword1" class="col-sm-2 col-form-label">Tính năng mã</label>
                                <div class="col-sm-3">
                                    <select name="coupon_condition" class="form-control input-sm m-bot15" data-validation="required">
                                        <option value="0">------Chọn------</option>
                                        <option value="1">Giảm theo %</option>
                                        <option value="2">Giảm theo tiền</option>
                                    </select>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nhập số % hoặc số tiền giảm</label>
                                <input type="text" name="coupon_number" class="form-control"
                                    value="{{ old('coupon_number') }}">
                                {{-- <textarea style="resize: none" rows="8" class="form-control" name="coupon_number">{{ old('coupon_number') }}</textarea> --}}
                                @error('coupon_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" name="add-coupon" class="btn btn-info">Thêm mã giảm giá</button>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    @endsection
