@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="col-lg-11 d-flex justify-content-end ">
            <span style="float:right;"><a href="{{ route('user.index') }}" class="btn btn-primary">Back</a></span>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Edit</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update', $user->id) }}">
                            @csrf
                            <div class="row mb-3 pt-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ $user->name }}" autocomplete="name">

                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $user->email }}" autocomplete="email">

                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="contact" class="col-md-4 col-form-label text-md-end">Contact</label>

                                <div class="col-md-6">
                                    <input id="contact" type="text" class="form-control" name="contact"
                                        value="{{ $user->contact }}" autocomplete="contact">

                                    <span class="text-danger">
                                        @error('contact')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6 offset-md-4 my-3">
                                    <button type="submit" class="btn btn-primary">
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
