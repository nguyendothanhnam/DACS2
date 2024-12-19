<main class="container my-5">
    <h2 class="carousel-title">SẢN PHẨM CỦA TRANG WEB</h2>
    <div id="carouselExampleControls1" class="carousel">
        <div class="carousel-inner">
            @foreach ($all_product as $key => $product)
                <div class="carousel-item">
                    <div class="card">
                        <a href="{{ asset('/chi-tiet-san-pham/' . $product->product_id) }}">
                            <div class="img-wrapper"><img
                                    src="{{ asset('public/uploads/product/' . $product->product_image) }}"
                                    class="d-block w-100" alt="..."> </div>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">{{ number_format((float) $product->product_price) . ' ' . 'VND' }}</p>
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

<main class="container my-5">
    <h2 class="carousel-title">LAP TOP GAMING</h2>
    <div id="carouselExampleControls2" class="carousel">
        <div class="carousel-inner">
            @foreach ($gaming_product as $key => $product)
                <div class="carousel-item">
                    <div class="card">
                        <a href="{{ asset('/chi-tiet-san-pham/' . $product->product_id) }}">
                            <div class="img-wrapper"><img
                                    src="{{ asset('public/uploads/product/' . $product->product_image) }}"
                                    class="d-block w-100" alt="..."> </div>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">{{ number_format((float) $product->product_price) . ' ' . 'VND' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls2"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls2"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</main>
<main class="container my-5">
    <h2 class="carousel-title">LAP TOP VĂN PHÒNG</h2>
    <div id="carouselExampleControls3" class="carousel">
        <div class="carousel-inner">
            @foreach ($office_product as $key => $product)
                <div class="carousel-item">
                    <div class="card">
                        <a href="{{ asset('/chi-tiet-san-pham/' . $product->product_id) }}">
                            <div class="img-wrapper"><img
                                    src="{{ asset('public/uploads/product/' . $product->product_image) }}"
                                    class="d-block w-100" alt="..."> </div>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">{{ number_format((float) $product->product_price) . ' ' . 'VND' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls3"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls3"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</main>

