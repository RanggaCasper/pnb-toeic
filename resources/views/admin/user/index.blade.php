@extends('layouts.app')

@section('content')
<x-breadcrumb title="User" li_1="Menu" />
<x-card title="Manage User">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">Export</button>
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

<x-modal id="importModal" centered="true" title="Import User" size="lg">
    <div class="mb-3">
        <label class="d-block">Download Template</label>
        <a href="{{ route('admin.user.export') }}?q=template" class="btn btn-sm btn-primary">Download</a>
    </div>
    <form action="{{ route('admin.user.import') }}" action="POST" enctype="multipart/form-data" data-import="true">
        @csrf
        <div class="mb-3">
            <x-input label="File" type="file" name="file" id="file" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="exportModal" centered="true" title="Export User" size="lg">
    <form action="{{ route('admin.user.export') }}" method="GET" id="exportForm">
        @csrf
        <div class="mb-3">
            <x-select2
                name="program_study"  
                label="Program Study"  
                id="program_study_export"
                :options="$programStudy"
                :isRequired="false"
            />  
        </div>
        <div class="mb-3">
            <x-select
                name="type"  
                label="Type"  
                id="type_export"
                :options="$typeExport" 
            />  
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="createModal" centered="true" title="Create User" size="lg">  
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
                :options="$gender" 
            />  
        </div>
        <div class="mb-3">
            <x-select2
                name="program_study"  
                label="Program Study"  
                id="program_study"
                :options="$programStudy" 
            />  
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update User" size="lg">  
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
                :options="$gender" 
            />  
        </div>
        <div class="mb-3">
            <x-select2
                name="program_study"  
                label="Program Study"  
                id="program_study_update"
                :options="$programStudy" 
            />  
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
        ajax: '{{ route('admin.user.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'identity', name: 'identity' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'birthday', name: 'birthday' },
            { data: 'gender', name: 'gender' },
            { data: 'program_study.name', name: 'program_study.name' },
            { data: 'action', name: 'action' },
        ],
    });

    $('#exportForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const programStudy = form.find('[name="program_study"]').val();
        const type = form.find('[name="type"]').val();

        const url = `${form.attr('action')}?q=${encodeURIComponent(type)}&s=${encodeURIComponent(programStudy)}`;

        window.location.href = url;
    });
</script>
<x-script.update-swal routeGet="admin.user.getById" routeUpdate="admin.user.update">
    $('#identity_update').val(response.data.identity);
    $('#name_update').val(response.data.name);
    $('#email_update').val(response.data.email);
    $('#birthday_update').val(response.data.birthday);
    $('#gender_update').val(response.data.gender);
    $('#program_study_update').val(response.data.program_study.id).trigger('change');
</x-script.update-swal>
<x-script.delete-swal route="admin.user.destroy" />
@endpush