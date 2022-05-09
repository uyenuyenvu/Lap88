<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title')</title>
	<meta name="description" content>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Place favicon.ico in the root directory -->
	<link rel="shortcut icon" type="image/x-icon" href="/frontend/favicon.ico">

	<!-- Ionicons Font CSS-->
    <link rel="stylesheet" href="/frontend/css/ionicons.min.css">
	<!-- font awesome CSS-->
{{--    <link rel="stylesheet" href="/frontend/css/font-awesome.min.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<!-- Animate CSS-->
	<link rel="stylesheet" href="/frontend/css/animate.css">
	<!-- UI CSS-->
	<link rel="stylesheet" href="/frontend/css/jquery-ui.min.css">
	<!-- Chosen CSS-->
	<link rel="stylesheet" href="/frontend/css/chosen.css">
	<!-- Meanmenu CSS-->
	<link rel="stylesheet" href="/frontend/css/meanmenu.min.css">
	<!-- Fancybox CSS-->
	<link rel="stylesheet" href="/frontend/css/jquery.fancybox.css">
	<!-- Normalize CSS-->
	<link rel="stylesheet" href="/frontend/css/normalize.css">
	<!-- Nivo Slider CSS-->
	<link rel="stylesheet" href="/frontend/css/nivo-slider.css">
	<!-- Owl Carousel CSS-->
	<link rel="stylesheet" href="/frontend/css/owl.carousel.min.css">
	<!-- EasyZoom CSS-->
	<link rel="stylesheet" href="/frontend/css/easyzoom.css">
	<!-- Slick CSS-->
	<link rel="stylesheet" href="/frontend/css/slick.css">
	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="/frontend/css/bootstrap.min.css">
{{--	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">--}}

	<!-- Default CSS -->
	<link rel="stylesheet" href="/frontend/css/default.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="/frontend/css/style.css">
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="/frontend/css/responsive.css">
    <link rel="stylesheet" href="/frontend/css/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"/>
	<!-- Modernizr Js -->
	<script src="/frontend/js/modernizr-2.8.3.min.js"></script>
    @yield('script_top')
</head>
<body>
	<div class="wrapper home">
		@include('frontend.includes.header')

		@yield('content')

		@include('frontend.includes.footer')

        @include('sweetalert::alert')
	</div>

    <!--All Js Here-->

	<!--Jquery 1.12.4-->
{{--    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>--}}
	<script src="/frontend/js/jquery-1.12.4.min.js"></script>
	<script src="/frontend/js/popper.min.js"></script>
	<!--Bootstrap-->
	<script src="/frontend/js/bootstrap.min.js"></script>
	<!--Imagesloaded-->
	<script src="/frontend/js/imagesloaded.pkgd.min.js"></script>
	<!--Isotope-->
	<script src="/frontend/js/isotope.pkgd.min.js"></script>
	<!--Ui js-->
	<script src="/frontend/js/jquery-ui.min.js"></script>
	<!--Countdown-->
	<script src="/frontend/js/jquery.countdown.min.js"></script>
	<!--Counterup-->
	<script src="/frontend/js/jquery.counterup.min.js"></script>
	<!--ScrollUp-->
	<script src="/frontend/js/jquery.scrollUp.min.js"></script>
	<!--Chosen js-->
	<script src="/frontend/js/chosen.jquery.js"></script>
	<!--Meanmenu js-->
	<script src="/frontend/js/jquery.meanmenu.min.js"></script>
	<!--Instafeed-->
	<script src="/frontend/js/instafeed.min.js"></script>
	<!--EasyZoom-->
	<script src="/frontend/js/easyzoom.min.js"></script>
	<!--Fancybox-->
	<script src="/frontend/js/jquery.fancybox.pack.js"></script>
	<!--Nivo Slider-->
	<script src="/frontend/js/jquery.nivo.slider.js"></script>
	<!--Waypoints-->
	<script src="/frontend/js/waypoints.min.js"></script>
	<!--Carousel-->
	<script src="/frontend/js/owl.carousel.min.js"></script>
	<!--Slick-->
	<script src="/frontend/js/slick.min.js"></script>
	<!--Wow-->
	<script src="/frontend/js/wow.min.js"></script>
	<!--Plugins-->
	<script src="/frontend/js/plugins.js"></script>
	<!--Main Js-->
{{--	<script src="/frontend/js/main.js"></script>--}}
	<script src="/frontend/js/mean.js"></script>

    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "108402824832712");
        chatbox.setAttribute("attribution", "biz_inbox");
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v11.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
</body>
</html>
