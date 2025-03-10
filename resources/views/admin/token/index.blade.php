@extends('layouts.app')

@section('content')
<x-card title="Manage Sessions">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
    <table id="datatables" class="table align-middle nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Question Bank</th>
                <th>Token</th>
                <th>Start</th>
                <th>End</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</x-card>

<x-modal id="createModal" centered="true" title="Create Session">  
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-input label="Time Start" type="datetime-local" name="mulai" id="mulai" />
        </div>
        <div class="mb-3">
            <x-input label="Time End" type="datetime-local" name="selesai" id="selesai" />
        </div>
        <div class="mb-3">
            <x-select
            name="bank_id"  
            label="Question Bank"  
            id="bank_id"
            :options="$bank"
            />  
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update Session">  
    <form method="POST" id="form_update">
        @csrf
        @method('put')
        <div class="mb-3">
            <x-input label="Time Start" type="datetime-local" name="mulai" id="mulai_update" />
        </div>
        <div class="mb-3">
            <x-input label="Time End" type="datetime-local" name="selesai" id="selesai_update" />
        </div>
        <div class="mb-3">
            <x-select
            name="bank_id"  
            label="Question Bank"  
            id="bank_id_update"
            :options="$bank"
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
        ajax: '{{ route('admin.token.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'bank', name: 'bank' },
            { data: 'token', name: 'token' },
            { data: 'start', name: 'start' },
            { data: 'end', name: 'end' },
            { data: 'action', name: 'action' },
            ],
    });

</script>
<x-script.update-swal routeGet="admin.token.getById" routeUpdate="admin.token.update">
    $('#mulai_update').val(response.data.mulai);
    $('#selesai_update').val(response.data.selesai);
    $('#bank_id_update').val(response.data.bank_id);
</x-script.update-swal>
<x-script.delete-swal route="admin.token.destroy" />
@endpush