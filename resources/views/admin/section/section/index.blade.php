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

<x-modal id="createModal" centered="true" title="Create Question Section" size="lg">  
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <x-select
            name="section_name_id"  
            label="Name"  
            id="name"
            :options="$names" 
            />  
        </div>
        <div class="mb-3">
            <x-select
            name="bank_id"  
            label="Bank Question"  
            id="bankQuestion"
            :options="$banks" 
            />  
        </div>
        <div class="mb-3">
            <x-filepond 
                class="filepond-image" 
                label="Upload Gambar" 
                name="image"
                id="image"
            />
        </div>
        <div class="mb-3 d-none" id="audioInput">
            <x-filepond 
                class="filepond-audio" 
                label="Upload Audio" 
                name="audio"
                id="audio"
                :isRequired="false"
            />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update Question Section" size="lg">  
    <form method="POST" id="form_update">
        @csrf
        @method('put')       
        <div class="mb-3">
            <x-select
            name="section_name_id"  
            label="Name"  
            id="name_update"
            :options="$names" 
            />  
        </div>
        <div class="mb-3">
            <x-select
            name="bank_id"  
            label="Bank Question"  
            id="bankQuestion_update"
            :options="$banks" 
            />  
        </div>
        <div class="mb-3">
            <x-filepond
                name="image"
                class="filepond-image" 
                id="image_update"
                :isRequired="false"
            />
        </div>
        <div class="mb-3 d-none" id="audioInputUpdate">
            <x-filepond
                label="Audio"
                name="audio"
                class="filepond-audio"
                id="audio_update"
                :isRequired="false"
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
        ajax: '{{ route('admin.section.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'section_name.name', name: 'section_name.name' },
            { data: 'section_name.type', name: 'section_name.type' },
            { data: 'action', name: 'action' },
        ],
    });

    $('#name, #name_update').on('change', function() {
        const id = $(this).val();
        $.ajax({
            url: '{{ route("admin.section.name.getById", ["id" => ":id"]) }}'.replace(":id", id),
            type: 'GET',
            success: function(response) {
                if (response.data.type == 'listening'){
                    $('#audioInput').removeClass('d-none');
                    $('#audioInputUpdate').removeClass('d-none');
                } else {
                    $('#audioInput').addClass('d-none');
                    $('#audioInputUpdate').addClass('d-none');
                }
            }
        })
    });
</script>
<x-script.update-swal routeGet="admin.section.getById" routeUpdate="admin.section.update">
    $('#name_update').val(response.data.section_name.id);
    $('#name_update').trigger('change');
    $('#bankQuestion_update').val(response.data.question_bank.id);
</x-script.update-swal>
<x-script.delete-swal route="admin.section.destroy" />
@endpush