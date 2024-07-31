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
                                <td>{{ $order->orders->users->name ?? '-' }}</td>
                                <td>{{ $order->order_id ?? '-' }}</td>
                                <td>{{ $order->orders->payment_id ?? '-' }}</td>
                                <td>{{ $order->product->slug ?? '-' }}</td>
                                <td>{{ $order->quantity ?? '-' }}</td>
                                <td>
                                    <select class="form-control order-status" data-order-id="{{ $order->id }}">
                                        <option value="Confirm" {{ $order->orderStatus == 'Confirm' ? 'selected' : ''
                                            }}>Confirm</option>
                                        <option value="Shipped" {{ $order->orderStatus == 'Shipped' ? 'selected' : ''
                                            }}>Shipped</option>
                                        <option value="Out for Delivery" {{ $order->orderStatus == 'Out for Delivery' ?
                                            'selected' : '' }}>Out for Delivery</option>
                                        <option value="Delivered" {{ $order->orderStatus == 'Delivered' ? 'selected' :
                                            '' }}>Delivered</option>
                                    </select>
                                </td>
                                {{-- {{$order->id}} --}}
                                <td>{{ $order->price ?? '-' }}</td>
                                <td>{{ $order->orders->amount ?? '-' }}</td>
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
                body: JSON.stringify({ orderStatus: newStatus })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
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
                console.error('There was a problem with the fetch operation:', error);
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