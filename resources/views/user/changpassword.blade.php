@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="col-lg-11 d-flex justify-content-end ">
            <span style="float:right;"><a href="{{ route('user.index') }}" class="btn btn-primary">Back</a></span>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forggot Password</div>
                    <div class="card-body m-2">
                        <form method="POST" action="{{ route('user.updatepassword', $user->id) }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Enter New Password</label>

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
                            </div>

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
