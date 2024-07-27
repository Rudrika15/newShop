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
                                @if (count($pincodes) > 0)
                                Pincode List
                                @else
                                There are no data to show
                                @endif
                            </h3>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end align-items-center">
                            {{-- <span style="float:right;"><a href="{{ route('pincode.trash') }}"
                                    class="btn btn-warning shadow-none me-2">Go To Trash</a>
                            </span> --}}
                            {{-- <span style="float:right;"><a href="{{ route('slider.create') }}"
                                    class="btn btn-primary shadow-none">Add
                                    Slider</a>
                            </span> --}}
                        </div>
                    </div>
                    <!-- SKU List Table -->

                    @if (count($pincodes) !== 0)
                    <table id="pincode-table" class="table table-bordered text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>State</th>
                                <th>District</th>
                                <th>City</th>
                                <th>Pincode</th>
                                <th>Is Deliverable</th>
                                <th>Delivery Charges</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pincodes as $index => $pincode)
                            <tr>
                                <td>{{ ($pincodes->currentPage() - 1) * $pincodes->perPage() + ($index + 1) }}</td>
                                <td>{{ $pincode->state }}</td>
                                <td>{{ $pincode->district ?? '-' }}</td>
                                <td>{{ $pincode->city ?? '-' }}</td>
                                <td>{{ $pincode->pincode ?? '-' }}</td>
                                <td>{{ $pincode->isDeliverable ?? '-' }}</td>
                                <td>{{ $pincode->deliveryCharges ?? '-' }}</td>
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
    {!! $pincodes->withQueryString()->links('pagination::bootstrap-5') !!}

    
</section>
@endsection