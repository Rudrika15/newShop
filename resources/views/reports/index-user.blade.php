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
                            
                        </div>
                        <!-- SKU List Table -->

                        @if (count($userReports) !== 0)
                            <div class="">
                                <h3>User Reports</h3>
                                <div class="pt-2">
                                    <form action="{{ route('reports.index') }}" method="get">
                                        <label for="">Find User</label>
                                        <div class="input-group mb-3">
                                            <input type="date" name="from" class="form-control shadow-none"
                                                id="">
                                            <input type="date" name="to" class="form-control shadow-none"
                                                id="">
                                            <button class="btn btn-primary shadow-none" type="submit">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Contact</th>
                                                <th scope="col">Total Orders</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($userReports)
                                                @foreach ($userReports as $user)
                                                    <tr>
                                                        <td>{{ $user->users->name }}</td>
                                                        <td>{{ $user->users->email }}</td>
                                                        <td>{{ $user->users->contact }}</td>
                                                        <td>{{ $user->total_orders }}</td>
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
