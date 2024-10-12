@extends('visitor.layouts.app')


@section('title', 'Product Details')
@section('content')

    <style>
        body {
            font-family: sans-serif;
        }

        header {
            height: 15vh;
            width: 100%;
            background: lightgray;
            margin-bottom: 50px;
        }

        #product-info {
            display: flex;
            width: 82%;
            margin: 0 auto;
        }

        .item-image-parent {
            order: 1;
            width: 50%;
            display: flex;
        }

        .item-info-parent {
            order: 2;
            /* width: 50%; */
            display: flex;
            flex-direction: column;
        }

        .item-list-vertical {
            order: 1;
            width: 10%;
            overflow-y: auto;
            margin-top: 38px;
        }

        .item-image-main {
            order: 2;
            width: 90%;
            height: 100%;
        }

        .thumb-box {
            width: 75%;
            margin: 10px auto;
            background: white;
            border: 1px solid gray;
        }

        .thumb-box img {
            width: 100%;
            height: 100%;
        }

        .item-image-main img {
            width: 100%;
            height: auto;
        }

        .thumb-box:hover {
            cursor: pointer;
            border-color: #e77600;
            box-shadow: 0px 1px 5px 1px #e77600;
        }

        .main-info h4 {
            font-size: 21px;
            margin-bottom: 0;
            font-weight: 400;
        }

        .star-rating {
            width: 70%;
            color: gray;
            font-size: 24px;
            border-bottom: 0.4px solid rgba(194, 194, 194, 0.829);
        }

        .star-rating span {
            color: gold;
        }

        .main-info p {
            font-size: 15px;
            color: gray;
            margin-bottom: 30px;
        }

        #price {
            color: rgb(168, 14, 14);
            font-size: 21px;
        }

        .change-color {
            margin-bottom: 10px;
        }

        .change-color .thumb-box {
            /* margin: 10px 10px 10px 0;
                                                                                                                                        width: 40px;
                                                                                                                                        display: inline-block; */
            padding: 5px 10px;
            border-radius: 4px;
            border-color: rgb(189, 189, 189);
            margin-top: 10px;
        }

        .change-size select {
            padding: 5px 10px;
            border-radius: 4px;
            border-color: rgb(189, 189, 189);
            margin-top: 10px;
        }

        .description ul {
            padding-left: 17px;
            font-size: 15px;
            line-height: 1.3rem;
        }
    </style>

    <nav aria-label="breadcrumb" style="background-color: #1582d4;height: 100px; padding-top: 35px ;padding-left:40%">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-light">Home</a></li>
            <li class="breadcrumb-item" class="text-light" aria-current="page">Product Detail</li>
        </ol>
    </nav>

    <div class="container-fluid my-5">
        <div class="row">
            <section id="product-info">

                <!-- Main image and thumbnails -->
                <div class="item-image-parent">
                    <!-- Thumbnail images from the Product table -->
                    <div class="item-list-vertical">
                        @foreach ($products as $product)
                            <div class="thumb-box">
                                <img src="{{ asset('images/product/' . $product->image) }}" alt="thumbnail_image"
                                    onclick="updateMainImage('{{ asset('images/product/' . $product->image) }}')" />
                            </div>
                        @endforeach
                        <div class="thumb-box">
                            <img src="{{ asset('images/catalog/' . $catalogs->main_image) }}" alt="{{ $catalogs->title }}"
                                onclick="updateMainImage('{{ asset('images/catalog/' . $catalogs->main_image) }}')" />
                        </div>
                    </div>

                    <!-- Main catalog image from the Catalog table -->
                    <div class="item-image-main mt-5" style="max-width: 500px; ">
                        <img id="mainImage" src="{{ asset('images/catalog/' . $catalogs->main_image) }}"
                            alt="{{ $catalogs->title }}" />
                    </div>
                </div>

                <!-- Product info section -->
                <div class="item-info-parent " style="padding-left: 20px">
                    <!-- Main info -->
                    <div class="main-info mt-5">
                        <h4>{{ $catalogs->title }}</h4>
                        <div class="star-rating">
                            <span>★★★★</span>★
                        </div>
                        <!-- Display the first product's price -->
                        @if ($products->isNotEmpty())
                            <p>Price: <span id="price">₹ {{ $products->first()->mrp }}</span></p>
                        @endif
                    </div>

                    <!-- Choose color and size -->
                    <div class="select-items">
                        <!-- Color selection -->
                        <div class="change-color">
                            <label><b>Colour:</b></label>
                            <select onchange="updatePrice(this)">
                                @foreach ($products as $product)
                                    <option value="{{ $product->mrp }}">{{ $product->color }}</option>
                                @endforeach
                            </select>
                        </div>




                        <!-- Product description -->
                        <div class="description mt-4">
                            <ul>
                                @if ($products->isNotEmpty())
                                    <li>{{ $products->first()->description }}</li>
                                @endif
                            </ul>
                        </div>
                        <p>
                            For shopping you must become a dealer<br />
                            For become a dealer contact on +91 8866 232839

                        </p>
                    </div>
                </div>

            </section>
        </div>
    </div>

    {{-- Script Starts --}}
    <script>
        function updateMainImage(imageSrc) {
            document.getElementById('mainImage').src = imageSrc;
        }
    </script>

    <script>
        function updatePrice(selectElement) {
            // Get the selected price from the value attribute of the selected option
            const selectedPrice = selectElement.value;

            // Update the price display
            document.getElementById('price').textContent = '₹ ' + selectedPrice;
        }
    </script>
    {{-- Script End --}}
@endsection
