<x-card>
    <form id="question-form" action="#" data-reset="false" method="POST">
        @csrf
        <input type="hidden" name="question_id" value="{{ $data->id }}">
        <h6 class="mb-3">{{ $data->questions }}</h6>

        @if ($data->image)
            <div class="d-flex justify-content-center mb-3">
                <img class="img-fluid w-50" src="{{ Storage::url($data->image) }}" alt="Image">
            </div>
        @endif

        @foreach (['A', 'B', 'C', 'D'] as $option)
            <div class="d-flex mb-1">
                <label class="exam-option">
                    <input type="radio" name="answer" value="{{ $option }}">
                    <span class="radio-label">{{ $option }}</span>
                </label>
                <span>{{ $data[strtolower($option)] }}</span>
            </div>
        @endforeach
    </form>
</x-card>
    