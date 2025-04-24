@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">History</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Reading Score</h5>
                                    <p class="card-text">
                                        Score: {{ $readingScore }}
                                        <br>
                                        Total Questions: {{ $totalReading }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Listening Score</h5>
                                    <p class="card-text">
                                        Score: {{ $listeningScore }}
                                        <br>
                                        Total Questions: {{ $totalListening }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Question</th>
                                    <th>Section Type</th>
                                    <th>Your Answer</th>
                                    <th>Correct Answer</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($histories as $key => $history)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if($history->question)
                                            {{ $history->question->questions }}
                                        @else
                                            <span class="text-muted">Question not found</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($history->question && $history->question->section && $history->question->section->sectionName)
                                            {{ $history->question->section->sectionName->type }}
                                        @else
                                            <span class="text-muted">Section not found</span>
                                        @endif
                                    </td>
                                    <td>{{ $history->user_answer }}</td>
                                    <td>
                                        @if($history->question)
                                            {{ $history->question->answer }}
                                        @else
                                            <span class="text-muted">Answer not found</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($history->question && strtoupper($history->user_answer) === strtoupper($history->question->answer))
                                            <span class="badge bg-success">Correct</span>
                                        @else
                                            <span class="badge bg-danger">Wrong</span>
                                        @endif
                                    </td>
                                    <td>{{ $history->created_at->format('d M Y H:i:s') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection