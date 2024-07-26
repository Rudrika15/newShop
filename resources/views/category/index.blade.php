@extends('layouts.app2')
@section('content')
    <section class="section">
        {{-- @if ($message = Session::get('success'))
            <div class="col-lg-12 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row p-3">
                            <div class="col-lg-6">
                                <h4 class="pt-2">
                                    @if (count($categories) > 0)
                                        Category List
                                    @else
                                        There are no data to show
                                    @endif
                                </h4>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end align-items-center">
                                <span style="float:right;"><a href="{{ route('category.trash') }}"
                                        class="btn btn-warning">Go To Trash</a>
                                </span>
                                <span style="float:right;"><a href="{{ route('category.create') }}"
                                        class="btn btn-primary ms-2">Add
                                        Category</a>
                                </span>
                            </div>
                        </div>
                        <!-- SKU List Table -->

                        @if (count($categories) !== 0)
                            <table id="sku-table" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        {{--  <th>Parent</th>  --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->categoryname }}</td>
                                            {{--  <td>{{ $category->parent }}</td>  --}}
                                            <td>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <div>
                                                        <a href="{{ route('category.edit', $category->id) }}"
                                                            class="btn btn-primary btn-sm shadow-none mb-2 ">Edit</a>
                                                    </div>
                                                    <div>
                                                        <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                            data-id="{{ $category->id }}">Delete</button>
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
        </div>
        <!-- Pagination Links -->
        {!! $categories->withQueryString()->links('pagination::bootstrap-5') !!}
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
                            window.location.href = `/category/delete/${userId}`;
                        }
                    });
                });
            });
        </script>
    </section>
@endsection
