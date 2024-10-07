<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Shop</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body>

    <!-- Header Section -->
    <nav class="navbar navbar-expand-lg navbar-light position-sticky top-0 bg-white" style="z-index: 999;">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" style="height: 40px" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product') }}">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')
    <!-- Footer Section -->
    <footer style="background-color: #f8f9fa " class="py-5">
        <div class="container">
            <div class="row">
                <!-- About Us Section -->
                <div class="col-md-4 footer-section">
                    <h5>About Us</h5>
                    <p>We are a leading company providing the best services for our clients. Our goal is to deliver
                        on-time and quality results.</p>
                </div>

                <!-- Useful Links Section -->
                <div class="col-md-4 footer-section">
                    <h5>Useful Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/refund">Refund </a></li>
                        <li><a href="/policy">Privacy Policy</a></li>
                        <li><a href="/terms">Terms and Conditions</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="col-md-4 footer-section">
                    <h5>Contact Us</h5>
                    <p>Email: msthetrendushaben@gmail.com
                    </p>
                    <p>Phone: 8866 232839
                    </p>
                    <p>Address: m j dreams
                        <br>
                        opp.ajay arcade,
                        <br>
                        Jawahar Road,
                        <br>
                        Surendranagar 363001
                    </p>
                </div>
            </div>
            <!-- Footer Bottom -->
            <div class="footer-bottom ">
                <div class="d-flex justify-content-between">
                    <p>&copy; <?php print $date = date('Y'); ?> m j dreams. All rights reserved.</p>
                    <p>Developed by <a href="https://flipcodesolutions.com" target="_blank">Flipcode solutions</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery and Slick Carousel JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script>
        // Initialize the slider
        $('.slider').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: true,
            initialSlide: 1,
            prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
            dots: true,
            dotsClass: 'slick-dots',
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false
                    }
                }
            ]
        });

        $('.main-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            dots: true,
            dotsClass: 'slick-dots',
            fade: true,
            cssEase: 'linear',
            varuableWidth: true,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false
                    }
                }
            ]
        });
    </script>

</body>

</html>
