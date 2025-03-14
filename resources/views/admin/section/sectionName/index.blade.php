@extends('layouts.app')

@section('content')
<x-breadcrumb title="Section Name" li_1="Menu" />
<x-card title="Manage Question Section">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
    <table id="datatables" class="table align-middle nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</x-card>

<x-modal id="createModal" centered="true" title="Create Question Section">  
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-input label="Name" type="text" name="name" id="name"/>
        </div>
        <div class="mb-3">
            <x-select
            name="type"  
            label="Type"  
            id="type"
            :options="$type" 
            />  
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update Question Section">  
    <form method="POST" id="form_update">
        @csrf
        @method('put')
        <div class="mb-3">
            <x-input label="Question Section Name" type="text" name="name" id="name_update" />
        </div>
        <div class="mb-3">
            <x-select
            name="type"  
            label="Type"  
            id="type_update"
            :options="$type" 
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
        ajax: '{{ route('admin.section.name.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'name', name: 'name' },
            { data: 'type', name: 'type' },
            { data: 'action', name: 'action' },
            ],
    });

</script>
<x-script.update-swal routeGet="admin.section.name.getById" routeUpdate="admin.section.name.update">
    $('#name_update').val(response.data.name);
    $('#type_update').val(response.data.type);
</x-script.update-swal>
<x-script.delete-swal route="admin.section.name.destroy" />
@endpush