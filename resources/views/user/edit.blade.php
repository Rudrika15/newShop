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
                            <div class="row mb-3">
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
                            {{--  @if ($user->type != 'admin')
                                <div class="row mb-3">
                                    <label for="old_password" class="col-md-4 col-form-label text-md-end">Old
                                        Password</label>

                                    <div class="col-md-6">
                                        <input id="old_password" type="password" class="form-control" name="old_password"
                                            autocomplete="old_password">

                                        <span class="text-danger">
                                            @error('old_password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            @endif  --}}
                            {{--  <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password"
                                        autocomplete="password">

                                    <span class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">Confirm
                                    Password</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control"
                                        name="password_confirmation" value="" autocomplete="password_confirmation">

                                    <span class="text-danger">
                                        @error('password_confirmation')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>  --}}

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6 offset-md-4">
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
