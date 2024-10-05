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
                                    @if (count($sliders) > 0)
                                        Slider List
                                    @else
                                        There are no data to show
                                    @endif
                                </h3>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end align-items-center">
                                <span style="float:right;"><a href="{{ route('slider.trash') }}"
                                        class="btn btn-warning shadow-none me-2">Go To Trash</a>
                                </span>
                                <span style="float:right;"><a href="{{ route('slider.create') }}"
                                        class="btn btn-primary shadow-none">Add
                                        Slider</a>
                                </span>
                            </div>
                        </div>
                        <!-- SKU List Table -->

                        @if (count($sliders) !== 0)
                            <table id="slider-table" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Slider Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slider)
                                        <tr>
                                            {{-- <td>{{ $slider->sliderImage ?? '-' }}</td> --}}

                                            <td><img src="{{ asset('slider/' . $slider->image) }}" width="50"
                                                    height="50"></td>


                                            <td>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <div>
                                                        <button class="delete-user btn btn-danger btn-sm shadow-none"
                                                            data-id="{{ $slider->id }}">Delete</button>
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
        {!! $sliders->withQueryString()->links('pagination::bootstrap-5') !!}

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
                            window.location.href = `/slider/delete/${userId}`;
                            Swal.fire('Deleted!', 'Moved to trash Successfully.', 'success');
                        }
                    });
                });
            });
        </script>

    </section>
@endsection
