@if (isset($data))
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-center mb-3">
            <img class="img-fluid w-50" src="{{ Storage::url($data->image) }}" alt="Image">
        </div>
        <div class="col-12 text-center mb-3">
            <span>{!! $data->sectionName->description !!}</span>
        </div>

        @if ($data->sectionName->type == 'listening')
            <audio controls>
                <source src="{{ Storage::url($data->audio) }}" type="audio/mpeg">
            </audio>
            <span class="text-muted small">This audio will play automatically during the exam, and the controls will be hidden.</span>
        @endif
    </div>
@else

@endif