@extends('layouts.app')

@section('content')
    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ asset('assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="p-4 card-body">
                    <div class="text-center">
                        <div class="mx-auto mb-4 profile-user position-relative d-inline-block">
                            <img src="https://www.casperproject.my.id/storage/profile/default.jpg"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow"
                                alt="user-profile-image">
                        </div>
                        <h5 class="mb-1 fs-16">{{ auth()->user()->name }}</h5>
                        <p class="mb-0 text-muted">{{ auth()->user()->programStudy->name ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="rounded nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab"
                                aria-selected="true">
                                <i class="fas fa-home"></i> Personal Details
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab"
                                aria-selected="false" tabindex="-1">
                                <i class="far fa-user"></i> Change Password
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="p-4 card-body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="personalDetails" role="tabpanel">
                            <form
                                action="{{ route(strtolower(auth()->user()->role->name) . '.profile.update', auth()->user()->id) }}"
                                method="POST" data-reset="false">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input label="Name" type="text" name="name"
                                                value="{{ auth()->user()->name }}" attr="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input label="Identity" type="text" name="identity"
                                                value="{{ auth()->user()->identity }}" attr="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input label="Email" type="email" name="email"
                                                value="{{ auth()->user()->email }}" :isRequired="false" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input label="Date of Birth" type="date" name="birthday"
                                                value="{{ auth()->user()->birthday }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-select name="gender" label="Gender" id="gender_update" :options="$gender"
                                                selected="{{ auth()->user()->gender }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-select name="program_study" label="Program Study" id="program_study"
                                                :options="$programStudy" selected="{{ auth()->user()->program_study_id }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 d-flex justify-content-end gap-2 m-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="{{ route(strtolower(auth()->user()->role->name) . '.profile.store') }}">
                                @csrf
                                <div class="mb-3 row g-2">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="password-input">Old Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" name="old_password"
                                                class="form-control pe-5 password-input " placeholder="Enter password"
                                                id="password-input">
                                            <button
                                                class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="align-middle ri-eye-fill"></i></button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <div class="mb-3 row g-2">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="new-password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" name="password"
                                                class="form-control pe-5 password-input " placeholder="Enter password"
                                                id="new-password-input">
                                            <button
                                                class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="align-middle ri-eye-fill"></i></button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <label class="form-label" for="current-password-input">Confirm Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" name="confirm_password"
                                                class="form-control pe-5 password-input " placeholder="Enter password"
                                                id="current-password-input">
                                            <button
                                                class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="align-middle ri-eye-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/pages/password-addon.init.js') }}"></script>
@endpush
