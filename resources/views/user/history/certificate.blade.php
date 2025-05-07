@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2>TOEIC Score Report</h2>
                        <p class="text-muted">{{ $test_date }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h1 class="display-1 mb-3">{{ $total_score }}</h1>
                                    <h5>Overall</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Test Score</h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Listening</span>
                                        <span>{{ $listening_score }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Reading</span>
                                        <span>{{ $reading_score }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>STATUS</h5>
                            @if($total_score >= 120)
                                <p class="text-success">PASSED</p>
                            @else
                                <p class="text-danger">FAILED</p>
                            @endif

                            <h5>SCORE DESCRIPTION</h5>
                            @if($total_score >= 945)
                                <p class="fw-bold">Proficient user - Effective Operational Proficiency (C1)</p>
                                <p>Can understand a wide range of demanding, longer texts, and recognize implicit meaning. Can express him/herself fluently and spontaneously without much obvious searching for expressions. Can use language flexibly and effectively for social, academic and professional purposes. Can produce clear, well-structured, detailed text on complex subjects, showing controlled use of organizational patterns, connectors and cohesive devices.</p>
                            @elseif($total_score >= 785)
                                <p class="fw-bold">Independent user - Vantage (B2)</p>
                                <p>Can understand the main ideas of complex text on both concrete and abstract topics, including technical discussions in his/her field of specialisation. Can interact with a degree of fluency and spontaneity that makes regular interaction with native speakers quite possible without strain for either party. Can produce clear, detailed text on a wide range of subjects and explain a viewpoint on a topical issue giving the advantages and disadvantages of various options.</p>
                            @elseif($total_score >= 550)
                                <p class="fw-bold">Independent user - Threshold (B1)</p>
                                <p>Can understand the main points of clear standard input on familiar matters regularly encountered in work, school, leisure, etc. Can deal with most situations likely to arise while travelling in an area where the language is spoken. Can produce simple connected text on topics which are familiar or of personal interest. Can describe experiences and events, dreams, hopes and ambitions and briefly give reasons and explanations for opinions and plans.</p>
                            @elseif($total_score >= 225)
                                <p class="fw-bold">Basic user - Waystage (A2)</p>
                                <p>Can understand sentences and frequently used expressions related to areas of most immediate relevance (e.g. very basic personal and family information, shopping, local geography, employment). Can communicate in simple and routine tasks requiring a simple and direct exchange of information on familiar and routine matters. Can describe in simple terms aspects of his/her background, immediate environment and matters in areas of immediate need.</p>
                            @elseif($total_score >= 120)
                                <p class="fw-bold">Basic user - Breakthrough (A1)</p>
                                <p>Can understand and use familiar everyday expressions and very basic phrases aimed at the satisfaction of needs of a concrete type. Can introduce him/herself and others and can ask and answer questions about personal details such as where he/she lives, people he/she knows and things he/she has. Can interact in a simple way provided the other person talks slowly and clearly and is prepared to help.</p>
                            @else
                                <p class="fw-bold">-</p>
                                <p>-</p>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        
                        <div class="btn-group" role="group">
                            
                            <a href="{{ route('user.history.download', ['timestamp' => $test_date, 'bank' => $bank_id]) }}" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-2"></i>DOWNLOAD PDF
                            </a>
                        </div>
                        <a href="{{ route('user.history.index') }}" class="btn btn-secondary">BACK TO HISTORY</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function shareScore() {
    if (navigator.share) {
        navigator.share({
            title: 'My TOEIC Score',
            text: `I scored ${@json($total_score)} on my TOEIC test! (Listening: ${@json($listening_score)}, Reading: ${@json($reading_score)})`,
            url: window.location.href
        })
        .catch((error) => console.log('Error sharing:', error));
    } else {
        alert('Web Share API not supported in your browser');
    }
}
</script>
@endpush 