<div class="row">
    <div class="col-8" id="question-section">
        <x-card>
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h4>{{ $data->sectionName->name }}</h4>
                </div>
                <div class="col-12 text-center mb-3">
                    <span>{!! $data->sectionName->description !!}</span>
                </div>
                <div class="col-12 d-flex justify-content-center mb-3">
                    <img class="img-fluid w-50" src="{{ Storage::url($data->image) }}" alt="Image">
                </div>
            </div>
        </x-card>

        @foreach ($questions as $index => $data)
            <div class="card ribbon-box border shadow-none mb-4 material-shadow" id="question-{{ $data->id }}">
                <div class="card-body">
                    <div class="ribbon ribbon-primary ribbon-shape">
                        <span>Question {{ $index + 1 }}</span>
                    </div>

                    <form id="question-form-{{ $data->id }}" action="#" method="POST" class="mt-4">
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
                                <label class="exam-option me-2">
                                    <input type="radio" name="answer_{{ $data->id }}" value="{{ $option }}" class="question-answer" 
                                        data-question-id="{{ $data->id }}" data-question-index="{{ $index }}"
                                        @if(session("answers.{$data->id}") == $option) checked @endif>
                                    <span class="radio-label">{{ $option }}</span>
                                </label>
                                <span>{{ $data[strtolower($option)] }}</span>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-4">
        <div style="position: sticky; top: 5rem;">
            <x-card title="Number of Questions">
                <div class="container">
                    <div class="row">
                        @foreach ($questions as $index => $data)
                            <div class="col-3 mb-2">
                                <button class="btn @if(session("answers.{$data->id}")) btn-primary @else btn-soft-primary @endif w-100 question-btn" 
                                        data-question-id="{{ $data->id }}" data-question-index="{{ $index }}">
                                    {{ $index + 1 }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-card>
            <div class="text-center">
                <form action="{{ route('user.exam.saveAllAnswers') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary waves-effect waves-light w-100" id="nextSection">
                        <i class="ri-arrow-right-line label-icon align-middle fs-16 me-2"></i> Next Section
                    </button>
                </form>
            </div>            
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.question-answer').change(function () {
            var questionId = $(this).data('question-id');
            var selectedAnswer = $(this).val();

            $.ajax({
                url: '{{ route('user.exam.saveAnswer') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    question_id: questionId,
                    answer: selectedAnswer
                },
                success: function (response) {
                    var button = $('[data-question-id="' + questionId + '"]');
                    button.removeClass('btn-soft-primary').addClass('btn-primary');
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
        });

        $('.question-btn').click(function() {
            var questionIndex = $(this).data('question-index');
            var questionId = $(this).data('question-id');
            var questionForm = $('#question-' + questionId);

            $('html, body').animate({
                scrollTop: questionForm.offset().top - 100 
            }, 500);
        });
    });
</script>
