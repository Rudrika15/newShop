@extends('layouts.app2')

@section('content')
    <div class="conatinter">
        <div class="col-lg-10 d-flex justify-content-end align-items-center">
            <span style="float:right;"><a href="{{ route('slider.index') }}" class="btn btn-primary">Back</a></span>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Slider Edit</div>
                    <div class="card-body py-3">
                        <form method="POST" action="{{ route('slider.update', $sliders->id) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="sliderName" class="col-md-4 col-form-label text-md-end">Slider Name</label>

                                <div class="col-md-6">
                                    <input id="sliderName" type="text"
                                        class="form-control @error('sliderName') is-invalid @enderror" name="sliderName"
                                        value="{{ $sliders->sliderName }}">

                                    @error('slider')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="sliderImage" class="form-label">Slider Image</label>
                                <input class="form-control mb-2" type="file" name="sliderImage" id="sliderImage">
                                <img src="{{ asset('images/slider/' . $sliders->sliderImage) }}" width="50"
                                    height="50">
                                <span class="text-danger">
                                    @error('sliderImage')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="row d-flex justify-content-center mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary mt-3">
                                        Update
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
