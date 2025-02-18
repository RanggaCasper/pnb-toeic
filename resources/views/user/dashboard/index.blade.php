@extends('layouts.app')

@section('content')
<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1">Welcome!, {{ auth()->user()->name }}</h4>
                <p class="text-muted mb-0">Here is the latest information about your account.</p>
            </div>
        </div>
    </div>
</div>
@endsection