@extends('layouts.app2')

@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="col-lg-6 alert alert-success" id="successMessage">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row m-0 p-3">
            <div class="col-lg-6">
                <h2>
                    @if (count($users) > 0)
                        TRASH DATA
                    @else
                        There are no trash data
                    @endif
                </h2>
            </div>
            <div class="col-lg-6 d-flex justify-content-end align-items-center">
                <span style="float:right;"><a href="{{ route('user.index') }}" class="btn btn-primary">Back</a></span>
            </div>
        </div>
        @if (count($users) !== 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->contact }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <div>
                                        <a href="{{ route('user.restore', $item->id) }}"
                                            class="btn btn-primary shadow-none mb-2 ">Restore</a>
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
        @endif
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
                    icon: 'warning', //question , error , warning , success , info

                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, permanently delete  it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to a route that handles user deletion
                        window.location.href = `/user/force-delete/${userId}`;
                    }
                });
            });
        });
    </script>
@endsection
