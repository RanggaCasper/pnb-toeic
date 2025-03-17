@props([
    'class' => 'filepond-image', // filepond-image, filepond-audio
    'label' => 'Image',
    'id' => 'filepond',
    'isRequired' => true,
    'name',
    'maxFileSizeImage' => 2,
    'maxFileSizeAudio' => 20
])

<div>
    <label class="form-label filepond-label" @if($id) for="{{ $id }}" @endif>
        {{ $label }}
        @if ($isRequired) <span class="text-danger">*</span> @endif
    </label>

    <input 
        type="file" 
        class="{{ $class }} filepond" 
        name="{{ $name }}" 
        @if ($isRequired) @endif
        @if($id) id="{{ $id }}" @endif
    />
</div>

@once
    @push('styles')
        <!-- FilePond CSS -->
        <link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    @endpush

    @push('scripts')
        <!-- FilePond JS -->
        <script src="{{ asset('assets/libs/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
        <script src="{{ asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
        <script src="{{ asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
        <script src="{{ asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

        <script>
            // Set FilePond options
            FilePond.setOptions({
                server: {
                    url: "{{ config('filepond.server.url') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                    }
                },
            });

            // Register FilePond plugins
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType,
                FilePondPluginImageExifOrientation,
                FilePondPluginImagePreview
            );

            $("input.filepond-image").each(function() {
                FilePond.create(this, {
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    allowMultiple: false,
                    allowFileSizeValidation: true,
                    maxFileSize: {{ 1000000 * $maxFileSizeImage }},
                    labelMaxFileSizeExceed: 'Maximum file size is {filesize}',
                    maxFiles: 1,
                    onaddfilestart: () => {
                        $('button[type="submit"]').prop('disabled', true);
                    },
                    onprocessfile: () => {
                        $('button[type="submit"]').prop('disabled', false);
                    },
                    onerror: () => {
                        $('button[type="submit"]').prop('disabled', false);
                    }
                });
            });

            $("input.filepond-audio").each(function() {
                FilePond.create(this, {
                    acceptedFileTypes: ['audio/mpeg', 'audio/ogg', 'audio/wav'],
                    allowFileSizeValidation: true,
                    maxFileSize: {{ 1000000 * $maxFileSizeAudio }},
                    labelMaxFileSizeExceed: 'Maximum file size is {filesize}',
                    allowMultiple: false,
                    maxFiles: 1,
                });
            });

            // Initialize FilePond for circular image upload (opsional)
            FilePond.create($(".filepond-input-circle")[0], {
                labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
                imagePreviewHeight: 170,
                imageCropAspectRatio: "1:1",
                imageResizeTargetWidth: 200,
                imageResizeTargetHeight: 200,
                stylePanelLayout: "compact circle",
                styleLoadIndicatorPosition: "center bottom",
                styleProgressIndicatorPosition: "right bottom",
                styleButtonRemoveItemPosition: "left bottom",
                styleButtonProcessItemPosition: "right bottom"
            });
        </script>
    @endpush
@endonce