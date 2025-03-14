@extends('layouts.app')

@section('content')
<x-breadcrumb title="Question Bank" li_1="Menu" />
<x-card title="Manage Question Bank">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
    <table id="datatables" class="table align-middle nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</x-card>

<x-modal id="createModal" centered="true" title="Create Question Bank">  
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-input label="Bank Name" type="text" name="name" id="name"/>
        </div>
        <div class="mb-3">
            <x-select
            name="type"  
            label="Type"  
            id="type"
            :options="['tryout'=> 'Try Out', 'practice' => 'Practice']" 
            />  
        </div>
        <div class="mb-3">
            <div class="form-check form-switch form-switch-right form-switch-md">
                <label for="vertical-form-showcode" class="form-label">Active</label>
                <input class="form-check-input code-switcher" name="is_active" value="true" type="checkbox" id="vertical-form-showcode" checked>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update Question Bank">  
    <form method="POST" id="form_update">
        @csrf
        @method('put')
        <div class="mb-3">
            <x-input label="Question Bank Name" type="text" name="name" id="name_update" />
        </div>
        <div class="mb-3">
            <x-select
            name="type"  
            label="Type"  
            id="type_update"
            :options="['tryout'=> 'Try Out', 'practice' => 'Practice']"
            />  
        </div>
        <div class="mb-3">
            <div class="form-check form-switch form-switch-right form-switch-md">
                <label for="is_active_update" class="form-label">Active</label>
                <input class="form-check-input code-switcher" name="is_active" value="true" type="checkbox" id="is_active_update">
            </div>
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
        ajax: '{{ route('admin.bank.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'name', name: 'name' },
            { data: 'type', name: 'type' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
            ],
    });

</script>
<x-script.update-swal routeGet="admin.bank.getById" routeUpdate="admin.bank.update">
    $('#name_update').val(response.data.name);
    $('#type_update').val(response.data.type);
    if(response.data.is_active == 1){
        $( "#is_active_update").prop('checked', true);
    }else{
        $( "#is_active_update").prop('checked', false);
    }
</x-script.update-swal>
<x-script.delete-swal route="admin.bank.destroy" />
@endpush