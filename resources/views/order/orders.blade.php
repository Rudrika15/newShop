@extends('layouts.app2')
@section('content')
    <section class="section">
        @if (session()->has('success'))
            <script>
                Swal.fire(
                    'Success!',
                    '{{ session('success') }}',
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
                                <h3 id="ordersList-heading">
                                    Order List
                                </h3>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end align-items-center">
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger"><strong>* You can update the Order Status by clicking on the
                                            respective field.</strong></span>
                                </div>
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
                        <form action="{{ route('orders.index') }}" method="get">
                            <div class="row py-3">
                                <div class="col">
                                    <select name="orderStatus" class="form-select">
                                        <option disabled {{ request('orderStatus') == null ? 'selected' : '' }}>select order
                                            status</option>
                                        <option value="Confirm" {{ request('orderStatus') == 'Confirm' ? 'selected' : '' }}>
                                            Confirm</option>
                                        <option value="Shipped" {{ request('orderStatus') == 'Shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="Out for Delivery"
                                            {{ request('orderStatus') == 'Out for Delivery' ? 'selected' : '' }}>Out for
                                            Delivery</option>
                                        <option value="Delivered"
                                            {{ request('orderStatus') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="Cancelled"
                                            {{ request('orderStatus') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" placeholder="Enter Product Name" name="productName"
                                        class="form-control" value="{{ request('productName') }}" />
                                </div>
                                <div class="col">
                                    <input type="text" placeholder="Enter Name" name="userName" class="form-control"
                                        value="{{ request('userName') }}" />

                                </div>
                                <div class="col">
                                    <input type="date" placeholder="Enter Name" name="date" class="form-control"
                                        value="{{ request('date') }}" />

                                </div>

                                <div class="col">
                                    <input type="submit" class="btn btn-primary shadow-none" value="Filter" />
                                    <a href="{{ route('orders.index') }}" class="btn btn-primary shadow-none">Reset</a>
                                </div>
                            </div>
                        </form>

                        @if (count($orders) !== 0)
                            <table id="slider-table" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Sr no</th>
                                        <th>Order date</th>
                                        <th>User Name</th>
                                        <th>Address</th>
                                        <th>Payment ID</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Order Status</th>
                                        <th>Price</th>
                                        <th>Total Amount</th>
                                        <th>Update Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-M-Y', strtotime($order->created_at)) }}</td>
                                            <td>{{ $order->order->users->name ?? '-' }}
                                                <br />
                                                {{ $order->order->users->contact ?? '-' }}
                                            </td>
                                            <td style="width: 200px">{{ nl2br($order->customer_address ?? '-') }}</td>
                                            <td>{{ $order->order->payment_id ?? '-' }}</td>
                                            <td>
                                                {{ $order->product->slug ?? '-' }}
                                                <br />
                                                {{ $order->product->sku ?? '-' }}
                                            </td>
                                            <td style="width: 50px">{{ $order->quantity ?? '-' }}</td>
                                            <td style="width: 120px">
                                                <select class="form-control order-status"
                                                    data-order-id="{{ $order->id }}">
                                                    <option value="Confirm"
                                                        {{ $order->orderStatus == 'Confirm' ? 'selected' : '' }}>Confirm
                                                    </option>
                                                    <option value="Shipped"
                                                        {{ $order->orderStatus == 'Shipped' ? 'selected' : '' }}>Shipped
                                                    </option>
                                                    <option value="Out for Delivery"
                                                        {{ $order->orderStatus == 'Out for Delivery' ? 'selected' : '' }}>
                                                        Out for Delivery</option>
                                                    <option value="Delivered"
                                                        {{ $order->orderStatus == 'Delivered' ? 'selected' : '' }}>
                                                        Delivered</option>
                                                    <option value="Cancelled"
                                                        {{ $order->orderStatus == 'cancelled' ? 'selected' : '' }}>
                                                        Cancelled</option>
                                                </select>
                                            </td>
                                            <td>{{ $order->price ?? '-' }}</td>
                                            <td>{{ $order->order->amount ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $date = date('d-M-Y', strtotime($order->updated_at));
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
        <!-- Pagination Links -->
        {!! $orders->withQueryString()->links('pagination::bootstrap-5') !!}

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.order-status').forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    var orderId = this.getAttribute('data-order-id');
                    var newStatus = this.value;

                    fetch(`/orders/${orderId}/update-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                orderStatus: newStatus
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response
                                    .statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Updated!',
                                    'Order status has been updated.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an error updating the order status.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:',
                                error);
                            Swal.fire(
                                'Error!',
                                'There was a problem with the fetch operation.',
                                'error'
                            );
                        });
                });
            });
        });
    </script>

@endsection
