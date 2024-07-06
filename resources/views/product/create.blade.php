@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Create Product</h4>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center mb-2">
                <span style="float:right;"><a href="{{ route('product.index') }}"
                        class="btn btn-primary shadow-none ms-2">Back</a></span>
            </div>
        </div>
        <div class="row border border-3">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row border p-3 m-5">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Catalog Name</label>
                            <input class="form-control" type="text" name="title" id="title"
                                value="{{ old('title') }}">
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="main_image" class="form-label">Main Image</label>
                            <input class="form-control" type="file" name="main_image" id="main_image">
                            <span class="text-danger">
                                @error('main_image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="categoryid" class="form-label">Category</label>
                            <select id="categoryid" name="categoryid" class="form-select">
                                <option value="">Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->categoryname }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('categoryid')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" name="description" class="form-control">{{ old('description') }}</textarea>
                            <span class="text-danger">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="is_active" class="form-label">Is Active</label>
                            <select class="form-select mb-3" id="is_active" name="is_active">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <span class="text-danger">
                            @error('is_active')
                                {{ $message }}
                            @enderror
                        </span>

                        <div class="col-md-4">
                            <label for="base_price" class="form-label">Base Price</label>
                            <input class="form-control" type="text" name="base_price" id="base_price"
                                value="{{ old('base_price') }}">
                            <span class="text-danger">
                                @error('base_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="discount_amt" class="form-label">Discount Amount</label>
                            <input class="form-control" type="text" name="discount_amt" id="discount_amt"
                                value="{{ old('discount_amt') }}">
                            <span class="text-danger">
                                @error('discount_amt')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tax_price" class="form-label">Tax Price</label>
                            <input class="form-control" type="text" name="tax_price" id="tax_price"
                                value="{{ old('tax_price') }}">
                            <span class="text-danger">
                                @error('tax_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="mrp" class="form-label">MRP</label>
                            <input class="form-control" type="text" name="mrp" id="mrp"
                                value="{{ old('mrp') }}">
                            <span class="text-danger">
                                @error('mrp')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
                <div id="additional-blocks">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="button" id="add-block" class="btn btn-secondary shadow-none me-5">Add
                            Block</button>
                    </div>
                    <div class="row border p-3 mb-5 me-5 ms-5 mt-2 dynamic-block">
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="slug" class="form-label">Slug</label>
                                <input class="form-control" type="text" name="slug[]" id="slug"
                                    value={{ old('slug')[0] ?? '' }}>
                                <span class="text-danger">
                                    @error('slug')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-2">
                                <label for="quantity" class="form-label">Opening Stock</label>
                                <input class="form-control " type="text" name="quantity[]" id="quantity"
                                    value={{ old('quantity')[0] ?? '' }}>
                                <span class="text-danger">
                                    @error('quantity')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-5">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" name="image[]" id="image"
                                    value={{ old('image')[0] ?? '' }}>
                                <span class="text-danger">
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </span>
                                <img id="imagePreview" src="" alt="Selected Image"
                                    style="display: none; margin-top: 10px; max-width: 25%;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="sku" class="form-label">SKU</label>
                                <select id="sku" name="sku[]" class="form-select">
                                    <option value="">Select</option>
                                    @foreach ($skus as $sku)
                                        <option value="{{ $sku->id }}">{{ $sku->prefix }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @error('sku')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-3">
                                <label for="color" class="form-label">Color</label>
                                <input class="form-control " type="text" name="color[]" id="color"
                                    value={{ old('color')[0] ?? '' }}>
                                <span class="text-danger">
                                    @error('color')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-3">
                                <label for="size" class="form-label">Size</label>
                                <input class="form-control " type="text" name="size[]" id="size"
                                    value={{ old('size')[0] ?? '' }}>
                                <span class="text-danger">
                                    @error('size')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        {{--  <div class="row mb-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger remove-block">Remove Block</button>
                            </div>
                        </div>  --}}
                    </div>
                </div>

                <div class="row d-flex justify-content-end mb-5">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-block').addEventListener('click', function() {
            var newBlock = document.createElement('div');
            newBlock.classList.add('row', 'border', 'p-3', 'm-5', 'dynamic-block');
            newBlock.innerHTML = `
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="slug" class="form-label">Slug</label>
                        <input class="form-control " type="text" name="slug[]" id="slug">
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-2">
                        <label for="quantity" class="form-label">Opening Stock</label>
                        <input class="form-control" type="text" name="quantity[]" id="quantity">
                        <span class="text-danger"></span>
                    </div>
                     <div class="col-md-4">
                        <label for="image" class="form-label">Image</label>
                        <input class="form-control" type="file" name="image[]" id="image">
                        <span class="text-danger"></span>
                         <img id="imagePreview" src="" alt="Selected Image" style="display: none; margin-top: 10px; max-width: 100%;">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="sku" class="form-label">SKU</label>
                        <select id="sku" name="sku[]" class="form-select ">
                            <option value="">Select</option>
                            @foreach ($skus as $sku)
                                <option value="{{ $sku->id }}">{{ $sku->prefix }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('sku')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-3">
                        <label for="color" class="form-label">Color</label>
                        <input class="form-control " type="text" name="color[]" id="color">
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="size" class="form-label">Size</label>
                        <input class="form-control " type="text" name="size[]" id="size">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-danger remove-block">Remove Block</button>
                    </div>
                </div>
            `;
            document.getElementById('additional-blocks').appendChild(newBlock);
        });

        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('remove-block')) {
                event.target.closest('.dynamic-block').remove();
            }
        });

        // image code
        document.getElementById('image').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    </script>
@endsection
