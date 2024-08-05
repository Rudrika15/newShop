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
                                <h3>
                                    Addresses
                                </h3>
                            </div>
                            
                        </div>
                        <!-- SKU List Table -->
                        <div class="container">
                            <div class="row">
                                <form action="{{ route('stricker.print') }}" method="get">
                                    
                                    <div class="form-group mb-3">
                                        <label for="categoryname" class="mt-2">Start date</label>
                                        <input type="date" required name="from" class="form-control shadow-none">
                                        
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="categoryname" class="mt-2">End date</label>
                                        <input type="date" required name="to" class="form-control shadow-none">
                                            
                                    </div>
                                    
                                    
                                    <button type="submit" class="btn btn-primary shadow-none">Print</button>
                                </form>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </div>
        </div>
        <!-- Pagination Links -->
        {{-- {!! $sliders->withQueryString()->links('pagination::bootstrap-5') !!} --}}


    </section>
@endsection
