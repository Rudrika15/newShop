@extends('layouts.app2')

@section('content')
    <div class="conatinter">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between  mb-3">
                        <div class="p-2 fs-4"> Slider Create</div>

                        <div class="p-2 ">
                            <a href="{{ route('slider.index') }}" class="btn btn-primary">Back</a>
                        </div>

                    </div>
                    <div class="card-body py-3">
                        <form method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="row mb-3">
                                    <label for="sliderImage" class="form-label">Slider Image</label>
                                    <input class="form-control mb-2" type="file" name="sliderImage" id="sliderImage">
                                    <span class="text-danger">
                                        @error('sliderImage')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="row mb-3">
                                    <label for="check">
                                        <input type="checkbox" name="isNavigate" class="form-check-input" id="check"> Is Navigate
                                    </label>
                                </div>


                                <div id="navDiv" class="d-none">

                                    <label for="sliderName" class="col-form-label ">Slider Name</label>

                                    <div class="col-md-12">
                                        <select id="sliderName"
                                            class="form-control @error('sliderName') is-invalid @enderror" name="catalogId">
                                            <option disabled selected>Select</option>
                                            @foreach ($catalogs as $catalog)
                                                <option value="{{ $catalog->id }}">{{ $catalog->title }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="title" id="title"/>
                                    </div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('sliderName').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex].text;
            document.getElementById('title').value = selectedOption;
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#check').on('change', function() {
            if ($(this).is(':checked')) {
                $('#navDiv').removeClass('d-none');
            } else {
                $('#navDiv').addClass('d-none');
            }
        })
    });
</script>
