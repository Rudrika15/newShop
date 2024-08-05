@extends('layouts.app2')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between  mb-3">
                            <div class="p-2 fs-4"> Category edit</div>

                            <div class="p-2 ">
                                <a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('category.update', $category->id) }}">
                            @csrf
                            <div class="form-group mb-3 pt-2">
                                <label for="categoryname" class="form-label">Category Name</label>
                                <input type="text" id="categoryname" name="categoryname" class="form-control mt-2"
                                    value="{{ $category->categoryname }}">
                                @error('categoryname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <input type="checkbox" id="is_parent" name="is_parent" value="1"
                                    {{ old('is_parent', $category->is_parent) ? 'checked' : '' }}>
                                <label for="is_parent" class="form-label"> Is Parent</label>
                            </div>

                            <div class="form-group mb-4">
                                <label for="parent" class="form-label">Parent Category</label>
                                <select class="form-control" id="parent" name="parent"
                                    {{ old('is_parent', $category->is_parent) ? 'disabled' : '' }}>
                                    <option value="">Select Parent Category</option>
                                    @foreach ($categories as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent', $category->parent) == $parent->id ? 'selected' : '' }}>
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
                            <div class="row d-flex justify-content-center my-3">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
