@extends('pages.tab.user.user_layout')
@section('usercontent')
    <div class="profile-container">
        <h5 class="mb-4">Hồ Sơ Của Tôi</h5>
        <p class="text-muted">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
        <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<p class="text-danger">' . $message . '</pp>';
                    Session::put('message', null);
                }
                ?>
        <form action="{{ URL::to('/update-user-password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="oldpass" class="form-label">Nhập mật khẩu cũ</label>
                <input type="password" name="current_password" class="form-control" id="oldpass" required>
            </div>
            <div class="mb-3">
                <label for="newpass" class="form-label">Nhập mật khẩu mới</label>
                <input type="password" name="new_password" class="form-control" id="newpass" required>
            </div>
            <div class="mb-3">
                <label for="renewpass" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm_password" class="form-control" id="renewpass" required>
            </div>
            <button type="submit" class="btn btn-save">Lưu</button>
        </form>
    </div>
@endsection