@extends('layouts.app')

@section('content')
<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1">Welcome!, {{ auth()->user()->name }}</h4>
                <p class="text-muted mb-2">Here is the latest information about your account.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="overflow-hidden shadow-none card bg-light-info position-relative">
            <div class="px-4 py-3 card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="fs-2 fw-semibold">Start Certified TOEIC Test</h4>
                        <p class="fs-4">
                            Unlock your potential with the TOEIC test <br>a global standard for English proficiency.
                        </p>
                        <button class="capitalize btn btn-sm waves-effect waves-light btn-primary p-2 fs-6">  Take Full Test</button>
                    </div>
                    <div class="col-4">
                        <div class="text-center mb-n5">  
                            <img src="https://expo2.lab-trpl.id/images/model2.png" alt="" class="" width="350px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-sm-6">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-wrapper ">
                    <lord-icon src="https://cdn.lordicon.com/csxbxlji.json" style="width: 100px; height: 100px;" trigger="loop">
                    </lord-icon>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="text-muted mb-2 mb-md-0">
                            <span class="text-body fs-5">Let's take a Practice</span>
                            <br>
                            <span class="fs-6">Make a bold move before taking the test</span>
                        </div>
                        <a class="btn btn-primary" href="{{route('user.practice.index')}}">
                            Practice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-sm-6">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-wrapper ">
                    <lord-icon src="https://cdn.lordicon.com/edcgvlnw.json" style="width: 100px; height: 100px;" trigger="loop">
                    </lord-icon>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="text-muted mb-2 mb-md-0">
                            <span class="text-body fs-5">Understand About Test</span>
                            <br>
                            <span class="fs-6">Read about test scoring, rules, etc.</span>
                        </div>
                        <a class="btn btn-primary" href="{{route('user.about.index')}}">
                            About Test
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.lordicon.com/lordicon.js"></script>
@endpush
