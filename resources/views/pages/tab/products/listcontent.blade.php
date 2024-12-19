<main class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3 mb-4">
            <!-- Product Categories -->
            <div class="category-products bg-light p-3 rounded mb-4">
                <h5 class="font-weight-bold">Danh mục sản phẩm</h5>
                <ul class="list-unstyled ">
                    <li>
                        <!--category-productsr-->
                        @foreach ($category as $key => $cate)
                            <a
                                href="{{ URL::to('/danh-muc-san-pham/' . $cate->category_id) }}">{{ $cate->category_name }}</a>
                            <br>
                        @endforeach

                    </li>
                </ul>
            </div>

            <!-- Product Filters -->
            <div class="brands_products bg-light p-3 rounded">
                <h5 class="font-weight-bold">Thương hiệu sản phẩm</h5>
                <ul class="list-unstyled">
                    <li>
                        @foreach ($brand as $key => $brand)
                    <li>
                        <a href="{{ URL::to('/thuong-hieu-san-pham/' . $brand->brand_id) }}"> <span
                                class="pull-right"></span>{{ $brand->brand_name }}</a>
                    </li>
                    @endforeach
                    </li>
                </ul>
            </div>
            
        </aside>

        <!-- Product List -->
        <section class="col-md-9">
            @yield('contentproduct')
        </section>


    </div>

</main>