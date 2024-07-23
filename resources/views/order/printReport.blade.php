@extends('layouts.app2')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Roboto Mono", monospace;
            background-color: #FFFFFF;
            margin: 0;
            padding: 0;
        }

        #wrapper {
            width: 100%;
            max-width: 800px;
            /* Adjust max-width as needed */
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #F7F7F7;
            border-radius: 5px;
            line-height: 1.5;
            background: #F7F7F7;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            /* Align to the end (right) of the container */
            margin-top: 20px;
            /* Adjust as needed */
        }

        .btn-print {
            margin-left: 40%;
            /* Add space between the button and other content */
        }

        img {
            max-width: 100%;
            height: auto;
        }

        hr.line1 {
            border: 2px solid #000000;
            margin: 0px 0px 0px 72px;
        }

        hr.line2 {
            border: 2px solid #000000;
            margin: 0px 0px 0px 75px;
        }

        hr.line3 {
            border: 2px solid #000000;
            margin: 0px 0px 0px 85px;
        }

        hr.line4 {
            border: 2px solid #000000;
            margin: 0px 0px 0px 185px;
        }

        hr.line5 {
            border: 2px solid #000000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000000;
            padding: 8px;
            text-align: center;
        }

        .no-print {
            display: none;
        }

        @media print {
            body {
                font-size: 12px;
                margin-top: 0px;
                margin-bottom: 0px;
                /* Adjust font size for printing */
            }

            #wrapper {
                padding: 10px;
                background: #FFFFFF;
            }


            .btn-primary {
                display: none;
            }

            hr {
                border: 2px solid #000000;
                margin-left: 80px;
            }

            hr.line5 {
                border: 2px solid #000000;
                margin: 0px 0px 5px 420px;
            }

            img {
                width: 350px;
                /* Adjust logo size for printing */
                height: auto;
                margin: 5px 0px;
            }

            p.fs-5 {
                margin: 0px 30px 0px 0px;
            }

            /* Adjust margins for printing */
            @page {
                size: A4;
                margin: 5mm;
            }
        }
    </style>

    <div id="wrapper">
        <div class="text-center">
            <img src="{{ asset('templateCss/images/Expertlogo.png') }}" class="img-fluid" alt="Logo">
            <h1 class="mt-3">Order Report List</h1>
        </div>

        {{--  <div class="row mt-4 mb-2">
            <div class="col-lg-6 mt-2">
                <h4>Name: <span class="text-dark">{{ $studentData->name }}</span></h4>
                <hr class="line1">
            </div>
            <div class="col-lg-6 mt-2">
                <h4>Date: {{ $currentDate }}</h4>
                <hr class="line2">
            </div>
        </div>  --}}
        {{--  <div class="row">
            <div class="col-lg-6 mt-2">
                <h4>Email: <span class="text-dark">{{ $studentData->email }}</span></h4>
                <hr class="line3">
            </div>
            <div class="col-lg-6 mt-2">
                <h4>Phone Number: <span class="text-dark">{{ $studentData->phoneNumber }}</span></h4>
                <hr class="line4">
            </div>
        </div>  --}}

        <table class="table table-striped table-bordered table-hover mt-5 ">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Address</th>
                    <th scope="col">Pincode</th>
                    <th scope="col">Sku</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user_id }}</td>
                        <td>{{ $item->product_id }}</td>
                        <td>{{ $item->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="btn-container">
        <button onclick="printPage()" class="btn btn-primary btn-print">Print This Page</button>
    </div>
    <script>
        function printPage() {
            window.print();
        }
    </script>
@endsection
