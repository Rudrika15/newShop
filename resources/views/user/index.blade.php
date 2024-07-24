@extends('layouts.app2')
@section('content')
    <div class="container-fluid mb-2">
        @if ($message = Session::get('success'))
            <div class="col-lg-6 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row justify-content-center" style="background-color: #D6EFD8">
            <div class="row p-3">
                <div class="col-md-6">
                    <form action="{{ route('user.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control shadow-none"
                                placeholder="Search by name, email, or contact" value="{{ request()->input('search') }}">
                            <button type="submit" class="btn btn-primary shadow-none">Search</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary shadow-none">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('user.trash') }}" class="btn btn-warning me-2">Go to Trash</a>
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>
                </div>
            </div>
            @if (count($users) !== 0)
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Conatct</th>
                                <th>User Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->contact }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <div>
                                                <a href="{{ route('user.edit', $item->id) }}"
                                                    class="btn btn-primary shadow-none mb-2 ">Edit</a>
                                            </div>
                                            <div>
                                                <button class="delete-user btn btn-danger shadow-none"
                                                    data-id="{{ $item->id }}">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info col-lg-6">
                    <p class="text-center">No users found.</p>
                </div>
            @endif
        </div>
    </div>
    {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
    <script>
        const deleteButtons = document.querySelectorAll('.delete-user');

        deleteButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const userId = e.target.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning', //question, error, warning, success, info

                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to a route that handles user deletion
                        window.location.href = `/user/delete/${userId}`;
                    }
                });
            });
        });
    </script>
@endsection
