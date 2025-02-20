@extends('layouts.app')

@section('content')

<x-card title="Epdate Profile">
    {{-- @dd($user) --}}
    <form method="POST" id="form_update" action="{{route("admin.user.update", $user['id'])}}">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-lg-6">
                <x-input value="{{$user['identity']}}" label="Identity" type="text" name="identity" id="identity" attr="readonly"/>
            </div>
            <div class="col-lg-6">
                <x-input value="{{$user['name']}}" label="Name" type="text" name="name" id="name" attr="readonly" />
            </div>
            <div class="col-lg-6">
                <x-input value="{{$user['email']}}" label="Email" type="text" name="email" id="email" :isRequired="false" />
            </div>
            <div class="col-lg-6">
                <x-input label="Password" type="password" name="password" id="password" notification="<small class='text-danger'>leave blank if you don't want to change it</small>" />
                
            </div>
            <div class="col-lg-6">
                <x-input value="{{$user['birthday']}}" label="Birthday" type="date" name="birthday" id="birthday" />
            </div>
            <div class="col-lg-6">
                <x-select
                name="gender"  
                label="Gender"  
                id="gender"
                :options="$gender" 
                selected="{{$user['gender']}}"
                />  
            </div>
            <div class="col-lg-6">
                <x-select2
                name="program_study"  
                label="Program Study"  
                id="program_study"
                :options="$programStudy" 
                selected="{{$user['program_study_id']}}"
                />  
            </div>
            <div class="col-lg-6 d-flex justify-content-end p-2 gap-2">
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</x-card>
@endsection

@push('scripts')
{{-- <script>
       $('#form_update').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = '{{$user["id"]}}';
        $.ajax({
            url: '{{route("admin.user.update", ":id")}}'.replace(':id',),
            type: 'POST',
            data: formData, 
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                console.log(response)
            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        });
    });
</script> --}}
@endpush