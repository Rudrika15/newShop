@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-md-6">
                    <h4>Edit Catalog</h4>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center mb-2">
                    <span style="float:right;"><a onclick="history.back()"
                            class="btn btn-primary shadow-none ms-2">Back</a>
                    </span>
                </div>
            </div>
            <div class="row border border-3 p-3">
                {{--  <h1>Edit Product</h1>  --}}
                <form method="POST" action="{{ route('catalog.update', $catalog->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row border p-3 m-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Catalog Name</label>
                                <input class="form-control" type="text" name="title" id="title"
                                    value="{{ $catalog->title }}">
                                <span class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="main_image" class="form-label">Main Image</label>
                                <input class="form-control my-2" type="file" name="main_image" id="main_image">
                                <img src="{{ asset('images/catalog/' . $catalog->main_image) }}" width="50"
                                    height="50">
                                <span class="text-danger">
                                    @error('main_image')
                                        {{ $message }}
                                    @enderror
                                </span>
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
