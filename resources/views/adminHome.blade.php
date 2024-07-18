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
                <h2 class="text-center">You are an Admin User.</h2>
                <!-- ======= Dashboard ======= -->
                <section id="dashboard" class="dashboard">
                    <div class="row">
                        <!-- Recent Orders -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Recent Orders</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer Name</th>
                                                <th>Order Date</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#1234</td>
                                                <td>John Doe</td>
                                                <td>2023-02-20</td>
                                                <td>$100.00</td>
                                            </tr>
                                            <tr>
                                                <td>#1235</td>
                                                <td>Jane Doe</td>
                                                <td>2023-02-19</td>
                                                <td>$50.00</td>
                                            </tr>
                                            <tr>
                                                <td>#1236</td>
                                                <td>Bob Smith</td>
                                                <td>2023-02-18</td>
                                                <td>$200.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Out-of-Stock Products -->
                        <div class="col-lg-6">
                            <div class="card-body mb-2">
                                <h5 class="card-title">Out-of-Stock Products</h5>
                                <table class="table table-bordered data-table">
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
            </div>
            </section>
        </div>
    </div>
    </div>
@endsection
