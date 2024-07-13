@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row py-2" style="background-color: rgb(155, 191, 212)">
            <div class="col-md-6">
                <h4>Create Product</h4>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <span style="float:right;"><a href="{{ route('product.index') }}"
                        class="btn btn-primary shadow-none">Back</a></span>
            </div>
        </div>
        <div class="row" style="background-color: rgb(237, 223, 201)">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row border border-dark p-3 m-3">
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
                            Block
                            {{--  {{ count(old('sku')['slug'] ?? []) }}  --}}
                        </button>
                    </div>
                    <div class="row border border-dark p-3 m-3 single-product">
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="slug" class="form-label">Slug</label>
                                <input class="form-control" type="text" name="sku[slug][]" id="slug"
                                    value={{ old('sku')['slug'][0] ?? '' }}>
                                <span class="text-danger">
                                    @error('slug')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-2">
                                <label for="quantity" class="form-label">Opening Stock</label>
                                <input class="form-control " type="text" name="sku[quantity][]" id="quantity"
                                    value={{ old('sku')['quantity'][0] ?? '' }}>
                                <span class="text-danger">
                                    @error('quantity')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-5">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" name="sku[image][]" id="image"
                                    value={{ old('sku')['image'][0] ?? '' }}>
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
                                <select id="sku" name="sku[sku][]" class="form-select sku-input">
                                    <option value="">Select</option>
                                    @foreach ($skus as $sku)
                                        <option value="{{ $sku->prefix }}" data-color="{{ $sku->colorname }}"
                                            {{ isset(old('sku')['sku'][0]) && old('sku')['sku'][0] == $sku->prefix ? 'selected' : '' }}>
                                            {{ $sku->prefix }}
                                        </option>
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
                                <input class="form-control color-input" type="text" name="sku[color][]"
                                    id="color" value="{{ old('sku')['color'][0] ?? '' }}" readonly>
                                <span class="text-danger">
                                    @error('color')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>


                            <div class="col-md-3">
                                <label for="size" class="form-label">Size</label>
                                <input class="form-control " type="text" name="sku[size][]" id="size"
                                    value={{ old('sku')['size'][0] ?? '' }}>
                                <span class="text-danger">
                                    @error('size')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if (!empty(old('sku')['slug']) && count(old('sku')['slug']) > 1)
                    @for ($i = 1; $i < count(old('sku')['slug']); $i++)
                        @if (
                            !empty(old('sku')['slug'][$i]) &&
                                !empty(old('sku')['quantity'][$i]) &&
                                !empty(old('sku')['sku'][$i]) &&
                                !empty(old('sku')['color'][$i]))
                            <div class="row border border-dark p-3 m-3 dynamic-block single-product">
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input class="form-control " type="text"
                                            name="sku[slug][{{ $i }}]" id="slug"
                                            value="{{ old('sku')['slug'][$i] ?? '' }}">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity" class="form-label">Opening Stock</label>
                                        <input class="form-control" type="text"
                                            name="sku[quantity][{{ $i }}]" id="quantity"
                                            value="{{ old('sku')['quantity'][$i] ?? '' }}">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="image" class="form-label">Image</label>
                                        <input class="form-control" type="file"
                                            name="sku[image][{{ $i }}]" id="image"
                                            value="{{ old('sku')['image'][$i] ?? '' }}">
                                        <span class="text-danger"></span>
                                        <img id="imagePreview" src="" alt="Selected Image"
                                            style="display: none; margin-top: 10px; max-width: 100%;">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="sku" class="form-label">SKU</label>
                                        <select id="sku" name="sku[sku][]" class="form-select sku-input">
                                            <option value="">Select</option>
                                            @foreach ($skus as $sku)
                                                <option value="{{ $sku->prefix }}" data-color="{{ $sku->colorname }}"
                                                    {{ isset(old('sku')['sku'][0]) && old('sku')['sku'][0] == $sku->prefix ? 'selected' : '' }}>
                                                    {{ $sku->prefix }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('sku')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="color" class="form-label color-input">Color</label>
                                        <input class="form-control" type="text" name="sku[color][]" id="color"
                                            value="{{ old('sku')['color'][0] ?? '' }}" readonly>
                                        <span class="text-danger">
                                            @error('color')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger remove-block">Remove Block</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor
                @endif
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
            newBlock.classList.add('row', 'border', 'border-dark', 'p-3', 'm-3', 'dynamic-block', 'single-product');
            newBlock.innerHTML = `
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="slug" class="form-label">Slug</label>
                        <input class="form-control " type="text" name="sku[slug][]" id="slug">
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-2">
                        <label for="quantity" class="form-label">Opening Stock</label>
                        <input class="form-control" type="text" name="sku[quantity][]" id="quantity">
                        <span class="text-danger"></span>
                    </div>
                     <div class="col-md-4">
                        <label for="image" class="form-label">Image</label>
                        <input class="form-control" type="file" name="sku[image][]" id="image">
                        <span class="text-danger"></span>
                         <img id="imagePreview" src="" alt="Selected Image" style="display: none; margin-top: 10px; max-width: 100%;">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="sku" class="form-label">SKU</label>
                        <select id="sku" name="sku[sku][]" class="form-select sku-input" >
                                    <option value="">Select</option>
                                    @foreach ($skus as $sku)
                                        <option value="{{ $sku->prefix }}" data-color="{{ $sku->colorname }}" {{ isset(old('sku')['sku'][0]) && old('sku')['sku'][0] == $sku->prefix ? 'selected' : '' }}>{{ $sku->prefix }}</option>
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
                        <input class="form-control color-input" type="text" name="sku[color][]" id="color" readonly>
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-3">
                        <label for="size" class="form-label">Size</label>
                        <input class="form-control " type="text" name="sku[size][]" id="size">
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
@section('script')
    <script>
        $(document).on('change', '.sku-input', function() {
            $(this).parents('.single-product').find('.color-input').val($(this).find(':selected').data('color'));
        })
    </script>
@endsection
