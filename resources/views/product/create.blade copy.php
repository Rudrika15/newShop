@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Create Product</h4>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center mb-2">
                <span style="float:right;"><a href="{{ route('product.index') }}"
                        class="btn btn-primary shadow-none ms-2">Back</a>
                </span>
            </div>
        </div>
        <div class="row border border-3">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row border  p-3 m-5">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title">Catalog Name</label>
                            <input class="form-control mt-2" type="text" name="title" id="title"
                                value="{{ old('title') }}">
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="main_image">Main Image</label>
                            <input class="form-control mt-2" type="file" name="main_image" id="main_image">
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
                            <select id="categoryid" name="categoryid" class="form-select mt-2">
                                <option value="">Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->categoryname }}
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
                            <textarea type="text" name="description" class="form-control">{{ old('description') }} </textarea>
                            <span class="text-danger">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="is_active">Is Active</label>
                            <select class="form-select mb-2" id="is_active" name="is_active" required>
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
                            <label for="mrp">MRP</label>
                            <input class="form-control mt-2" type="text" name="mrp" id="mrp"
                                value="{{ old('mrp') }}">
                            <span class="text-danger">
                                @error('mrp')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="discount_amt">Discount Amount</label>
                            <input class="form-control mt-2" type="text" name="discount_amt" id="discount_amt"
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
                            <label for="base_price">Base Price</label>
                            <input class="form-control mt-2" type="text" name="base_price" id="base_price"
                                value="{{ old('base_price') }}">
                            <span class="text-danger">
                                @error('base_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label for="tax_price">Tex Price</label>
                            <input class="form-control mt-2" type="text" name="tax_price" id="tax_price"
                                value="{{ old('tax_price') }}">
                            <span class="text-danger">
                                @error('tax_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row border  p-3 m-5">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sku">SKU</label>
                            <select id="sku" name="sku" class="form-select mt-2">
                                <option value="">Select</option>
                                @foreach ($skus as $sku)
                                    <option value="{{ $sku->id }}">{{ $sku->prefix }} </option>
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
                                value="{{ old('slug') }}">
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
                                value="{{ old('color') }}">
                            <span class="text-danger">
                                @error('color')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="size">Size</label>
                            <input class="form-control mt-2" type="text" name="size" id="size"
                                value="{{ old('size') }}">
                            <span class="text-danger">
                                @error('size')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="opening_stock">Opening Stock</label>
                            <input class="form-control mt-2" type="text" name="opening_stock" id="opening_stock"
                                value="{{ old('opening_stock') }}">
                            <span class="text-danger">
                                @error('opening_stock')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="image" class="mb-2">Image</label>
                            <input class="form-control" type="file" name="image" id="image">
                            <span class="text-danger">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row my-5 ">
                    <div class="col d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary shadow-none"> Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
