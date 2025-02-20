@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="mt-4 card">
            <div class="p-4 card-body">
                <div class="mt-2 text-center">
                    <h5 class="text-primary">Welcome Back!</h5>
                    <p class="text-muted">Sign in to continue to {{ config('app.name') }}.</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <x-input label="Identity" type="text" name="identity" id="identity" />
                    </div>
                    
                    <div class="mb-3">
                        <div class="float-end">
                            <a href="{{ route('forgot') }}" class="text-muted">Forgot password?</a>
                        </div>
                        <x-input label="Password" type="password" name="password" id="password" />
                    </div>              
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
