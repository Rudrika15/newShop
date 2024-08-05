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
                                        Order List
                                    @else
                                        There are no order data to show
                                    @endif
                                </h4>
                            </div>

                            <div class="col-lg-6 d-flex justify-content-end align-items-end">
                                <span style="float:right;">
                                    <a id="printButton" class="btn btn-primary btn-print">Print This Page</a>
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
                                    @foreach ($orders->chunk(10) as $page)
                                        @foreach ($page as $order)
                                            <tr>
                                                <td>{{ $order->user_id }}</td>
                                                <td>{{ $order->price }}</td>
                                                <td>
                                                    @if ($order->product && $order->product->sku)
                                                        {{ $order->product->sku }}
                                                    @endif
                                                </td>
                                        @endforeach
                                        </tr>
                                        @if (!$loop->last)
                                            <div class="page-break"></div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <iframe id="printFrame" style="display:none;" src=""></iframe>
        <!-- Pagination Links -->
        {!! $orders->withQueryString()->links('pagination::bootstrap-5') !!}
        <script>
            document.getElementById('printButton').addEventListener('click', function() {
                var printPageUrl = '{{ route('report.print') }}';
                var printFrame = document.getElementById('printFrame');
                printFrame.src = printPageUrl;
                printFrame.onload = function() {
                    printFrame.contentWindow.print();
                };
            });
        </script>
    </section>
@endsection
