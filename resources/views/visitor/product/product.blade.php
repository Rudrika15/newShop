@extends('visitor.layouts.app')

@section('title', 'Products')

@section('content')
    <nav aria-label="breadcrumb" style="background-color: #1582d4;height: 100px; padding-top: 35px ;padding-left:40%">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-light">Home</a></li>
            <li class="breadcrumb-item " class="text-light" aria-current="page">Product</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row py-5">
            @foreach ($data as $data)
                <div class="col-md-3">

                    <div class="card">
                        <img src="{{ asset('images/catalog/' . $data->main_image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ Str::ucfirst($data->title) }}</h5>
                            <a href="{{ route('product.detail', $data->id) }}" class="btn btn-primary">View more</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
