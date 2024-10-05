@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row py-2" style="background-color: #fff">
            <div class="col-md-6">
                <h2>Edit Product</h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <span style="float:right;">
                    <a onclick="history.back()" class="btn btn-primary shadow-none">Back</a>
                </span>
            </div>
        </div>
        <div class="row" style="background-color:#fff">
            <form method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row border border-dark p-3 m-3">
                    <!-- Catalog Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Catalog Name</label>
                            <input class="form-control" type="text" name="title" id="title"
                                value="{{ $product->catalog->title }}" readonly>
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="main_image" class="form-label">Main Image</label><br>
                            <img
                                style="width: 40%; aspect-ratio: 3/2; object-fit:contain"src="{{ asset('images/catalog/' . $product->catalog->main_image) }}">
                            <span class="text-danger">
                                @error('main_image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                @if ($product->is_active == 'No')
                    <div style="filter: blur(5px); cursor: not-allowed; pointer-events: none; " onfocus="blur()" class="row">
                @endif
                <div class="row border border-dark p-3 m-3">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="title" class="form-label">Category Name</label>
                            <input class="form-control" type="text" name="title" id="title"
                                value="{{ $product->catalog->title }}" readonly disabled>
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col">
                            <label for="title" class="form-label">Color</label>
                            <input class="form-control" type="text" name="title" id="title"
                                value="{{ $product->color }}" readonly disabled>
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col">
                            <label for="title" class="form-label">Slug</label>
                            <input class="form-control" type="text" name="title" id="title"
                                value="{{ $product->slug }}" readonly disabled>
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Stock Info -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="title" class="form-label">Current Stock</label>
                            <input class="form-control" type="text" name="title" id="title"
                                value="{{ $stock->quantity }}" readonly disabled>
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col">
                            <label for="title" class="form-label">New Stock</label>
                            <input class="form-control" type="text" name="newStock">
                            <span class="text-danger">
                                @error('newStock')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="title" class="form-label">Base Price</label>
                            <input class="form-control" type="text" name="base_price" id="title"
                                value="{{ $product->base_price }}">
                            <span class="text-danger">
                                @error('base_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col">
                            <label for="title" class="form-label">Tax Price</label>
                            <input class="form-control" type="text" name="tax_price" id="title"
                                value="{{ $product->tax_price }}">
                            <span class="text-danger">
                                @error('tax_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col">
                            <label for="title" class="form-label">Discount Amount</label>
                            <input class="form-control" type="text" name="discount_amt" id="title"
                                value="{{ $product->discount_amt }}">
                            <span class="text-danger">
                                @error('discount_amt')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col">
                            <label for="title" class="form-label">MRP</label>
                            <input class="form-control" type="text" name="mrp" id="title"
                                value="{{ $product->mrp }}">
                            <span class="text-danger">
                                @error('mrp')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Description and Image -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="title" class="form-label">Description</label>
                            <textarea class="form-control" name="title" id="title" rows="10" readonly disabled>{{ $product->description }}</textarea>
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col">
                            <label for="main_image" class="form-label">Main Image</label><br>
                            <img id="image-preview" src="{{ asset('images/product/' . $product->image) }}"
                                style="width: 100%; aspect-ratio: 3/2; object-fit:contain">
                        </div>
                        <div class="col">
                            <label for="image-input" class="form-label">Change Image</label><br>
                            <input type="file" name="image" id="image-input" accept="image/*">
                        </div>

                    </div>
                </div>
                @if ($product->is_active == 'No')
        </div>
        @endif

        <!-- Submit Button -->
        <div class="row d-flex justify-content-end mb-5">
            <div class="col-md-12 d-flex justify-content-center">
                @if ($product->is_active == 'Yes')
                <button type="submit" class="btn btn-primary mx-2">Update</button>
                    <a href="{{ route('product.deleteProduct', ['id' => $product->id]) }}"
                        class="btn btn-danger">Delete</a>
                @else
                    <a href="{{ route('product.restoreProduct', ['id' => $product->id]) }}"
                        class="btn btn-warning">Restore</a>
                @endif



            </div>
        </div>
        </form>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('image-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('delete-button').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default anchor behavior

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this product!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with the deletion
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );

                    // Optionally, you can redirect or submit a form here
                    // window.location.href = 'your-deletion-url';
                    // or
                    // document.getElementById('your-form-id').submit();
                }
            });
        });
    </script>
@endsection
