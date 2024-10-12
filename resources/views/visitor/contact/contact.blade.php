@extends('visitor.layouts.app')

@section('content')
    <nav aria-label="breadcrumb" style="background-color: #1582d4;height: 50px; padding-top: 10px ;padding-left:40%">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-light">Home</a></li>
            <li class="breadcrumb-item " class="text-light" aria-current="page">Contact </li>
        </ol>
    </nav>
    <div class="container">
        <div class="row py-5">
            <div class="col-md-4">
                <div class="card" style="height: 10rem;">
                    <div class="card-body">
                        <h5 class="card-title">Email</h5>
                        <h6 class="card-subtitle mb-2 text-muted">msthetrendushaben@gmail.com</h6>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="height: 10rem;">
                    <div class="card-body">
                        <h5 class="card-title">Contact Us</h5>
                        <h6 class="card-subtitle mb-2 text-muted">8866 232839</h6>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="height: 10rem;">
                    <div class="card-body">
                        <h5 class="card-title">Address</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            m j dreams
                            <br>
                            opp.ajay arcade,
                            <br>
                            Jawahar Road,
                            <br>
                            Surendranagar 363001

                        </h6>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
