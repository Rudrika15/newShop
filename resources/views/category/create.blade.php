@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="col-lg-10 d-flex justify-content-end align-items-center mb-2">
            <span style="float:right;"><a href="{{ route('category.index') }}" class="btn btn-primary">Back</a></span>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Category Create</div>
                    <div class="card-body ">
                        <form method="POST" action="{{ route('category.store') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="categoryname" class="mt-2">Category Name</label>
                                <input id="categoryname" type="text"
                                    class="form-control @error('categoryname') is-invalid @enderror mt-2"
                                    name="categoryname" value="{{ old('categoryname') }}">
                                @error('categoryname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="checkbox" id="is_parent" name="is_parent" value="1"
                                    {{ old('is_parent', true) ? 'checked' : '' }}>
                                <label for="is_parent">Is Parent</label>
                            </div>
                            <div class="form-group mb-4">
                                <label for="parent">Parent Category</label>
                                <select class="form-control mt-2" id="parent" name="parent"
                                    {{ old('is_parent', true) ? 'disabled' : '' }}>
                                    <option value="">Select Parent Category</option>
                                    @foreach ($categories as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->categoryname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row d-flex justify-content-end my-3">
                                <div class="col-lg-6 d-flex justify-content-end">
                                    <span style="float:right;"><button type="submit"
                                            class="btn btn-primary">Submit</button>
                                    </span>
                                </div>
                                <div class="col-lg-6 d-flex justify-content-start">
                                    <span style="float:right;"><a href="{{ route('category.index') }}"
                                            class="btn btn-danger ">Exit</a>
                                    </span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('is_parent').addEventListener('change', function() {
            document.getElementById('parent').disabled = this.checked;
        });
    </script>
@endsection
