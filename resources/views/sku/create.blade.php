@extends('layouts.app2')

@section('content')
    <div class="conatinter">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between  mb-3">
                        <div class="p-2 fs-4"> SKU Edit</div>

                        <div class="p-2 ">
                            <a href="{{ route('sku.index') }}" class="btn btn-primary">Back</a>
                        </div>

                    </div>
                    <div class="card-body py-3">
                        <form method="POST" action="{{ route('sku.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="prefix" class="col-md-4 col-form-label text-md-end">Prefix</label>

                                <div class="col-md-6">
                                    <input id="prefix" type="text"
                                        class="form-control @error('prefix') is-invalid @enderror" name="prefix"
                                        value="{{ old('prefix') }}">

                                    @error('prefix')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="colorname" class="col-md-4 col-form-label text-md-end">Color Name</label>

                                <div class="col-md-6">
                                    <input id="colorname" type="text"
                                        class="form-control @error('colorname') is-invalid @enderror" name="colorname"
                                        value="{{ old('colorname') }}">

                                    @error('colorname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
