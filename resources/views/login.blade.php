<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Monitoring Jaringan')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets//css/responsive.css') }}">
</head>

<body>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Sign in Start -->
    <section class="sign-in-page">
        <div class="container p-0" id="sign-in-page-box">
            <!-- <div class="bg-white form-container sign-up-container">
                <div class="sign-in-page-data">
                    <div class="sign-in-from w-100 m-auto">
                        <h1 class="mb-3 text-center">Sign Up</h1>
                        <form class="mt-4" method="post" action="{{ route('login') }}">

                            <div class="form-group">
                                <label for="exampleInputEmail2"></label>
                                <input type="username" class="form-control mb-0" id="exampleInputEmail2" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control mb-0" id="exampleInputPassword1" placeholder="Password">
                            </div>

                            <div class="sign-info">
                                <button type="submit" class="btn btn-primary mb-2">Login</button>
                                <span class="text-dark d-block line-height-2">Already Have Account ? <a href="#">Log In</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
            <div class="bg-white form-container sign-in-container">
                <div class="sign-in-page-data">
                    <div class="sign-in-from w-100 m-auto">
                        <h1 class="mb-3 text-center">Sign in</h1>
                        <form class="mt-4" method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail2">Username</label>
                                <input type="text" class="form-control mb-0" name="username" id="exampleInputEmail2" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Password</label>
                                <input type="password" class="form-control mb-0" name="password" id="exampleInputPassword2" placeholder="Password">
                            </div>
                            
                            <div class="sign-info">
                                <button type="submit" class="btn btn-primary mb-2">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <a class="sign-in-logo mb-5" href="#"><img src="images/logo-full.png" class="img-fluid" alt="logo"></a>
                        <p>To Keep connected with us please login with your personal info</p>
                        <button class="btn iq-border-primary mt-2" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <a class="sign-in-logo mb-5" href="#"><img src="images/logo-full.png" class="img-fluid" alt="logo"></a>
                        <p>Enter your personal details and start journey with us</p>
                        <button class="btn iq-border-primary mt-2" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- color-customizer END -->
    <!-- Optional JavaScript -->
    <!-- JavaScript Assets -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- Appear JavaScript -->
    <script src="{{ asset('assets/js/jquery.appear.js') }}"></script>

    <!-- Countdown JavaScript -->
    <script src="{{ asset('assets/js/countdown.min.js') }}"></script>

    <!-- Counterup JavaScript -->
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>

    <!-- Wow JavaScript -->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>

    <!-- Apexcharts JavaScript -->
    <script src="{{ asset('assets/js/apexcharts.js') }}"></script>

    <!-- Slick JavaScript -->
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>

    <!-- Select2 JavaScript -->
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <!-- Owl Carousel JavaScript -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>

    <!-- Magnific Popup JavaScript -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>

    <!-- Smooth Scrollbar JavaScript -->
    <script src="{{ asset('assets/js/smooth-scrollbar.js') }}"></script>

    <!-- Lottie JavaScript -->
    <script src="{{ asset('assets/js/lottie.js') }}"></script>

    <!-- AmCharts JavaScript -->
    <script src="{{ asset('assets/js/core.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/animated.js') }}"></script>
    <script src="{{ asset('assets/js/kelly.js') }}"></script>
    <script src="{{ asset('assets/js/maps.js') }}"></script>
    <script src="{{ asset('assets/js/worldLow.js') }}"></script>

    <!-- Raphael-min JavaScript -->
    <script src="{{ asset('assets/js/raphael-min.js') }}"></script>

    <!-- Morris JavaScript -->
    <script src="{{ asset('assets/js/morris.js') }}"></script>
    <script src="{{ asset('assets/js/morris.min.js') }}"></script>

    <!-- Flatpicker Js -->
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>

    <!-- Style Customizer -->
    <script src="{{ asset('assets/js/style-customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('assets/js/chart-custom.js') }}"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

</body>

</html>