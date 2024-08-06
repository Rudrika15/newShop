@extends('layouts.app2')

@section('content')
    {{--  <style>
        .dashboard {
            padding: 5px;
        }

        .dashboard .card {
            margin-bottom: 20px;
        }

        .dashboard .card-body {
            padding: 20px;
        }

        .dashboard table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard th,
        .dashboard td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .dashboard th {
            background-color: #f0f0f0;
        }
    </style>  --}}
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="col-lg-6 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2 class="text-center">Hello, Admin</h2>
                <!-- ======= Dashboard ======= -->
                <section id="dashboard" class="dashboard">
                    <div class="row">
                        <!-- Out-of-Stock Products -->
                        <div class="col-lg-12">
                            <div class="card-body mb-2">
                                <h5 class="card-title">Out-of-Stock Products</h5>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Catalog Name</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($catalogs as $catalog)
                                            @foreach ($catalog->products as $product)
                                                @foreach ($product->productStocks as $stock)
                                                    @if ($stock->quantity <= 10)
                                                        <tr>
                                                            <td>{{ $catalog->title }}</td>
                                                            <td>{{ $product->slug }}</td>
                                                            <td>{{ $stock->quantity }}</td>
                                                            <td>
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                    <div>
                                                                        <a href="{{ route('product-stock.edit', $stock->id) }}"
                                                                            class="btn btn-primary btn-sm shadow-none mb-2">Edit</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $catalogs->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                    <div class="row">
                        <!-- Recent Orders -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Recent Orders</h5>
                                    @if (count($orders) !== 0)
                                        <table id="slider-table" class="table table-bordered text-center">
                                            <thead class="">
                                                <tr>
                                                    <th>No</th>
                                                    <th>User Name</th>
                                                    <th>Address</th>
                                                    <th>Payment ID</th>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                    <th>Order Status</th>
                                                    <th>Price</th>
                                                    <th>Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $order->order->users->name ?? '-' }}</td>
                                                        <td>{{ $order->customer_address ?? '-' }}</td>
                                                        <td>{{ $order->order->payment_id ?? '-' }}</td>
                                                        <td>{{ $order->product->slug ?? '-' }}</td>
                                                        <td>{{ $order->quantity ?? '-' }}</td>
                                                        <td>
                                                            {{ $order->orderStatus ?? '-' }}
                                                        </td>
                                                        {{-- {{$order->id}} --}}
                                                        <td>{{ $order->price ?? '-' }}</td>
                                                        <td>{{ $order->order->amount ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {!! $orders->withQueryString()->links('pagination::bootstrap-5') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                   
                </section>
            </div>
        </div>
    </div>
@endsection
