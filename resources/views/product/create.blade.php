@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row p-2" style="background-color: #fff">
            <div class="col-md-6">
                <h4 class="pt-2">Create Product</h4>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <span style="float:right;"><a href="{{ route('product.index') }}"
                        class="btn btn-primary shadow-none">Back</a></span>
            </div>
        </div>
        <div class="row" style="background-color: #fff">
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
                            <input class="form-control" type="file" name="main_image" id="main_image"
                                onchange="previewImage(event)">
                            <span class="text-danger">
                                @error('main_image')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- Thumbnail preview -->
                            <img id="thumbnail" src="#" alt="Image Preview"
                                style="display: none; margin-top: 10px; max-width: 100px; max-height: 100px;">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="categoryid" class="form-label">Category</label>
                            <select id="categoryid" name="categoryid" class="form-select">
                                <option disabled selected>Select</option>
                                @foreach ($categories as $category)
                                    @if ($category->is_parent == 1)
                                        <option value="{{ $category->id }}"
                                            {{ old('categoryid') == $category->id ? 'selected' : '' }}>
                                            {{ $category->categoryname }}
                                        </option>
                                        @if ($category->children->isNotEmpty())
                                            @foreach ($category->children as $child)
                                                <option value="{{ $child->id }}"
                                                    {{ old('categoryid') == $child->id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;&nbsp;&nbsp; - {{ $child->categoryname }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endif
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
                            <input type="hidden" name="is_active" value="No">
                            <input type="checkbox" id="is_active" name="is_active" value="Yes"
                                {{ old('is_active') === 'Yes' ? 'checked' : '' }} checked>
                            <label for="is_active" class="form-label ms-2">Is Active</label>
                        </div>

                        <span class="text-danger">
                            @error('is_active')
                                {{ $message }}
                            @enderror
                        </span>

                        <div class="col-md-6">
                            <label for="base_price" class="form-label">Base Price</label>
                            <input class="form-control" type="text" name="base_price" id="base_price"
                                value="{{ old('base_price') }}">
                            <span class="text-danger">
                                @error('base_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label for="tax_price" class="form-label">Tax Price</label>
                            <input class="form-control" type="text" name="tax_price" id="tax_price"
                                value="{{ old('tax_price') }}">
                            <span class="text-danger">
                                @error('tax_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="mrp" class="form-label">MRP</label>
                            <input class="form-disabled form-control" type="text" readonly name="mrp" id="mrp"
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
                        <button type="button" id="add-block" class="btn btn-secondary shadow-none me-5">Add Block</button>
                    </div>

                    <div class="row border border-dark p-3 m-3 single-product">
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="slug" class="form-label">Slug</label>
                                <input class="form-control slug" type="text" name="sku[slug][]" id="slug">
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="quantity" class="form-label">Opening Stock</label>
                                <input class="form-control" type="text" name="sku[quantity][]" id="quantity">
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-5">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control image-input" type="file" name="sku[image][]" id="image">
                                <span class="text-danger"></span>
                                <img class="image-preview" src="" alt="Selected Image" style="display: none; margin-top: 10px; max-width: 100%;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="sku" class="form-label">SKU</label>
                                <select class="form-select sku-input" name="sku[sku][]">
                                    <option value="">Select</option>
                                    @foreach ($skus as $sku)
                                        <option value="{{ $sku->prefix }}" data-color="{{ $sku->colorname }}">{{ $sku->prefix }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-3">
                                <label for="color" class="form-label">Color</label>
                                <input class="form-control color-input" type="text" name="sku[color][]" id="color" readonly>
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-3">
                                <label for="size" class="form-label">Size</label>
                                <input class="form-control" type="text" name="sku[size][]" id="size">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                @if (!empty(old('sku')['slug']) && count(old('sku')['slug']) > 1)
                    @for ($i = 1; $i < count(old('sku')['slug']); $i++)
                        @if (!empty(old('sku')['slug'][$i]) && !empty(old('sku')['quantity'][$i]) && !empty(old('sku')['sku'][$i]) && !empty(old('sku')['color'][$i]))
                            <div class="row border border-dark p-3 m-3 dynamic-block single-product">
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input class="form-control slug" type="text" name="sku[slug][{{ $i }}]" id="slug" value="{{ old('sku')['slug'][$i] ?? '' }}">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity" class="form-label">Opening Stock</label>
                                        <input class="form-control" type="text" name="sku[quantity][{{ $i }}]" id="quantity" value="{{ old('sku')['quantity'][$i] ?? '' }}">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="image" class="form-label">Image</label>
                                        <input class="form-control image-input" type="file" name="sku[image][{{ $i }}]" id="image">
                                        <span class="text-danger"></span>
                                        <img class="image-preview" src="" alt="Selected Image" style="display: none; margin-top: 10px; max-width: 100%;">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="sku" class="form-label">SKU</label>
                                        <select class="form-select sku-input" name="sku[sku][]">
                                            <option value="">Select</option>
                                            @foreach ($skus as $sku)
                                                <option value="{{ $sku->prefix }}" data-color="{{ $sku->colorname }}" {{ old('sku')['sku'][$i] == $sku->prefix ? 'selected' : '' }}>
                                                    {{ $sku->prefix }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="color" class="form-label">Color</label>
                                        <input class="form-control color-input" type="text" name="sku[color][]" id="color" value="{{ old('sku')['color'][$i] ?? '' }}" readonly>
                                        <span class="text-danger"></span>
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

    @section('script')
    <script>
        // Get references to the input fields
        const basePriceInput = document.getElementById('base_price');
        const discountAmtInput = document.getElementById('discount_amt');
        const taxPriceInput = document.getElementById('tax_price');
        const mrpInput = document.getElementById('mrp');
    
function calculateMRP() {
            const basePrice = parseFloat(basePriceInput.value) || 0;
            const discountAmt = parseFloat(discountAmtInput.value) || 0;
            const taxPrice = parseFloat(taxPriceInput.value) || 0;
            const mrp = basePrice - discountAmt + taxPrice;
            
            mrpInput.value = mrp.toFixed(2); // Ensure two decimal places
        }
    
        basePriceInput.addEventListener('input', calculateMRP);
        discountAmtInput.addEventListener('input', calculateMRP);
        taxPriceInput.addEventListener('input', calculateMRP);
    </script>
        <script>
            document.getElementById('add-block').addEventListener('click', function() {
                var newBlock = document.createElement('div');
                newBlock.classList.add('row', 'border', 'border-dark', 'p-3', 'm-3', 'dynamic-block', 'single-product');
                newBlock.innerHTML = `
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="slug" class="form-label">Slug</label>
                            <input class="form-control slug" type="text" name="sku[slug][]" id="slug">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-2">
                            <label for="quantity" class="form-label">Opening Stock</label>
                            <input class="form-control" type="text" name="sku[quantity][]" id="quantity">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-5">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control image-input" type="file" name="sku[image][]" id="image">
                            <span class="text-danger"></span>
                            <img class="image-preview" src="" alt="Selected Image" style="display: none; margin-top: 10px; max-width: 100%;">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="sku" class="form-label">SKU</label>
                            <select class="form-select sku-input" name="sku[sku][]">
                                <option value="">Select</option>
                                @foreach ($skus as $sku)
                                    <option value="{{ $sku->prefix }}" data-color="{{ $sku->colorname }}">{{ $sku->prefix }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="color" class="form-label">Color</label>
                            <input class="form-control color-input" type="text" name="sku[color][]" id="color" readonly>
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="size" class="form-label">Size</label>
                            <input class="form-control" type="text" name="sku[size][]" id="size">
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

            // Remove Block
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-block')) {
                    e.target.closest('.dynamic-block').remove();
                }
            });

            // Convert Spaces to Dashes
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('slug')) {
                    var slug = e.target.value;
                    slug = slug.replace(/\s+/g, '-').toLowerCase();
                    e.target.value = slug;
                }
            });

            // Handle Image Preview
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('image-input')) {
                    var input = e.target;
                    var preview = input.closest('.single-product').querySelector('.image-preview');
                    var file = input.files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = '';
                        preview.style.display = 'none';
                    }
                }
            });

            // Update Color Based on SKU Selection
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('sku-input')) {
                    var selectedOption = e.target.options[e.target.selectedIndex];
                    var colorInput = e.target.closest('.single-product').querySelector('.color-input');
                    colorInput.value = selectedOption.getAttribute('data-color');
                }
            });
        </script>
    @endsection
@endsection
