@extends('layouts.app')

@section('content')
<x-breadcrumb title="Section" li_1="Menu" />
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
        <div class="d-none">
            <input type="hidden" name="bank_id" value="{{ request('uuid') }}" />
        </div>
        <div class="mb-3">
            <x-select
            name="section_name_id"  
            label="Name"  
            id="name"
            :options="$names" 
            />  
        </div>
        <div class="mb-3">
            <x-filepond 
                class="filepond-image" 
                label="Upload Image" 
                name="image"
                id="image"
                :isRequired="false"
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
        <div class="d-none">
            <input type="hidden" name="bank_id" value="{{ request('uuid') }}" />
        </div>
        <div class="mb-3">
            <x-select
            name="section_name_id"  
            label="Name"  
            id="name_update"
            :options="$names" 
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

<x-modal id="previewModal" centered="true" title="Preview Question Section" size="lg">

</x-modal>
@endsection

@push('scripts')
<script>
   $('#datatables').DataTable({
    processing: true,
    serverSide: false,
    scrollX: true,
    ajax: '{{ route('admin.section.get') }}?uuid={{ request('uuid') }}',
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

    $('#datatables').on('click', '.preview-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route("admin.section.preview", ["id" => ":id"]) }}'.replace(':id', id),
            type: 'GET',
            beforeSend: function () {
                $('#previewModal .modal-body').html('<p class="text-muted">Fetching data...</p>');
            },
            success: function(response) {
                console.log(response);
                $('#previewModal .modal-body').html(response.data);
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                let message; 
                
                if (response.errors) {
                    message = response.errors;
                } else {
                    message = response.message;
                }
                
                Swal.fire({
                    html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                            <div class="pt-2 mt-4 fs-15">
                                <h4>Oops!</h4>
                                <p class="mx-4 mb-0 text-muted">${message}</p>
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1",
                    },
                    cancelButtonText: "Back",
                    buttonsStyling: false,
                    showCloseButton: true,
                });
            },
        });
    });
</script>
<x-script.update-swal routeGet="admin.section.getById" routeUpdate="admin.section.update">
    $('#name_update').val(response.data.section_name.id);
    $('#name_update').trigger('change');
    $('#bankQuestion_update').val(response.data.question_bank.id);
</x-script.update-swal>
<x-script.delete-swal route="admin.section.destroy" />
@endpush