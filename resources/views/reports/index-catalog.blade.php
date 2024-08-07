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
                                <h2>
                                    Reports

                                </h2>
                            </div>

                        </div>
                        <!-- SKU List Table -->

                        
                        <!-- SKU List Table -->

                        @if (count($catalogReport) !== 0)
                            <div class="">
                                <h3>Catelog Reports</h3>
                                <div class="pt-2">
                                    <form action="{{ route('reports.index') }}" method="get">
                                        <label for="">Find User</label>
                                        <div class="input-group mb-3">
                                            <input type="date" name="fromC" class="form-control shadow-none"
                                                id="">
                                            <input type="date" name="toC" class="form-control shadow-none"
                                                id="">
                                            <button class="btn btn-primary shadow-none" type="submit">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">Image</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Product Color</th>
                                                <th scope="col">Product Catelog</th>
                                                <th scope="col">Total Orders</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($catalogReport)
                                                @foreach ($catalogReport as $catelog)
                                                    <tr>
                                                        <td><img src="{{ asset('images/catalog')}}/{{$catelog->product->catalog->main_image}}" width="80" alt=""></td>
                                                        <td>{{ $catelog->product->slug }}</td>
                                                        <td>{{ $catelog->product->color }}</td>
                                                        <td>{{ $catelog->product->catalog->title }}</td>
                                                        <td>{{ $catelog->total_sales }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

    </section>
@endsection
