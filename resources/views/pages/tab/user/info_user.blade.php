@extends('pages.tab.user.user_layout')
@section('usercontent')
    <div class="profile-container">
        <h5 class="mb-4">Hồ Sơ Của Tôi</h5>
        <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<p class="text-danger">' . $message . '</pp>';
                    Session::put('message', null);
                }
                ?>
        <form action="{{ URL::to('/update-user-info') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="gmail" class="form-label">Gmail</label>
                <input type="text" name="customer_email" class="form-control" id="gmail" 
                       value="{{ $customer_info->customer_email }}">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" name="customer_name" class="form-control" id="name" 
                       value="{{ $customer_info->customer_name }}">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" name="customer_phone" class="form-control" id="phone" 
                       value="{{ $customer_info->customer_phone }}">
            </div>
            <button type="submit" class="btn btn-save">Lưu</button>
        </form>
    </div>
@endsection