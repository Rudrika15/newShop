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
                                <h5 class="card-title">Update stock</h5>
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
                                            <tr>
                                                <td>{{ $catalog->catalog->title  }}</td>
                                                <td>
                                                    {{ $catalog->slug }}
                                                    <br>
                                                    {{ $catalog->sku }}
                                                </td>
                                    
                                                <td>
                                                    @if ($catalog->getStoke) 
                                                        {{ $catalog->getStoke->quantity ?? 'N/A' }} 
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('product.edit', $catalog->id) }}" class="btn btn-primary">Edit</a>
                                                </td>

                                            </tr>
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
                                    <div class="d-flex justify-content-between">

                                        <h5 class="my-3">Recent Orders</h5>
                                        <div>
                                            <a href="{{ route('admin.home') }}" class="btn btn-primary my-3 ">Refresh</a>
                                        </div>
                                    </div>
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
                                                    <th>Order Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $order->order->users->name ?? '-' }}
                                                            <br />
                                                            {{ $order->order->users->contact ?? '-' }}
                                                        </td>
                                                        <td>{{ $order->customer_address ?? '-' }}</td>
                                                        <td>{{ $order->order->payment_id ?? '-' }}</td>
                                                        <td>{{ $order->product->slug ?? '-' }}
                                                            <br />
                                                            {{ $order->product->sku ?? '-' }}
                                                        </td>
                                                        <td>{{ $order->quantity ?? '-' }}</td>
                                                        <td>
                                                            {{ $order->orderStatus ?? '-' }}
                                                        </td>
                                                        {{-- {{$order->id}} --}}
                                                        <td>{{ $order->price ?? '-' }}</td>
                                                        <td>{{ $order->order->amount ?? '-' }}</td>
                                                        <td>
                                                            @php
                                                                $date = date('d-M-Y', strtotime($order->created_at));
                                                            @endphp
                                                            {{ $date ?? '-' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
