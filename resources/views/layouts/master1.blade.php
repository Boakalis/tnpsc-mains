<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BizConsult - Consulting HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/homepage/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/homepage/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/homepage/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/homepage/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/homepage/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="index.html" class="navbar-brand p-0">
                    <h1 class="m-0">TNPSC MAINS</h1>
                    <!-- <img src="/homepage/img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="index.html" class="nav-item nav-link active">Login</a>
                    </div>
                    <a href="" class="btn btn-light rounded-pill text-primary py-2 px-4 ms-lg-5">Register</a>
                </div>
            </nav>

            <div class="container-xxl bg-primary hero-header">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated zoomIn">We Help To Push Your Business To The Top Level</h1>
                            <p class="text-white pb-3 animated zoomIn">Tempor rebum no at dolore lorem clita rebum rebum ipsum rebum stet dolor sed justo kasd. Ut dolor sed magna dolor sea diam. Sit diam sit justo amet ipsum vero ipsum clita lorem</p>
                            <a href="" class="btn btn-outline-light rounded-pill border-2 py-3 px-5 animated slideInRight">Learn More</a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img class="img-fluid animated zoomIn" src="/homepage/img/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
        @include('includes.about')
        <!-- About End -->



        <!-- Service Start -->
        @include('includes.service')
        <!-- Service End -->


        <!-- Features Start -->
        @include('includes.feature')
        <!-- Features End -->


        <!-- Client Start -->
        {{-- <div class="container-xxl bg-primary my-6 py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="owl-carousel client-carousel">
                    <a href="#"><img class="img-fluid" src="/homepage/img/logo-1.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="/homepage/img/logo-2.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="/homepage/img/logo-3.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="/homepage/img/logo-4.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="/homepage/img/logo-5.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="/homepage/img/logo-6.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="/homepage/img/logo-7.png" alt=""></a>
                    <a href="#"><img class="img-fluid" src="/homepage/img/logo-8.png" alt=""></a>
                </div>
            </div>
        </div> --}}
        <!-- Client End -->


        <!-- Testimonial Start -->
        @include('includes.testimonials')
        <!-- Testimonial End -->


        <!-- Team Start -->
        @include('includes.team')
        <!-- Team End -->


        <!-- Footer Start -->
        @include('layouts.footer1')
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/homepage/lib/wow/wow.min.js"></script>
    <script src="/homepage/lib/easing/easing.min.js"></script>
    <script src="/homepage/lib/waypoints/waypoints.min.js"></script>
    <script src="/homepage/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="/homepage/js/main.js"></script>
</body>

</html>
