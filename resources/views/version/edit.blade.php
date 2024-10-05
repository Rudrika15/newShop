@extends('layouts.app2')

@section('content')
    <div class="conatinter">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between  mb-3">
                        <div class="p-2 fs-4"> Version Edit</div>

                        <div class="p-2 ">
                            <a href="{{ route('version.index') }}" class="btn btn-primary">Back</a>
                        </div>

                    </div>
                    <div class="card-body py-3">
                        <form method="POST" action="{{ route('version.update') }}" >
                            @csrf
                            <div class="row mb-3">
                                <div class="row mb-3">
                                    <label for="version" class="form-label">Version</label>
                                    <input class="form-control mb-2" value="{{$version->version}}" type="text" name="version" id="version">
                                    <span class="text-danger">
                                        @error('version')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="">
                                    <label for="major" >Major</label>
                                    @if($version->major == 1)
                                    <input  type="radio" name="major" checked value="1"> Yes
                                    <input type="radio" name="major" value="0">No 
                                    @else
                                    <input  type="radio" name="major"  value="1"> Yes
                                    <input type="radio" name="major" checked value="0">No 
@endif
                                    <span class="text-danger">
                                        @error('major')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="row mb-3">
                                    <label for="Link" class="form-label">Link</label>
                                    <input class="form-control mb-2" type="text" name="url" id="url">
                                    <span class="text-danger">
                                        @error('url')
                                            {{ $message }}
                                        @enderror
                                    </span>
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
