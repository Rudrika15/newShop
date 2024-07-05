@extends('layouts.app2')
@section('content')
    @if ($message = Session::get('success'))
        <div class="col-lg-6 alert alert-success" id="successMessage">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>
                            <h2>Profile</h2>
                        </strong>
                    </div>
                    <div class="card-body p-5">
                        <div class="row ">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $user->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $user->contact }}</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center mt-4">
                            <div class="col-md-6 offset-md-3">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Update Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
