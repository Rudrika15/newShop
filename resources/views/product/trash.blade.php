@extends('layouts.app2')

@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="col-lg-6 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row justify-content-center" style="background-color: rgb(155, 191, 212)">
            <div class="row p-2">
                <div class="col-lg-6">
                    <h4 class="pt-2">
                        @if (count($catalogs) > 0)
                            TRASHED PRODUCTS LIST
                        @else
                            There are no data
                        @endif
                    </h4>
                </div>
                <div class="col-lg-6 d-flex justify-content-end align-items-center">
                    <span style="float:right;"><a href="{{ route('product.index') }}" class="btn btn-primary shadow-none">Go
                            Back</a></span>
                </div>
            </div>
            @if (count($catalogs) !== 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Catalog Name</th>
                                <th>Main Image</th>
                                <th>Action</th>
                                <th>Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catalogs as $catalog)
                                <tr class="text-center">
                                    <td>{{ $catalog->id }}</td>
                                    <td>{{ $catalog->title }}</td>
                                    <td>
                                        <img src="{{ asset('images/catalog/' . $catalog->main_image) }}" width="50"
                                            height="50">
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <div>
                                                <a href="{{ route('product.restore', $catalog->id) }}"
                                                    class="btn btn-primary btn-sm shadow-none">Restore
                                                </a>
                                            </div>
                                            <div>
                                                <div>
                                                    <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                        data-id="{{ $catalog->id }}">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center flex-nowrap">
                                            @foreach ($catalog->products as $product)
                                                <div>
                                                    <a href="{{ route('product.view', $product->id) }}"
                                                        class="btn btn-primary btn-sm shadow-none">
                                                        {{ $product->slug }}
                                                    </a>
                                                </div>
                                                {{--  <div>
                                                    <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                        data-id="{{ $product->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>  --}}
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {!! $catalogs->withQueryString()->links('pagination::bootstrap-5') !!}

    <script>
        const deleteButtons = document.querySelectorAll('.delete-user');

        deleteButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const userId = e.target.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning', //question , error , warning , success , info

                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, permanently delete  it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to a route that handles user deletion
                        window.location.href = `/catalog/force-delete/${userId}`;
                    }
                });
            });
        });
    </script>
@endsection
