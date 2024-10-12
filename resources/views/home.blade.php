@extends('layouts.app')
<<<<<<< HEAD

=======
  
>>>>>>> 9c148faa03373b20c85430f50b589470dd4cfe44
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>You are a User.</h2>
                    {{-- <h2>You are a User.</h2> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection