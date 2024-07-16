@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="col-lg-11 d-flex justify-content-end ">
            <span style="float:right;"><a href="{{ route('admin.home') }}" class="btn btn-primary">Back</a></span>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Stock Edit</div>
                    <div class="card-body p-3">
                        <form action="{{ route('product-stock.update', $productStock->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="hidden" name="pstockid" value="{{ $productStock->product->id }}">
                                    <label for="quantity" class="form-label">Opening Stock</label>
                                    <input class="form-control" type="text" name="quantity" id="quantity"
                                        value="{{ $productStock->quantity }}" readonly>
            
                                    <span class="text-danger">
                                        @error('quantity')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <label for="newstock" class="form-label">New Stock</label>
                                    <input class="form-control" type="text" name="newstock" id="newstock">
                                    <span class="text-danger">
                                        @error('newstock')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select mb-3" id="type" name="type">
                                        <option value="in">In</option>
                                        <option value="out">Out</option>
                                        <option value="adjust">Adjust</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
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
                            <div class="row mt-3">
                                <div class="col d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  <div class="container">
        <div class="row">
            <h2>Edit Stock</h2>
        </div>
        <div class="row">
            <form action="{{ route('product-stock.update', $productStock->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="hidden" name="pstockid" value="{{ $productStock->product->id }}">
                        <label for="quantity" class="form-label">Opening Stock</label>
                        <input class="form-control" type="text" name="quantity" id="quantity"
                            value="{{ $productStock->quantity }}" readonly>

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
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select mb-3" id="type" name="type">
                            <option value="in">In</option>
                            <option value="out">Out</option>
                            <option value="adjust">Adjust</option>
                        </select>
                    </div>
                    <div class="col-md-3">
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
            </form>
        </div>
    </div>  --}}
@endsection
