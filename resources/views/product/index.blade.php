@extends('layouts.app2')

@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="col-lg-6 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="row m-0 py-2">
                <div class="col-lg-6">
                    <h3>
                        @if (count($products) > 0)
                            PRODUCTS LIST
                        @else
                            There are no data
                        @endif
                    </h3>
                </div>
                <div class="col-lg-6 d-flex justify-content-end align-items-center">
                    <span style="float:right;"><a href="{{ route('product.trash') }}" class="btn btn-warning shadow-none">Go To
                            Trash</a>
                    </span>
                    <span style="float:right;"><a href="{{ route('product.create') }}"
                            class="btn btn-primary shadow-none ms-2">Add
                            Product</a>
                    </span>
                </div>
            </div>
            @if (count($products) !== 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Catalog Name</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Slug</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Image</th>
                                <th>Opening Stock</th>
                                <th>Description</th>
                                <th>Base Price</th>
                                <th>Tax </th>
                                <th>Discount Amount</th>
                                <th>MRP</th>
                                <th>Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->catalog->title }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->category->categoryname }}</td>
                                    <td>{{ $product->slug }}</td>
                                    <td>{{ $product->color }}</td>
                                    <td>{{ $product->size }}</td>
                                    <td><img src="{{ asset('images/product/' . $product->image) }}" width="50"
                                            height="50"></td>
                                    <td>{{ $product->opening_stock }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->base_price }}</td>
                                    <td>{{ $product->tax_price }}</td>
                                    <td>{{ $product->discount_amt }}</td>
                                    <td>{{ $product->mrp }}</td>
                                    <td>{{ $product->is_active }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <div>
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn btn-primary btn-sm shadow-none">Edit</a>
                                            </div>
                                            <div>
                                                <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                    data-id="{{ $product->id }}">Delete</button>
                                            </div>
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
    {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}

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
                        window.location.href = `/product/delete/${userId}`;
                    }
                });
            });
        });
    </script>
@endsection
