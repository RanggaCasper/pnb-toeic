@extends('layouts.app')

@section('content')
<x-breadcrumb title="Admin" li_1="Menu" />
<x-card title="Manage Admin">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
    <table id="datatables" class="table align-middle nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Identity</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Program Study</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</x-card>

<x-modal id="createModal" centered="true" title="Create Admin" size="lg">
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-input label="Identity" type="text" name="identity" id="identity" />
        </div>
        <div class="mb-3">
            <x-input label="Name" type="text" name="name" id="name" />
        </div>
        <div class="mb-3">
            <x-input label="Email" type="text" name="email" id="email" :isRequired="false" />
        </div>
        <div class="mb-3">
            <x-input label="Birthday" type="date" name="birthday" id="birthday" />
        </div>
        <div class="mb-3">
            <x-select
                name="gender"
                label="Gender"
                id="gender"
                :options="$gender" />
        </div>
        <div class="mb-3">
            <x-select2
                name="program_study"
                label="Program Study"
                id="program_study"
                :options="$programStudy" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update Admin" size="lg">
    <form method="POST" id="form_update">
        @csrf
        @method('put')
        <div class="mb-3">
            <x-input label="Identity" type="text" name="identity" id="identity_update" />
        </div>
        <div class="mb-3">
            <x-input label="Name" type="text" name="name" id="name_update" />
        </div>
        <div class="mb-3">
            <x-input label="Email" type="text" name="email" id="email_update" :isRequired="false" />
        </div>
        <div class="mb-3">
            <x-input label="Birthday" type="date" name="birthday" id="birthday_update" />
        </div>
        <div class="mb-3">
            <x-select
                name="gender"
                label="Gender"
                id="gender_update"
                :options="$gender" />
        </div>
        <div class="mb-3">
            <x-select2
                name="program_study"
                label="Program Study"
                id="program_study_update"
                :options="$programStudy" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>
@endsection

@push('scripts')
<script>
    $('#datatables').DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        ajax: "{{ route('super.admin.get') }}",
        columns: [{
                data: 'no',
                name: 'no'
            },
            {
                data: 'identity',
                name: 'identity'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'birthday',
                name: 'birthday'
            },
            {
                data: 'gender',
                name: 'gender'
            },
            {
                data: 'program_study.name',
                name: 'program_study.name'
            },
            {
                data: 'action',
                name: 'action'
            },
        ],
    });

  
</script>
<x-script.update-swal routeGet="super.admin.getById" routeUpdate="super.admin.update">
    $('#identity_update').val(response.data.identity);
    $('#name_update').val(response.data.name);
    $('#email_update').val(response.data.email);
    $('#birthday_update').val(response.data.birthday);
    $('#gender_update').val(response.data.gender);
    $('#program_study_update').val(response.data.program_study.id).trigger('change');
</x-script.update-swal>
<x-script.delete-swal route="super.admin.destroy" />
@endpush