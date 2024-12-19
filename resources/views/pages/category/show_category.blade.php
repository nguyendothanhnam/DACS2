@extends('pages.tab.products.producttab')
@section('contentproduct')
    <div class="product-sections">
        @foreach ($category_name as $key => $name)
        <h2 class="mb-4">{{ $name->category_name }}</h2>
        @endforeach
        <div class="row g-2">
            @foreach ($category_by_id as $key => $product)
                <div class="col-6 col-md-4 mb-2">
                    <div class="card">
                        <a href="{{ asset('/chi-tiet-san-pham/' . $product->product_id) }}">
                        <img src="{{ asset('public/uploads/product/'.$product->product_image) }}" class="card-img-top fixed-size-img" alt="">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">{{ number_format((float)$product->product_price).' '.'VND' }}</p>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $category_by_id->links() }}
        </div>
        {{-- viết 1 div ghi nội dung giới thiệu về category --}}
        

    </div>
    <div class="content-card">
        <h2 class="fw-bold">Thông tin doanh mục</h2> 
        @foreach ($category_desc as $key => $desc)
        <div class="description">
            <!-- Content same as before -->
            <p>{!! $desc->category_desc !!}</p>
        </div>
        @endforeach
    </div>
@endsection
