@extends('layouts.app2')

@section('content')
    <style>
        .dashboard {
            padding: 20px;
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
    </style>
    <div class="container">
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
                                    <table class="table table-striped">
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
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Out-of-Stock Products</h5>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Product A</td>
                                                <td>0</td>
                                            </tr>
                                            <tr>
                                                <td>Product B</td>
                                                <td>0</td>
                                            </tr>
                                            <tr>
                                                <td>Product C</td>
                                                <td>0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
