@extends('pages.tab.products.producttab')
@section('contentproduct')

    <div class="product-sections">
        <h2 class="mb-4">KẾT QUẢ TÌM KIẾM</h2>
        <div class="row g-2">
            @if ($search_product->isEmpty())
            <div class="col-12">
                <p class="text-center">Không có sản phẩm phù hợp với từ khóa tìm kiếm của bạn.</p>
            </div>
        @else
            @foreach ($search_product as $key => $product)
                <div class="col-6 col-md-4 mb-2">
                    <div class="card">
                        <img src="{{ asset('public/uploads/product/' . $product->product_image) }}"
                            class="card-img-top fixed-size-img" alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">{{ number_format((float) $product->product_price) . ' ' . 'VND' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        </div>
        <div class="d-flex justify-content-center" style="margin-top: 20px;">
            {{ $search_product->links() }}
        </div>
    </div>
@endsection
