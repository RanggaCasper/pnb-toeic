@extends('layouts.exam')

@section('content')
    <div class="row">
        <div class="col-12" id="previewQuestion">
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/guard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/howler"></script>
<script>
    $(document).ready(function () {
        @if ($section->sectionName->type === 'listening')
            const audioUrl = '{{ Storage::url($section->audio) }}';
            const lastTime = parseFloat(sessionStorage.getItem('audioCurrentTime')) || 0;

            const sound = new Howl({
                src: [audioUrl],
                autoplay: false,
                loop: false,
                volume: 1,
                onload: function() {
                    console.log('Audio loaded');
                },
                onplay: function() {
                    if (lastTime > 0) {
                        sound.seek(lastTime);
                    }
                },
                onend: function() {
                    sessionStorage.removeItem('audioCurrentTime');
                }
            });

            setInterval(function () {
                if (sound.playing()) {
                    sessionStorage.setItem('audioCurrentTime', sound.seek());
                }
            }, 1000);

            Swal.fire({
                html: `<div class="mt-3">
                            <lord-icon
                                src="https://cdn.lordicon.com/xzpiphuj.json"
                                trigger="loop"
                                style="width:250px;height:250px">
                            </lord-icon>
                            <div class="pt-2 mt-4 fs-15">
                                <h4>Ready to start?</h4>
                                <p class="mx-4 mb-0 text-muted">Click the button below to start the audio for this section.</p>
                            </div>
                        </div>`,
                showCancelButton: false,
                confirmButtonText: 'Start Audio',
                allowOutsideClick: false,
                allowEscapeKey: false,
                backdrop: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs mb-1",
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {
                    sound.play();
                }
            });
        @endif

        $.ajax({
            url: '{{ route('user.exam.get') }}',
            type: 'GET',
            beforeSend: function () {
                $('#previewQuestion').html('<p class="text-muted">Fetching section...</p>');
            },
            success: function (response) {
                $('#previewQuestion').html(response.data);
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                let message = response.errors || response.message;

                Swal.fire({
                    html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                            <div class="pt-2 mt-4 fs-15">
                                <h4>Oops!</h4>
                                <p class="mx-4 mb-0 text-muted">${message}</p>
                            </div>
                        </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: "Back",
                    buttonsStyling: false,
                    customClass: {
                        cancelButton: "btn btn-primary w-xs mb-1",
                    },
                    showCloseButton: true,
                });
            }
        });

        var remainingTime = Math.floor({{ $time }});

        function formatTime(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var remainingSeconds = seconds % 60;

            return hours.toString().padStart(2, '0') + ':' +
                minutes.toString().padStart(2, '0') + ':' +
                remainingSeconds.toString().padStart(2, '0');
        }

        $("#watch").text(formatTime(remainingTime));

        function updateTime() {
            remainingTime--;

            $("#watch").text(formatTime(remainingTime));

            if (remainingTime <= 0) {
                $("#watch").text("Time's up!");
                $("#watch").closest(".btn").removeClass("btn-primary").addClass("btn-danger");
            }

        }

        setInterval(updateTime, 1000);

    });
</script>
@endpush
