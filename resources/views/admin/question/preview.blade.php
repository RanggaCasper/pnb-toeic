<div class="row">
    @if ($data->image)
        <div class="col-6">
            <div class="col-12 d-flex justify-content-center mb-3">
                <img class="img-fluid" src="{{ Storage::url($data->image) }}" alt="Image">
            </div>
        </div>
    @endif
    <div class="col-{{ $data->image ? '6' : '12' }}">
        <form action="{{ route('admin.question.check.store', $data->id) }}" data-reset="false" method="POST">
            @csrf
            <h6 class="mb-3">{{ $data->questions }}</h6>
            <div class="d-flex mb-1">
                <label class="exam-option">
                    <input type="radio" name="answer" value="A">
                    <span class="radio-label">A</span>
                </label>
                <span>{{ $data->a }}</span>
            </div>
            <div class="d-flex mb-1">
                <label class="exam-option">
                    <input type="radio" name="answer" value="B">
                    <span class="radio-label">B</span>
                </label>
                <span>{{ $data->b }}</span>
            </div>
            <div class="d-flex mb-1">
                <label class="exam-option">
                    <input type="radio" name="answer" value="C">
                    <span class="radio-label">C</span>
                </label>
                <span>{{ $data->c }}</span>
            </div>
            <div class="d-flex mb-1">
                <label class="exam-option">
                    <input type="radio" name="answer" value="D">
                    <span class="radio-label">D</span>
                </label>
                <span>{{ $data->d }}</span>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Check Answer</button>
        </form>
    </div>
</div>