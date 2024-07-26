<!-- productview.blade.php -->
@extends('layouts.app2') <!-- Assuming 'app' is your main layout file -->

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><span style="float:left;">
                            <h2>{{ $product->slug }}</h2>
                        </span> <span style="float:right;"><a onclick="history.back()" class="btn btn-primary shadow-none">Go
                                Back</a></span></div>
                    <div class="card-body pt-2">
                        <p>Main Image :
                            @if ($product->catalog)
                                <img src="{{ asset('images/catalog/' . $product->catalog->main_image) }}" width="50"
                                    height="50">
                            @else
                                <p>No catalog main image available.</p>
                            @endif
                        </p>
                        <p>Description : {{ $product->description }}</p>
                        <p>Category : {{ $product->category->categoryname }}</p>
                        <p>Base Price : {{ $product->base_price }}</p>
                        <p>Discount : {{ $product->discount_amt }}</p>
                        <p>Tax : {{ $product->tax_price }}</p>
                        <p>MRP : {{ $product->mrp }}</p>
                        <p>Product Image :
                            @if ($product->image)
                                <img src="{{ asset('images/product/' . $product->image) }}" width="50"
                                    height="50">
                            @else
                                <p>No catalog main image available.</p>
                            @endif
                        </p>
                        <p>Color : {{ $product->color }}</p>
                        <p>SKU : {{ $product->sku }}</p>
                        <p>Size : {{ $product->size }}</p>
                        <p>Is Active : {{ $product->is_active }}</p>
                        <!-- Add more details as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
