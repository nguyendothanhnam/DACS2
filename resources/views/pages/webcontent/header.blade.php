<div class="top-bar bg-dark text-white py-1">
    <div class="container d-flex justify-content-end align-items-center">
        @php
        $customer_id = Session::get('customer_id');
        $customer_name = Session::get('customer_name');
        @endphp
        @if($customer_id != NULL)
        <span class="text-white mx-2"><b class="text-warning">Xin chào:</b><a href="{{ URL::to('/edit-user-info') }}"> {{ $customer_name }}</a></span>
        @else
        <a href="{{ URL::to('/login-checkout') }}" class="text-white mx-2">Đăng nhập</a>
        <a href="{{ URL::to('/login-checkout') }}" class="text-white mx-2">Đăng ký</a>
        @endif
    </div>
</div>
{{-- form login --}}
{{-- @include('pages.login.login-modal') --}}
{{-- form register --}}
{{-- @include('pages.register.register-modal') --}}

<!-- Header Section with Responsive Navigation -->
<header class="bg-dark text-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark position-relative">
            <!-- Logo -->
            <a class="navbar-brand text-warning font-weight-bold" href="{{ URL::to('/trang-chu') }}">WibuLap</a>
                    <div class="d-flex order-lg-2 ml-auto custom-navbar">
                        <!-- Hamburger Menu for Mobile -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <!-- Cart Button -->
                        <a href="{{ URL::to('/show-cart') }}" class="btn btn-warning cart-button">🛒 <span class="cart-text">Giỏ hàng</span></a>
                    </div>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ URL::to('/about') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ URL::to('/san-pham') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ URL::to('/contact') }}">Liên hệ</a>
                    </li>
                </ul>
            </div>
            <div class="box">
                <form action="{{ URL::to('/tim-kiem') }}" method="POST" id="searchForm">
                    @csrf
                <input type="text" name="keywords_submit" placeholder="Search">
                <a>
                    <i class="fa fa-search" id="searchButton"></i>
                </a>
                </form>
            </div>

        </nav>
    </div>
</header>