@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="mt-4 card">
            <div class="p-4 card-body">
                <div class="mt-2 text-center">
                    <h5 class="text-primary">Forgot Password?</h5>
                    <p class="text-muted">Reset password with your email.</p>
                </div>
                <form method="POST">
                    @csrf
                    <div class="mb-3">
                        <x-input label="Email" type="text" name="email" id="email" />
                    </div>
                    <div class="mb-3">
                        <label for="token" class="form-label">Token</label><span class="text-danger"> *</span>
                        <div class="input-group">
                            <input type="text" name="token" class="form-control">
                            <button class="btn btn-primary material-shadow-none" type="button" id="send-token">
                                Send
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <x-input label="Password" type="password" name="password" id="password" />
                    </div>
                    <div class="mb-3">
                        <x-input label="Confirm Password" type="password" name="password_confirmation" id="password_confirmation" />
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <p class="mb-0">Remembered your password? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">Login</a></p>
</div>
@endsection

@push('scripts')
<script>
        $('#send-token').on('click', function(e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid');
            $('.alert').remove();
            $('.error-message').remove();

            var button = $(this);
            let buttonText = button.text();

            const form = $(this).closest('form');

            button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');

            $.ajax({
                url: '{{ route("forgot.send") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: $('#email').val(),
                },
                success: function(response) {
                    $(form).before(`
                        <div class="mb-3 text-white alert alert-success alert-dismissible bg-success alert-label-icon fade show material-shadow" role="alert">
                            <i class="ri-check-line label-icon"></i><strong>Success!</strong> - ${response.message}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    let errors = response.errors;

                    if (response.status === false) {
                        if (response.errors) {  
                            $(form).before(`  
                                <div class="mb-3 text-white alert alert-danger alert-dismissible bg-danger alert-label-icon fade show material-shadow" role="alert">  
                                    <i class="ri-error-warning-line label-icon"></i><strong>Oops!</strong> - ${response.errors}  
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>  
                                </div>  
                            `);  
                        } else if (response.message) {  
                            $(form).before(`  
                                <div class="mb-3 text-white alert alert-danger alert-dismissible bg-danger alert-label-icon fade show material-shadow" role="alert">  
                                    <i class="ri-error-warning-line label-icon"></i><strong>Oops!</strong> - ${response.message}  
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>  
                                </div>  
                            `);  
                        }  
                    } else {
                        if ('errors' in response) {
                            $.each(errors, function(field, message) {
                                let inputName = field.replace(/\.(\d+)/g, '[$1]');
                                inputName = inputName.replace(/\./g, '\\.').replace(/\[/g, '\\[').replace(/\]/g, '\\]');
                                let input = $(`[name="${inputName}"]`);
            
                                input.addClass('is-invalid');
            
                                input.after(`
                                    <div class="error-message text-danger mt-1">${message[0]}</div>
                                `);
                            });
                        }
                    }
                    
                    button.prop('disabled', false).text(buttonText);
                },
                complete: function () {
                    button.prop('disabled', false);
                    button.text(buttonText);
                }
            });
        });
</script>
@endpush