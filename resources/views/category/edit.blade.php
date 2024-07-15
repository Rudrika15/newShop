@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="col-lg-10 d-flex justify-content-end align-items-center mb-2">
            <span style="float:right;"><a href="{{ route('category.index') }}" class="btn btn-primary">Back</a></span>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Category Edit</div>
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

                            <div class="form-group mb-3">
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
                            <div class="row d-flex justify-content-center mt-2">
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
