<!-- productview.blade.php -->
@extends('layouts.app2') <!-- Assuming 'app' is your main layout file -->

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">Product {{ $product->slug }}  <span style="float:right;"><a href="{{ route('product.index') }}" class="btn btn-primary shadow-none">Go
                        Back</a></span></div>
                    <div class="card-body pt-2">
                        <p>Main Image:</p>
                        <img src="{{ asset('images/catalog/' . $product->main_image) }}" width="100" height="100">
                        <p>Description: {{ $product->description }}</p>
                        <p>Category: {{ $product->category->categoryname }}</p>
                        <p>Base Price: {{ $product->base_price }}</p>
                        <p>Discount : {{ $product->discount_amt }}</p>
                        <p>Tax: {{ $product->tax }}</p>
                        <p>MRP: {{ $product->mrp }}</p>
                        <p>Color: {{ $product->color }}</p>
                        <p>SKU: {{ $product->sku->prefix ?? '-' }}</p>
                        <p>Size: {{ $product->size }}</p>
                        <p>Is Active: {{ $product->is_active }}</p>
                        <!-- Add more details as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
