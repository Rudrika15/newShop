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
                                  Vesion List
                                </h3>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end align-items-center">
                                {{-- <span style="float:right;"><a href="{{ route('slider.trash') }}"
                                        class="btn btn-warning shadow-none me-2">Go To Trash</a>
                                </span> --}}
                                <span style="float:right;"><a href="{{ route('version.create') }}"
                                        class="btn btn-primary shadow-none">Add
                                        Version</a>
                                </span>
                            </div>
                        </div>
                        <!-- SKU List Table -->

                        
                            <table id="slider-table" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Version</th>
                                        <th>Link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($version as $version)
                                        <tr>
                                            <td>{{ $version->version }}</td>
                                            <td>{{ $version->link }}</td>
                                            <td>
                                                <a href="{{ route('version.edit', $version->id) }}" class="btn btn-primary btn-sm shadow-none me-2"></a>
                                                <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                data-id="{{ $version->id }}">Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        
                    </div>
                </div>
            </div>
        </div>
      

    </section>

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
                        window.location.href = `/version/delete/${userId}`;
                        Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                    }
                });
            });
        });
    </script>
@endsection
