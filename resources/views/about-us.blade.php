<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>TNPSC Mains | Online Practice and Evaluation Platform for TNPSC</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="/orange-book.png">

    <!-- CSS here -->
    <link rel="stylesheet" href="/frontend/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/frontend/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/frontend/assets/css/slicknav.css">
    <link rel="stylesheet" href="/frontend/assets/css/flaticon.css">
    <link rel="stylesheet" href="/frontend/assets/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="/frontend/assets/css/gijgo.css">
    <link rel="stylesheet" href="/frontend/assets/css/animate.min.css">
    <link rel="stylesheet" href="/frontend/assets/css/animated-headline.css">
    <link rel="stylesheet" href="/frontend/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/frontend/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="/frontend/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/frontend/assets/css/slick.css">
    <link rel="stylesheet" href="/frontend/assets/css/nice-select.css">
    <link rel="stylesheet" href="/frontend/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="/frontend/assets/img/logo/loder.png" alt=""><br />
                    <p style="font-size: 10px;" class="">Please Wait</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparent">
            <div class="main-header ">
                <div class="header-bottom  header-sticky">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-3 col-lg-3">
                                <div class="logo">
                                    <a href="index.html"><img style="height:40px;" src="/orange-book.png"
                                            alt="">
                                            {{-- <span class="hero_caption"
                                            style="font-size:25px;font-weight:900"> TNPSC Mains</span> --}}
                                        </a>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9">
                                <div class="menu-wrapper d-flex align-items-center justify-content-end">
                                    <!-- Main-menu -->
                                    <div class="main-menu d-none d-lg-block">
                                        <nav>
                                            <ul id="navigation">
                                                <li class="  active"><a class="py-4" href="{{route('home')}}">Home</a></li>
                                                <li><a class="py-4" href="/exams">Courses</a></li>
                                                <li><a class="py-4" href="{{route('about')}}">About</a></li>
                                                <li><a class="py-4" href="{{route('contact')}}">Contact</a></li>
                                                <!-- Button -->
                                                {{-- <li class="button-header margin-left "><a href="#"
                                                        class="btn">Join</a></li>
                                                <li class="button-header"><a href="login.html" class="btn btn3">Log
                                                        in</a></li> --}}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
        <!--? slider Area Start-->
        <section class="slider-area slider-area2">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-height2">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-11 col-md-12">
                                <div class="hero__caption hero__caption2">
                                    <h1 data-animation="bounceIn" data-delay="0.2s">About us</h1>
                                    <!-- breadcrumb Start-->
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                            <li class="breadcrumb-item"><a href="javascript:void(0)">About-us</a></li>
                                        </ol>
                                    </nav>
                                    <!-- breadcrumb End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--?  Contact Area start  -->
        <section class="contact-section">
            <div class="container">
                {!!@$data->about!!}

            </div>
        </section>
        <!-- Contact Area End -->
    </main>
    <footer>
        <div class="footer-wrappper footer-bg">
            <!-- Footer Start-->

            <!-- footer-bottom area -->
            <div class="footer-bottom-area">
                <div class="container">
                    <div class="footer-border py-3">
                        <div class="row d-flex align-items-center">
                            <div class="col-xl-12 ">
                                <div class="footer-copy-right text-center">
                                    <p class="mb-0">
                                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                        &copy;
                                        2022 TNPSCMains All rights reserved
                                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </div>
    </footer>
    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!-- JS here -->
    <script src="/frontend/assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="/frontend/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="/frontend/assets/js/popper.min.js"></script>
    <script src="/frontend/assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="/frontend/assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="/frontend/assets/js/owl.carousel.min.js"></script>
    <script src="/frontend/assets/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="/frontend/assets/js/wow.min.js"></script>
    <script src="/frontend/assets/js/animated.headline.js"></script>
    <script src="/frontend/assets/js/jquery.magnific-popup.js"></script>

    <!-- Date Picker -->
    <script src="/frontend/assets/js/gijgo.min.js"></script>
    <!-- Nice-select, sticky -->
    <script src="/frontend/assets/js/jquery.nice-select.min.js"></script>
    <script src="/frontend/assets/js/jquery.sticky.js"></script>
    <!-- Progress -->
    <script src="/frontend/assets/js/jquery.barfiller.js"></script>

    <!-- counter , waypoint,Hover Direction -->
    <script src="/frontend/assets/js/jquery.counterup.min.js"></script>
    <script src="/frontend/assets/js/waypoints.min.js"></script>
    <script src="/frontend/assets/js/jquery.countdown.min.js"></script>
    <script src="/frontend/assets/js/hover-direction-snake.min.js"></script>

    <!-- contact js -->
    <script src="/frontend/assets/js/contact.js"></script>
    <script src="/frontend/assets/js/jquery.form.js"></script>
    <script src="/frontend/assets/js/jquery.validate.min.js"></script>
    <script src="/frontend/assets/js/mail-script.js"></script>
    <script src="/frontend/assets/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="/frontend/assets/js/plugins.js"></script>
    <script src="/frontend/assets/js/main.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            toastr.options = {
                "closeButton": false,
                "debug": true,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
    });
</script>
</body>

</html>
