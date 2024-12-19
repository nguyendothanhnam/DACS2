@extends('layout')
@section('tabcontent')
    <!-- Main Content Section -->
    @foreach ($product_details as $key => $value)
        <div class="container mt-5">
            <div class="product-card">
                <div class="row g-0">
                    <!-- Hình ảnh sản phẩm -->
                    <div class="col-md-4">
                        <img src="{{ asset('/public/uploads/product/' . $value->product_image) }}" alt="Product Image">
                    </div>
                    <!-- Nội dung sản phẩm -->
                    <div class="col-md-8">
                        <div class="p-3">
                            <form action="{{ URL::to('/save-card') }}" method="POST">
                                @csrf

                                <input type="hidden" class="cart_product_id_{{ $value ->product_id }}" value="{{ $value -> product_id }}">
                                <input type="hidden" class="cart_product_name_{{ $value ->product_id }}" value="{{ $value -> product_name }}">
                                <input type="hidden" class="cart_product_image_{{ $value ->product_id }}" value="{{ $value -> product_image }}">
                                <input type="hidden" class="cart_product_price_{{ $value ->product_id }}" value="{{ $value -> product_price }}">
                                <input type="hidden" class="cart_product_qty_{{ $value ->product_id }}" value="1">

                                <h2 class="fw-bold">{{ $value->product_name }}</h2>
                                <ul class="list-unstyled mb-3">
                                    <li><b>Mã sản phẩm:</b> {{ $value->product_id }}</li>
                                    <li><b>Thương hiệu:</b> {{ $value->brand_name }}</li>
                                    <li><b>Doanh mục:</b> {{ $value->category_name }}</li>
                                    <li>{!! $value->product_desc !!}</li>
                                </ul>
                                <p class="price">{{ number_format($value->product_price, 0, ',', '.') . 'VND' }}</p>
                                <p class="market-price"></p>


                                <!-- Chọn số lượng -->
                                <div class="d-flex align-items-center mb-3">
                                    <label for="qty" class="me-2">Số lượng:</label>
                                    <input id="qty_{{ $value->product_id }}" name="qty" type="number" class="form-control quantity-input"
                                        min="1" value="1">
                                </div> 

                                <!-- Nút hành động -->
                                <div class="d-flex gap-2">
                                    <button class="btn btn-success w-50 add-to-cart" name="add-to-cart"value type="button" data-id_product="{{ $value ->product_id }}">Thêm vào giỏ hàng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <main class="container my-5">
        <div class="content-card">
            <h2 class="fw-bold">Giới thiệu sản phẩm</h2>
            <div class="product-description">
                <!-- Content same as before -->
                <p>{!! $value->product_content !!}</p>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button id="toggle-btn" class="btn btn-primary btn-toggle">Xem thêm</button>
            </div>
        </div>
    </main>

    <main class="container my-5">
        <h2 class="carousel-title">Sản phẩm liên quan</h2>
        <div id="carouselExampleControls1" class="carousel">
            <div class="carousel-inner">
                @foreach ($relate as $key => $lienquan)
                    <div class="carousel-item">
                        <form >
                            @csrf
                            <input type="hidden" value="{{ $lienquan->product_id }}" class="cart_product_id_{{ $lienquan->product_id }}">
                            <input type="hidden" value="{{ $lienquan->product_name }}" class="cart_product_name_{{ $lienquan->product_id }}">
                            <input type="hidden" value="{{ $lienquan->product_image }}" class="cart_product_image_{{ $lienquan->product_id }}">
                            <input type="hidden" value="{{ $lienquan->product_price }}" class="cart_product_price_{{ $lienquan->product_id }}">
                            <input type="hidden" value="1" class="cart_product_qty_{{ $lienquan->product_id }}">
                            
                        </form>
                        <div class="card">
                            <a href="{{ asset('/chi-tiet-san-pham/' . $lienquan->product_id) }}">
                                <div class="img-wrapper"><img
                                        src="{{ asset('public/uploads/product/' . $lienquan->product_image) }}"
                                        class="d-block w-100" alt="..."> </div>
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $lienquan->product_name }}</h5>
                                <p class="card-text">{{ number_format((float) $lienquan->product_price) . ' ' . 'VND' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls1"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls1"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </main>
@endsection

