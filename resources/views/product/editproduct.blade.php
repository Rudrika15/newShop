@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row py-2" style="background-color: #D6EFD8">
            <div class="col-md-6">
                <h2>Edit Product</h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <span style="float:right;"><a onclick="history.back()" class="btn btn-primary shadow-none">Back</a>
                </span>
            </div>
        </div>
        <div class="row" style="background-color: rgb(236, 236, 236)">
            {{-- <h1>Edit Product</h1> --}}
            <form method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row border border-dark p-3 m-3">
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
                            {{-- <input class="form-control my-2" type="file" name="main_image" id="main_image" readonly>
                        --}}
                            <img src="{{ asset('images/catalog/' . $product->catalog->main_image) }}" width="50"
                                height="50">
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
                            <select id="categoryid" name="categoryid" class="form-select" disabled>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->categoryid == $category->id ? 'selected' : '' }}>
                                        {{ $category->categoryname }}
                                    </option>
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
                            <textarea type="text" name="description" class="form-control">{{ $product->description }}</textarea>
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
                                {{ old('is_active', $product->is_active) === 'Yes' ? 'checked' : '' }}>
                            <label for="is_active" class="form-label">Is Active</label>
                        </div>
                        <span class="text-danger">
                            @error('is_active')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="base_price" class="form-label">Base Price</label>
                            <input class="form-control" type="text" name="base_price" id="base_price"
                                value="{{ $product->base_price }}">
                            <span class="text-danger">
                                @error('base_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="discount_amt" class="form-label">Discount Amount</label>
                            <input class="form-control" type="text" name="discount_amt" id="discount_amt"
                                value="{{ $product->discount_amt }}">
                            <span class="text-danger">
                                @error('discount_amt')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tax_price" class="form-label">Tex Price</label>
                            <input class="form-control" type="text" name="tax_price" id="tax_price"
                                value="{{ $product->tax_price }}">
                            <span class="text-danger">
                                @error('tax_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="mrp" class="form-label">MRP</label>
                            <input class="form-control" type="text" name="mrp" id="mrp"
                                value="{{ $product->mrp }}">
                            <span class="text-danger">
                                @error('mrp')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row border border-dark p-3 m-3">
                    <div class="row mb-3">
                        <div class="col-md-5" class="form-label">
                            <label for="slug" class="form-label">Slug</label>
                            <input class="form-control" type="text" name="slug" id="slug"
                                value="{{ $product->slug }}">
                            <span class="text-danger">
                                @error('slug')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-5">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" name="image" id="image">
                            <span class="text-danger">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-1 ">
                            @if ('{{ $product->image }}')
                                <img src="{{ asset('images/product/' . $product->image) }}" width="70"
                                    height="70"><br>
                            @else
                                <p>No image found</p>
                            @endif

                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="hidden" name="pstockid" value="{{ $product->productStocks->first()->id }}">
                            <label for="quantity" class="form-label">Opening Stock</label>
                            <input class="form-control" type="text" name="quantity" id="quantity"
                                value="{{ $product->productStocks->first()->quantity ?? '' }}" readonly>

                            <span class="text-danger">
                                @error('quantity')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-3">
                            <label for="newstock" class="form-label">New Stock</label>
                            <input class="form-control" type="text" name="newstock" id="newstock">
                            <span class="text-danger">
                                @error('newstock')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-2 additionalFields" style="display: none;">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select mb-3" id="type" name="type">
                                <option value="in">In</option>
                                <option value="out">Out</option>
                                <option value="adjust">Adjust</option>
                            </select>
                        </div>
                        <div class="col-md-3 additionalFields" style="display: none;">
                            <label for="remarks" class="form-label">remarks</label>
                            <input class="form-control" type="text" name="remarks" id="remarks"
                                value="{{ old('remarks') }}">
                            <span class="text-danger">
                                @error('remarks')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="sku" class="form-label">SKU</label>
                            <select id="sku" name="sku" class="form-select sku-input" disabled>
                                @foreach ($skus as $sku)
                                    <option value="{{ $sku->prefix }}" data-color="{{ $sku->colorname }}"
                                        {{ $product->sku == $sku->prefix ? 'selected' : '' }}>
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
                            <input class="form-control color-input" type="text" name="color" id="color"
                                value="{{ $product->color }}" readonly>
                            <span class="text-danger">
                                @error('color')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="size" class="form-label">Size</label>
                            <input class="form-control" type="text" name="size" id="size"
                                value="{{ $product->size }}">
                            <span class="text-danger">
                                @error('size')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-end mb-5">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('change', '.sku-input', function() {
            $(this).parents('.row').find('.color-input').val($(this).find(':selected').data('color'));
        });

        // stock transaction add type and remarks field  code
        $(document).ready(function() {
            $('#newstock').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $('.additionalFields').show();
                } else {
                    $('.additionalFields').hide();
                }
            });
        });
    </script>
@endsection
