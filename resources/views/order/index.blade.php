@extends('layouts.app2')
@section('content')

    <section class="section">
        @if ($message = Session::get('success'))
            <div class="col-lg-6 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row p-3">
                            <div class="col-lg-6">
                                <h4 class="pt-2">
                                    @if (count($orders) > 0)
                                        REPOERT LIST
                                    @else
                                        There are no data
                                    @endif
                                </h4>
                            </div>

                            <div class="col-lg-6 d-flex justify-content-end align-items-end">
                                <span style="float:right;"><button onclick="printPage()"
                                        class="btn btn-primary btn-print">Print This Page</button>
                                </span>
                                {{--  <span style="float:right;"><a href="{{ route('report.index') }}"
                                        class="btn btn-primary ms-2">Back</a>
                                </span>  --}}
                            </div>
                        </div>
                        <!-- SKU List Table -->

                        @if (count($orders) !== 0)
                            <table id="sku-table" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Address</th>
                                        <th>Pincode</th>
                                        <th>Sku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->user_id }}</td>
                                            <td>{{ $order->price }}</td>
                                            <td>
                                                @if ($order->product && $order->product->sku)
                                                    {{ $order->product->sku }}
                                                @endif
                                            </td>
                                            {{--  <td>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <div>
                                                        <a href="{{ route('category.edit', $category->id) }}"
                                                            class="btn btn-primary btn-sm shadow-none mb-2 ">Edit</a>
                                                    </div>
                                                    <div>
                                                        <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                            data-id="{{ $category->id }}">Delete</button>
                                                    </div>
                                                </div>
                                            </td>  --}}
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

        <script>
            function printPage() {
                window.print();
            }
        </script>
    </section>
@endsection
