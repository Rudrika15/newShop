@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-md-6">
                    <h4>Edit Product</h4>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center mb-2">
                    <span style="float:right;"><a href="{{ route('product.index') }}"
                            class="btn btn-primary shadow-none ms-2">Back</a>
                    </span>
                </div>
            </div>
            <div class="row border border-3 p-3">
                {{--  <h1>Edit Product</h1>  --}}
                <form method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{--  <div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sku">SKU</label>
                                <input type="text" class="form-control" id="sku" name="sku"
                                    value="{{ $product->sku }}">
                                <span class="text-danger">
                                    @error('sku')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="categoryid">Category ID</label>
                            <input type="text" class="form-control" id="categoryid" name="categoryid"
                                value="{{ $product->categoryid }}">
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ $product->slug }}">
                        </div>

                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" class="form-control" id="color" name="color"
                                value="{{ $product->color }}">
                        </div>

                        <div class="form-group">
                            <label for="size">Size</label>
                            <input type="text" class="form-control" id="size" name="size"
                                value="{{ $product->size }}">
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <img src="{{ asset('images/' . $product->image) }}" width="50" height="50">
                        </div>

                        <div class="form-group">
                            <label for="opening_stock">Opening Stock</label>
                            <input type="number" class="form-control" id="opening_stock" name="opening_stock"
                                value="{{ $product->opening_stock }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="discount_amt">Discount Amount</label>
                            <input type="number" class="form-control" id="discount_amt" name="discount_amt"
                                value="{{ $product->discount_amt }}">
                        </div>

                        <div class="form-group">
                            <label for="mrp">MRP</label>
                            <input type="number" class="form-control" id="mrp" name="mrp"
                                value="{{ $product->mrp }}">
                        </div>

                        <div class="form-group">
                            <label for="is_active">Is Active</label>
                            <select class="form-control" id="is_active" name="is_active">
                                <option value="1" {{ $product->is_active ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$product->is_active ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>  --}}
                    <div class="row border p-3 m-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title">Catalog Name</label>
                                <input class="form-control mt-2" type="text" name="title" id="title"
                                    value="{{ $product->catalog->title }}" readonly>
                                <span class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="main_image">Main Image</label>
                                <input class="form-control my-2" type="file" name="main_image" id="main_image">
                                <img src="{{ asset('images/main_images/' . $product->image) }}" width="50"
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
                                <label for="categoryid">Category</label>
                                <select id="categoryid" name="categoryid" class="form-select">
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
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" name="description" class="form-control mt-2">{{ $product->description }}</textarea>
                                <span class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="mb-2">Image</label>
                                <input class="form-control mt-2" type="file" name="image" id="image">
                                <span class="text-danger">
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="is_active">Is Active</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="Yes" {{ $product->is_active ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ !$product->is_active ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <span class="text-danger">
                                @error('is_active')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="base_price">Base Price</label>
                                <input class="form-control mt-2" type="text" name="base_price" id="base_price"
                                    value="{{ $product->base_price }}">
                                <span class="text-danger">
                                    @error('base_price')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-4">
                                <label for="tax_price">Tex Price</label>
                                <input class="form-control mt-2" type="text" name="tax_price" id="tax_price"
                                    value="{{ $product->tax_price }}">
                                <span class="text-danger">
                                    @error('tax_price')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="opening_stock">Opening Stock</label>
                                <input class="form-control mt-2" type="text" name="opening_stock" id="opening_stock"
                                    value="{{ $product->opening_stock }}">
                                <span class="text-danger">
                                    @error('opening_stock')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-4">
                                <label for="mrp">MRP</label>
                                <input class="form-control mt-2" type="text" name="mrp" id="mrp"
                                    value="{{ $product->mrp }}">
                                <span class="text-danger">
                                    @error('mrp')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-4">
                                <label for="discount_amt">Discount Amount</label>
                                <input class="form-control mt-2" type="text" name="discount_amt" id="discount_amt"
                                    value="{{ $product->discount_amt }}">
                                <span class="text-danger">
                                    @error('discount_amt')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row border p-3 m-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sku">SKU</label>
                                <select id="sku" name="sku" class="form-select">
                                    @foreach ($skus as $sku)
                                        <option value="{{ $sku->id }}"
                                            {{ $product->sku == $sku->id ? 'selected' : '' }}>
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
                            <div class="col-md-6">
                                <label for="slug">Slug</label>
                                <input class="form-control mt-2" type="text" name="slug" id="slug"
                                    value="{{ $product->slug }}">
                                <span class="text-danger">
                                    @error('slug')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="color">Color</label>
                                <input class="form-control mt-2" type="text" name="color" id="color"
                                    value="{{ $product->color }}">
                                <span class="text-danger">
                                    @error('color')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="size">Size</label>
                                <input class="form-control mt-2" type="text" name="size" id="size"
                                    value="{{ $product->size }}">
                                <span class="text-danger">
                                    @error('size')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 ">
                        <div class="col d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
