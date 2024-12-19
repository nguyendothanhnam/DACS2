<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WibuLap</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />


    <!-- Custom CSS -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>LapWibu</title>

    <link rel="stylesheet" href="{{ asset('./frontend/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('./frontend/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>


    @include('pages.webcontent.header')
    <!-- slide -->
    <section>
        @yield('tabcontent')
    </section>
    <!-- Footer Section -->
    @include('pages.webcontent.footer')




    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script src="{{ asset('./frontend/js/main.js') }}"></script>

    {{-- Search --}}
    <script>
        $('#searchButton').click(function() {
            $('#searchForm').submit();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('toggle-btn');
            const desc = document.querySelector('.product-description');

            btn.addEventListener('click', function() {
                desc.classList.toggle('show');
                btn.textContent = desc.classList.contains('show') ? 'Thu gọn' : 'Xem thêm';
            });
        });
    </script>

    <script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script>
    <link href="{{ asset('frontend/css/sweetalert.css') }}" rel="stylesheet">
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();

                console.log({
                    cart_product_id,
                    cart_product_name,
                    cart_product_image,
                    cart_product_price,
                    cart_product_qty
                });

                $.ajax({
                    url: '{{ URL::to('/add-cart-ajax') }}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                        cart_product_qty: cart_product_qty,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        swal({
                                title: "Đã thêm sản phẩm vào giỏ hàng",
                                text: "Bạn có thể mua tiếp hoặc tới giỏ hàng để thanh toán",
                                showCancelButton: true,
                                cancelButtonText: "Xem tiếp",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Đi tới giỏ hàng",
                                closeOnConfirm: false
                            },
                            function() {
                                window.location.href = "{{ URL::to('/gio-hang') }}";
                            });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".choose").on('change', function() {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{ url('/select-delivery-home') }}',
                    method: "POST",
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.calculate_delivery').click(function() {
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                console.log(matp, maqh, xaid);
                var _token = $('input[name="_token"]').val();
                if (matp == '' && maqh == '' && xaid == '') {
                    alert('Bạn phải chọn đầy đủ thông tin');
                } else {
                    $.ajax({
                        url: '{{ url('/calculate-fee') }}',
                        method: "POST",
                        data: {
                            matp: matp,
                            maqh: maqh,
                            xaid: xaid,
                            _token: _token
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.send_order').click(function() {
                swal({
                        title: "Xác nhận đơn hàng",
                        text: "Đơn hàng sẽ không được hoàn trả khi đặt, bạn có chắc chắn muốn đặt hàng không?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Có, mua hàng",
                        cancelButtonText: "Không, cảm ơn",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {

                            var id = $(this).data('id_product');
                            var shipping_email = $('.shipping_email').val();
                            var shipping_name = $('.shipping_name').val();
                            var shipping_address = $('.shipping_address').val();
                            var shipping_phone = $('.shipping_phone').val();
                            var shipping_notes = $('.shipping_notes').val();
                            var shipping_method = $('.payment_select').val();
                            var order_fee = $('.order_fee').val();
                            var order_coupon = $('.order_coupon').val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: '{{ url('/confirm-order') }}',
                                method: 'POST',
                                data: {
                                    shipping_email: shipping_email,
                                    shipping_name: shipping_name,
                                    shipping_address: shipping_address,
                                    shipping_phone: shipping_phone,
                                    shipping_notes: shipping_notes,
                                    order_fee: order_fee,
                                    order_coupon: order_coupon,
                                    shipping_method: shipping_method,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function() {
                                    swal("Đơn hàng", "Đơn hàng được gửi thành công",
                                        "success");
                                }
                            });
                            window.setTimeout(function() {
                                location.reload();
                            }, 3000);

                        } else {
                            swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");
                        }

                    });
            });
        });
    </script>
</body>

</html>
