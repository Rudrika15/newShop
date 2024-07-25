<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>New Shop</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <section class="section p-5">
        @if ($message = Session::get('success'))
            <div class="col-lg-6 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="row p-3">
                    <div class="col-lg-6">
                        <h4 class="pt-2">
                            @if (count($orders) > 0)
                                REPORT LIST
                            @else
                                There are no data
                            @endif
                        </h4>
                    </div>
                </div>

                @if (count($orders) !== 0)
                    <div class="container">
                        @foreach ($orders->chunk(6) as $page)
                            @foreach ($page->chunk(2) as $row)
                                <div class="row mb-4">
                                    @foreach ($row as $order)
                                        <div class="col-md-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Order Details</h5>
                                                    <p><strong>Address:</strong> {{ $order->user_id }}</p>
                                                    <p><strong>Pincode:</strong> {{ $order->price }}</p>
                                                    <p><strong>SKU:</strong>
                                                        @if ($order->product && $order->product->sku)
                                                            {{ $order->product->sku }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            @if (!$loop->last)
                                <div class="page-break"></div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <script>
            window.onload = function() {
                window.print();
            };
        </script>
    </section>
</body>

</html>
