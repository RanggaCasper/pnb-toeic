@extends('layouts.app')

@section('content')
<x-breadcrumb title="Question" li_1="Section" li_1_href="{{ route('admin.section.index', ['uuid' => $section->bank_id]) }}" />
<a class="btn btn-sm btn-primary mb-3" href="{{ route('admin.section.index', ['uuid' => $section->bank_id]) }}"><i class="ri ri-arrow-left-line"></i> Back</a>
<x-card title="Manage Question">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
    <table id="datatables" class="table align-middle nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Question</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</x-card>

<x-modal id="createModal" centered="true" title="Create Question" size="lg">
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-none">
            <input type="hidden" name="section_id" value="{{ request('id') }}" id="section_id">
        </div>
        <div class="mb-3">
            <x-input label="Question" type="text" name="questions" id="questions" required />
        </div>

        <div class="mb-3">
            <x-filepond
                class="filepond-image"
                label="Upload Image"
                name="image"
                id="image"
                :isRequired="false" />
        </div>

        <div class="mb-3">
            <x-input name="a" label="Option A" id="option_a" required />
        </div>
        <div class="mb-3">
            <x-input name="b" label="Option B" id="option_b" required />
        </div>
        <div class="mb-3">
            <x-input name="c" label="Option C" id="option_c" required />
        </div>
        <div class="mb-3">
            <x-input name="d" label="Option D" id="option_d" required />
        </div>

        <div class="mb-3">
            <x-select
                name="answer"
                label="Correct Answer"
                id="correct_answer"
                :options="['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D']"
                required />
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
            <input type="hidden" name="section_id" value="{{ request('id') }}" id="section_id">
        </div>
        <div class="mb-3">
            <x-input label="Question" type="text" name="questions" id="question_update" required />
        </div>
        <div class="mb-3">
            <x-filepond
                class="filepond-image"
                label="Upload Image"
                name="image"
                id="image"
                :isRequired="false" />
        </div>
        <div class="mb-3">
            <x-input name="a" label="Option A" id="option_a_update" required />
        </div>
        <div class="mb-3">
            <x-input name="b" label="Option B" id="option_b_update" required />
        </div>
        <div class="mb-3">
            <x-input name="c" label="Option C" id="option_c_update" required />
        </div>
        <div class="mb-3">
            <x-input name="d" label="Option D" id="option_d_update" required />
        </div>
        <div class="mb-3">
            <x-select
                name="answer"
                label="Correct Answer"
                id="answer_update"
                :options="['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D']"
                required />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="previewModal" centered="true" title="Preview Question" size="lg">

</x-modal>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            ajax: "{{ route('admin.question.get', ['id' => request('id')]) }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'questions',
                    name: 'questions'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });

    $('#datatables').on('click', '.preview-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route("admin.question.preview", ["id" => ":id"]) }}'.replace(':id', id),
            type: 'GET',
            beforeSend: function() {
                $('#previewModal .modal-body').html('<p class="text-muted">Fetching data...</p>');
            },
            success: function(response) {
                console.log(response);
                $('#previewModal .modal-body').html(response.data);
            },
            error: function(xhr) {
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
<x-script.update-swal routeGet="admin.question.getById" routeUpdate="admin.question.update">
    $('#question_update').val(response.data.questions);
    $('#option_a_update').val(response.data.a);
    $('#option_b_update').val(response.data.b);
    $('#option_c_update').val(response.data.c);
    $('#option_d_update').val(response.data.d);
    $('#answer_update').val(response.data.answer).trigger('change');
    $('#section_id_update').val(response.data.section_id).trigger('change');
</x-script.update-swal>
<x-script.delete-swal route="admin.question.destroy" />
@endpush