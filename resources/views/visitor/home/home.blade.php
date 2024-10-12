@extends('visitor.layouts.app')

@section('title', 'Home')
@section('content')
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">

            @foreach ($data as $key => $item)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="3000">
                    <img src="{{ asset('slider/' . $item->image) }}" style="aspect-ratio: 3/2;object-fit: fill;width: 100%"
                        alt="">
                </div>
            @endforeach

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="container">
        <div class="row pt-5">
            <h1>About us</h1>
            <p>Welcome to MJ Dream, your ultimate destination for exquisite sharees that blend tradition with
                contemporary elegance. As a proud child company of <span style="color:blueviolet">MS The
                    Trends</span>, we are passionate about the
                rich heritage of Indian textiles. Our curated collection caters to every occasion, from weddings
                to festivals and everyday wear.</p>
            <p>
                <a href="{{ route('about') }}" class="btn btn-outline-primary">Read More</a>
            </p>
        </div>
    </div>
@endsection
