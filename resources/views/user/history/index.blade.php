@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>TOEIC Test History
                        </h4>
                        <a href="{{ route('user.token.index') }}" class="btn btn-light btn-sm px-3">
                            <i class="fas fa-plus-circle me-2"></i>Take New Test
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($test_sessions->isEmpty())
                        <div class="text-center py-5">
                            <div class="empty-state mb-4">
                                <i class="fas fa-clipboard-list fa-4x text-primary opacity-50"></i>
                            </div>
                            <h4 class="text-primary fw-bold mb-3">Start Your TOEIC Journey</h4>
                            <p class="text-muted mb-4">Take your first TOEIC practice test to begin tracking your progress</p>
                            <div class="practice-test-card p-4 bg-light rounded-3 mb-4 mx-auto" style="max-width: 500px;">
                                <h5 class="text-dark mb-3">Available Practice Tests:</h5>
                                <div class="d-flex justify-content-around">
                                    <div class="text-center px-4">
                                        <div class="practice-icon mb-2">
                                            <i class="fas fa-book fa-2x text-info"></i>
                                        </div>
                                        <h6 class="mb-1">Reading Test</h6>
                                        <small class="text-muted">45 Minutes</small>
                                    </div>
                                    <div class="text-center px-4">
                                        <div class="practice-icon mb-2">
                                            <i class="fas fa-headphones fa-2x text-warning"></i>
                                        </div>
                                        <h6 class="mb-1">Listening Test</h6>
                                        <small class="text-muted">45 Minutes</small>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('user.token.index') }}" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="fas fa-play-circle me-2"></i>Start Practice Test
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover border-top">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th style="width: 20%">Test Taken</th>
                                        <th style="width: 25%">Test Type</th>
                                        <th class="text-center" style="width: 15%">Reading Score</th>
                                        <th class="text-center" style="width: 15%">Listening Score</th>
                                        <th class="text-center" style="width: 10%">Total Score</th>
                                        <th class="text-center" style="width: 10%">Certificate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($test_sessions as $index => $session)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <i class="far fa-calendar-alt me-2 text-muted"></i>
                                                {{ $session['test_taken']->format('d M Y H:i') }}
                                            </td>
                                            <td>
                                                @php
                                                    $isTryout = strtolower($session['bank_name']) === 'tryout' || 
                                                               str_contains(strtolower($session['bank_name']), 'tryout') ||
                                                               strtolower($session['test_type']) === 'tryout';
                                                @endphp
                                                <span class="badge bg-{{ $isTryout ? 'secondary' : ($session['test_type'] == 'Reading' ? 'info' : 'warning') }} bg-opacity-10 text-{{ $isTryout ? 'secondary' : ($session['test_type'] == 'Reading' ? 'info' : 'warning') }} border border-{{ $isTryout ? 'secondary' : ($session['test_type'] == 'Reading' ? 'info' : 'warning') }}">
                                                    <i class="fas fa-{{ $isTryout ? 'flask' : ($session['test_type'] == 'Reading' ? 'book' : 'headphones') }} me-1"></i>
                                                    {{ $isTryout ? 'Tryout' : $session['test_type'] }}
                                                </span>
                                                <span class="ms-2">
                                                    {{ $session['bank_name'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $isTryout ? 'secondary' : 'info' }} bg-opacity-10 text-{{ $isTryout ? 'secondary' : 'info' }} border border-{{ $isTryout ? 'secondary' : 'info' }}">
                                                   
                                                        {{ $session['reading_score'] }}
                                                    
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $isTryout ? 'secondary' : 'warning' }} bg-opacity-10 text-{{ $isTryout ? 'secondary' : 'warning' }} border border-{{ $isTryout ? 'secondary' : 'warning' }}">
                                                   
                                                        {{ $session['listening_score'] }}
                                                 
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $isTryout ? 'secondary' : 'success' }} bg-opacity-10 text-{{ $isTryout ? 'secondary' : 'success' }} border border-{{ $isTryout ? 'secondary' : 'success' }}">
                                                    
                                                        {{ $session['total_score'] }}
                                                   
                                                </span>
                                            </td>
                                            <td class="text-center">
                                               
                                                    <a href="{{ route('user.history.certificate', ['timestamp' => $session['test_taken']->format('Y-m-d H:i:s'), 'bank' => $session['bank_id']]) }}" 
                                                       class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                        <i class="fas fa-award me-1"></i>View
                                                    </a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 0.75rem;
    }
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        border-bottom: 0;
    }
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom-width: 1px;
        border-bottom-color: #e9ecef;
    }
    .badge {
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.5em 0.85em;
    }
    .btn-outline-primary:hover i,
    .btn-outline-secondary:hover i {
        color: white;
    }
    .empty-state {
        animation: float 3s ease-in-out infinite;
    }
    .practice-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        background: white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
</style>
@endpush
@endsection