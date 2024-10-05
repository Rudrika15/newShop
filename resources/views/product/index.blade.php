@extends('layouts.app2')

@section('content')
    <div class="container-fluid mb-2">
        @if ($message = Session::get('success'))
            <div class="col-lg-6 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="row p-3">
                <div class="col-lg-6">
                    <h4 class="pt-2">
                        @if (count($catalogs) > 0)
                            Product List
                        @else
                            There are no data to show
                        @endif
                    </h4>
                </div>
                <div class="col-lg-6 d-flex justify-content-end align-items-center">
                    <span style="float:right;"><a href="{{ route('product.trash') }}" class="btn btn-warning shadow-none">Go
                            To
                            Trash</a>
                    </span>
                    <span style="float:right;"><a href="{{ route('product.create') }}"
                            class="btn btn-primary shadow-none ms-2">Add
                            Product</a>
                    </span>
                </div>
            </div>
            @if (count($catalogs) !== 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Sr. no</th>
                                <th>Catalog Name</th>
                                <th>Main Image</th>
                                <th>Action</th>
                                <th>Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1
                            @endphp
                            @foreach ($catalogs as $catalog)
                                <tr class="text-center">
                                    
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $catalog->title }}</td>
                                    <td><img src="{{ asset('images/catalog/' . $catalog->main_image) }}" width="50"
                                            height="50">
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <div>
                                                <a href="{{ route('catalog.edit', $catalog->id) }}"
                                                    class="btn btn-primary btn-sm shadow-none">Edit</a>
                                            </div>
                                            <div>
                                                <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                    data-id="{{ $catalog->id }}">Delete </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center flex-nowrap">
                                            @foreach ($catalog->products as $product)
                                                {{-- <p>{{ $product->slug }}</p> --}}
                                                <div>
                                                    <a href="{{ route('product.edit', $product->id) }}"
                                                        class="btn btn-secondary btn-sm shadow-none">
                                                        {{-- <i class="fas fa-edit">
                                            <p>{{ $product->slug }}</p>
                                        </i> --}}
                                                        {{ $product->color }}
                                                    </a>
                                                </div>
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
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to a route that handles user deletion
                        window.location.href = `/catalog/delete/${userId}`;
                        Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                    }
                });
            });
        });
    </script>
@endsection
