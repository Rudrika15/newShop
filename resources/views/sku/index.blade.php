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
                                    @if (count($skus) > 0)
                                        SKU List
                                    @else
                                        There are no data to show
                                    @endif
                                </h3>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end mb-3">
                                <span style="float:right;"><a href="{{ route('sku.trash') }}"
                                        class="btn btn-warning shadow-none me-2">Go To Trash</a>
                                </span>
                                <span style="float:right;"><a href="{{ route('sku.create') }}"
                                        class="btn btn-primary shadow-none">Add
                                        SKU</a>
                                </span>
                            </div>
                            <!-- SKU List Table -->

                            @if (count($skus) !== 0)
                                <table id="sku-table" class="table table-bordered  text-center mt-3">
                                    <thead>
                                        <tr>
                                            <th>Prefix</th>
                                            <th>Color Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($skus as $sku)
                                            <tr>
                                                <td>{{ $sku->prefix }}</td>
                                                <td>{{ $sku->colorname }}</td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <div>
                                                            <a href="{{ route('sku.edit', $sku->id) }}"
                                                                class="btn btn-primary btn-sm shadow-none mb-2 ">Edit</a>
                                                        </div>
                                                        <div>
                                                            <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                                data-id="{{ $sku->id }}">Delete</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Pagination Links -->
                {!! $skus->withQueryString()->links('pagination::bootstrap-5') !!}

                <script>
                    const deleteButtons = document.querySelectorAll('.delete-user');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();
                            const userId = e.target.getAttribute('data-id');

                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'You can revert this action from trash!',
                                icon: 'warning', //question , error , warning , success , info

                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to a route that handles user deletion
                                    window.location.href = `/sku/delete/${userId}`;
                                    Swal.fire('Deleted!', 'Moved to trash Successfully.', 'success');
                                }
                            });
                        });
                    });
                </script>

    </section>
@endsection
