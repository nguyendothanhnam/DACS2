@extends('layout')
@section('tabcontent')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="form-section">
                <h4 class="text-center">Đăng nhập tài khoản</h4>
                <form action="{{ URL::to('/login-customer') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="username" class="form-label">Tài khoản</label>
                        <input type="text" name="email_account" class="form-control" id="username" placeholder="Tài khoản">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password_account" class="form-control" id="password" placeholder="Mật khẩu">
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
            </div>
        </div>
        <div class="col-md-2 d-flex align-items-center justify-content-center">
            <div class="circle-divider">Hoặc</div>
        </div>
        <div class="col-md-5">
            <div class="form-section">
                <h4 class="text-center">Tạo tài khoản mới</h4>
                <form action="{{ URL::to('/add-customer') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên</label>
                        <input type="text" name="customer_name" class="form-control" id="fullname" placeholder="Họ và tên">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="customer_email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Mật khẩu</label>
                        <input type="password" name="customer_password" class="form-control" id="registerPassword" placeholder="Mật khẩu">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" name="customer_phone" class="form-control" id="phone" placeholder="Số điện thoại">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection