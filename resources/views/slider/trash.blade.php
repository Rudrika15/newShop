@extends('layouts.app2')
@section('content')
    <section class="section">
        {{-- @if ($message = Session::get('success'))
    <div class="col-lg-6 alert alert-success" id="successMessage">
        <p>{{ $message }}</p>
    </div>
    @endif --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-0 p-3">
                            <div class="col-lg-6">
                                <h3>
                                    @if (count($sliders) > 0)
                                        Slider Trash List
                                    @else
                                        There are no trash data to show
                                    @endif
                                </h3>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end align-items-center">
                                <span style="float:right;"><a href="{{ route('slider.index') }}"
                                        class="btn btn-primary">Back</a>
                                </span>
                            </div>
                        </div>
                        <!-- SKU List Table -->

                        @if (count($sliders) !== 0)
                            <table id="slider-table" class="table table-bordered text-center">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Slider Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slider)
                                        <tr>
                                            <td>{{ $slider->catalog->title ?? '-' }}</td>
                                            {{-- <td>{{ $slider->sliderImage ?? '-' }}</td> --}}

                                            <td><img src="{{ asset('slider/' . $slider->image) }}" width="50"
                                                    height="50"></td>


                                            <td>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <div>
                                                        <a href="{{ route('slider.restore', $slider->id) }}"
                                                            class="btn btn-primary btn-sm shadow-none mb-2 ">Restore</a>
                                                    </div>
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
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning', //question , error , warning , success , info

                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, permanently delete  it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to a route that handles user deletion
                            window.location.href = `/slider/force-delete/${userId}`;
                            Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                        }
                    });
                });
            });
        </script>

        <script>
            const skuRestore = document.querySelectorAll('.sku-restore');

            skuRestore.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const userId = e.target.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You want to restore this slider ?',
                        icon: 'question', //question , error , warning , success , info

                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, restore it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to a route that handles user deletion
                            window.location.href = `/slider/restore/${userId}`;
                            Swal.fire({
                                title: 'Restored!',
                                text: 'Sldier Restored Successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = `/slider/restore/${userId}`;
                                    Swal.fire('Restored!', 'Slider Restored Successfully.',
                                        'success');
                                }
                            });
                        }
                    });
                });
            });
        </script>

    </section>
@endsection
