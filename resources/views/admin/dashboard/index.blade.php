@extends('layouts.app')

@section('content')
<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1">Welcome!, {{ auth()->user()->name }}</h4>
                <p class="text-muted mb-3">Here is the latest information about your account.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total User</p>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-0 mt-2">242</h4>
                        <a href="" class="text-decoration-underline fs-14">View details</a>
                    </div>
                    <div>
                        <lord-icon src="https://cdn.lordicon.com/tebysptx.json" trigger="loop" style="width:60px;height:60px">
                        </lord-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Session</p>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-0 mt-2">242</h4>
                        <a href="" class="text-decoration-underline fs-14">View details</a>
                    </div>
                    <div>
                        <lord-icon src="https://cdn.lordicon.com/warimioc.json" trigger="loop" state="loop-oscillate" style="width:60px;height:60px">
                        </lord-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Question</p>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-0 mt-2">242</h4>
                        <a href="" class="text-decoration-underline fs-14">View details</a>
                    </div>
                    <div>
                        <lord-icon src="https://cdn.lordicon.com/fjvfsqea.json" trigger="loop" style="width:60px;height:60px">
                        </lord-icon>
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