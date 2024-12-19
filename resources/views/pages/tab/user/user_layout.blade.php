@extends('layout')
@section('tabcontent')

<div class="container my-5">
    @php
        $customer_name = Session::get('customer_name');
    @endphp
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="custom-sidebar p-3">
                <div class="d-flex align-items-center mb-4">
                    <img src="https://via.placeholder.com/50" alt="User Avatar" class="rounded-circle me-2">
                    <div>
                        <h6 class="mb-0"> {{ $customer_name }}</h6>
                    </div>
                </div>
                <ul class="list-unstyled">
                    <li><a href="{{ URL::to('/edit-user-info') }}" class="d-block py-2">Thay đổi thông tin</a></li>
                    <li><a href="{{ URL::to('/edit-user-password') }}" class="d-block py-2">Đổi Mật Khẩu</a></li>
                </ul>
                <hr>
                <ul class="list-unstyled">
                    <li><a href="{{ URL::to('/logout-checkout') }}" class="d-block py-2">Đăng xuất</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <section class="col-md-9">
            @yield('usercontent')
        </section>
    </div>
</div>


@endsection