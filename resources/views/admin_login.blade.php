<!DOCTYPE html>

<head>
    <title>Trang quản lý Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

    <link href="{{ asset('backend/css/style-responsive.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('backend/css/SlideStyle.css') }}" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wgth@500&display=swap">
    <script src="{{ asset('backend/js/jquery2.0.3.min.js') }}"></script>
</head>

<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <label for="chk" aria-hidden="true">Sign up</label>
                @if (Session::has('register_message'))
                    <div class="alert alert-success">
                        {{ Session::get('register_message') }}
                    </div>
                @endif

                <input type="text" name="admin_name" placeholder="Username" required="">
                <input type="email" name="admin_email" placeholder="Email" required="">
                <input type="tel" name="admin_phone" placeholder="Phone Number" required="">
                <input type="password" name="admin_password" placeholder="Password" required="">
                <button>Sign up</button>
            </form>
        </div>
        <div class="login">
            <form action="{{ URL::to('/admin-dashboard') }}" method="post">
                <label for="chk" aria-hidden="true">Login</label>
                @if (Session::has('login_message'))
                    <span class="text-alert">{{ Session::get('login_message') }}</span>
                @endif
                {{ csrf_field() }}
                <input type="email" name="admin_email" placeholder="Email" required="">
                <input type="password" name="admin_password" placeholder="Password" required="">
                <button>Login</button>
            </form>
        </div>


        <script src="{{ asset('backend/js/bootstrap.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.dcjqaccordion.2.7.js') }}"></script>
        <script src="{{ asset('backend/js/scripts.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script>
        <!--[if lte IE asset8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
        <script src="{{ asset(' backend/js/jquery.scrollTo.js') }}"></script>
</body>

</html>
