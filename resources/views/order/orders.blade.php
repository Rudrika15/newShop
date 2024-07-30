@extends('layouts.app2')
@section('content')
<section class="section">
    @if (session()->has('success'))
    <script>
        Swal.fire(
                    'Success!',
                    '{{ session("success") }}',
                    'success'
                );
    </script>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-lg-6">
                            <h3>
                                @if (count($orders) > 0)
                                Order List
                                @else
                                There are no data to show
                                @endif
                            </h3>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end align-items-center">
                            {{-- <span style="float:right;"><a href="{{ route('slider.trash') }}"
                                    class="btn btn-warning shadow-none me-2">Go To Trash</a>
                            </span> --}}
                            {{-- <span style="float:right;"><a href="{{ route('slider.create') }}"
                                    class="btn btn-primary shadow-none">Add
                                    Slider</a>
                            </span> --}}
                        </div>
                    </div>
                    <!-- SKU List Table -->

                    @if (count($orders) !== 0)
                    <table id="slider-table" class="table table-bordered text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>User ID</th>
                                <th>Order ID</th>
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
                                <td>{{ $order->orders->user_id ?? '-' }}</td>
                                <td>{{ $order->order_id ?? '-' }}</td>
                                <td>{{ $order->orders->payment_id ?? '-' }}</td>
                                <td>{{ $order->product->slug ?? '-' }}</td>
                                <td>{{ $order->quantity ?? '-' }}</td>
                                <td>{{ $order->orderStatus ?? '-' }}</td>
                                <td>{{ $order->price ?? '-' }}</td>
                                <td>{{ $order->orders->amount ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination Links -->
    {!! $orders->withQueryString()->links('pagination::bootstrap-5') !!}

</section>
@endsection