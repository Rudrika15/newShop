@extends('visitor.layouts.app')
@section('title', 'About')
@section('content')
    <nav aria-label="breadcrumb" style="background-color: #1582d4;height: 100px; padding-top: 35px ;padding-left:40%">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-light">Home</a></li>
            <li class="breadcrumb-item " class="text-light" aria-current="page">About</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row py-5">

            <div class="col-12">
                <h1>About us</h1>
                <p>
                    Welcome to MJ Dream, your ultimate destination for exquisite sharees that blend tradition with
                    contemporary elegance. Our passion for the rich heritage of Indian textiles drives us to curate a
                    stunning collection that caters to every occasion, from weddings to festivals and everyday wear.
                </p>

                <h4>Our Journey</h4>
                <p>

                    Founded with a vision to celebrate the artistry of sharee craftsmanship, MJ Dream has quickly become a
                    beloved name in the fashion community. Our journey began with a deep appreciation for the intricate
                    designs, vibrant colors, and luxurious fabrics that sharees embody. We believe that every sharee tells a
                    story, and we strive to help you find the perfect one that resonates with your personal style.
                </p>
                <h4>Our Collection</h4>
                <p>

                    At MJ Dream, we offer a diverse range of sharees, featuring traditional handwoven pieces, modern
                    interpretations, and everything in between. Each sharee in our collection is carefully selected for its
                    quality, uniqueness, and style. Whether you're looking for something classic or trendy, we have the
                    perfect piece to enhance your wardrobe.
                </p>
                <h4>Our Commitment</h4>
                <p>

                    Customer satisfaction is at the heart of what we do. Our dedicated team is here to provide personalized
                    service, ensuring that your shopping experience is seamless and enjoyable. We take pride in offering
                    high-quality products at competitive prices, and we are committed to sustainability and ethical
                    practices throughout our supply chain.
                </p>
                <h4>Join Us</h4>
                <p>

                    We invite you to explore our collection and discover the beauty of sharees that make you feel confident
                    and radiant. Whether you're dressing for a special occasion or looking to elevate your everyday style,
                    MJ Dream is here to help you express yourself.

                    Thank you for choosing MJ Dream. We look forward to being a part of your fashion journey!

                </p>
            </div>
        </div>

    </div>
@endsection
