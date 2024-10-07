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

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-nav .nav-link {
            color: #212529 !important;
        }

        .slider img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
        }

        footer {
            background-color: #ffffff;
            padding: 40px 0;
        }

        .footer-section h5 {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .footer-section p,
        .footer-section a {
            color: #212529;
        }

        .footer-section a:hover {
            text-decoration: underline;
        }

        .footer-bottom {
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
            margin-top: 20px;
            font-size: 0.9rem;
        }



        .slick-prev,
        .slick-next {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 50%;
            color: #000;
            font-size: 1.2rem;
            height: 40px;
            width: 40px;
            line-height: 35px;
            text-align: center;
        }

        .slick-next {
            right: -50px;
            transform: translateY(-400%);
            position: relative;
            float: right;

        }

        .slick-prev {
            left: -50px;
            transform: translateY(450%);
            position: relative;
        }

        .slick-prev:hover,
        .slick-next:hover {
            background-color: #dee2e6;
        }

        .slick-dots li {
            position: relative;
            display: inline-block;
            width: 20px;
            height: 20px;
            margin: 0 5px;
            padding: 0;
            cursor: pointer;
        }

        .slick-dots li button {
            font-size: 0;
            line-height: 0;
            display: block;
            width: 20px;
            height: 20px;
            padding: 5px;
            cursor: pointer;
            color: transparent;
            border: 0;
            outline: none;
            background: transparent;
            margin-left: 50%;
        }

        .slick-dots {
            display: flex;
            justify-content: center;
        }

        .slick-dots li button:before {
            content: '•';
            font-size: 30px;
            line-height: 20px;
            position: absolute;
            top: 0;
            width: 20px;
            height: 20px;
            text-align: center;
            opacity: 0.25;
            color: black;
        }

        .slick-dots li.slick-active button:before {
            opacity: 0.75;
            color: black;
        }

        .navbar-brand img {
            width: 150px;
        }

        .slick-slider {
            margin: 0 -15px;
        }

        .slick-slide {
            padding: 10px;
            text-align: center;
            margin-right: 15px;
            margin-left: 15px;
            width: 50vw;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <nav class="navbar navbar-expand-lg navbar-light position-sticky top-0 " style="z-index: 999;">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid p-0">
            <div class="">
                <div class="text-white" style="position: absolute; top: 80%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
                    <h1 class="text-center mb-4">Welcome to New Shop</h1>
                    <p class="text-center">We are a leading company providing the best services for our clients. Our goal is to deliver on-time and quality results.</p>
                </div>
                <div class="mb-2 main-slider" style="height: auto;">
                    <img src="{{ asset('images/product/stefan-stefancik--g7axSVst6Y-unsplash.jpg') }}" class="img-fluid" alt="">
                    <img src="{{ asset('images/product/v2osk-1Z2niiBPg5A-unsplash.jpg') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
        <div class="container">
            <section class="slider-section">
                <h2>Featured Products</h2>
                <div class="slider">
                    <img src="{{ asset('images/product/1722491035_0.jpg') }}" alt="Product 1">
                    <img src="{{ asset('images/product/1722491035_0.jpg') }}" alt="Product 2">
                    <img src="{{ asset('images/product/1722427537_0.jpg') }}" alt="Product 3">
                    <img src="{{ asset('images/product/1722491035_0.jpg') }}" alt="Product 4">
                    <img src="{{ asset('images/product/1722491035_0.jpg') }}" alt="Product 5">
                    <img src="{{ asset('images/product/1722491035_0.jpg') }}" alt="Product 6">
                    <img src="{{ asset('images/product/1722427537_0.jpg') }}" alt="Product 7">
                </div>
            </section>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
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
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="col-md-4 footer-section">
                    <h5>Contact Us</h5>
                    <p>Email: support@mysite.com</p>
                    <p>Phone: +123 456 7890</p>
                    <p>Address: 123 Business Avenue, City, Country</p>
                </div>
            </div>
            <!-- Footer Bottom -->
            <div class="footer-bottom text-center">
                <p>&copy; 2024 New Shop. All rights reserved.</p>
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
