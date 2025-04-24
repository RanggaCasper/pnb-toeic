@extends('layouts.app')

@section('content')
<div class="row mb-3 pb-1">
    <div class="col-xl-9">
        <div class="row">
            <div class="col-lg-12">
                <div class="overflow-hidden shadow-sm card bg-light-info position-relative">
                    <div class="px-4 py-3 card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-7">
                                <h4 class="fs-4 fw-semibold mb-2">About Test</h4>
                                <p class="fs-6 text-muted" style="max-width: 100%;">
                                    The TOEIC tests assess your English communication skills for the workplace.
                                    Learn about each section, their benefits, and access official test prep materials.
                                </p>
                                <a href="{{route('user.about.more')}}" class="btn btn-sm btn-primary fs-6 px-3 py-2 mt-2">
                                    Learn More
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-5 s mt-4 mt-md-0">
                                <lord-icon src="https://cdn.lordicon.com/xmaezqzk.json" state="loop-flutter" trigger="loop" delay="2000" style="width: 150px; height: 150px;">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-sm-6">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/ku6XQTDfYh0" title="YouTube video" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Preparing for TOEIC® test</h5>
                        <p class="card-text text-muted">
                            Know what to expect on the day of the test and how to get ready effectively. 
                        </p>
                        <a href="https://youtu.be/ku6XQTDfYh0" target="_blank" class="btn btn-primary rounded-pill">
                            Watch on YouTube
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-4 col-sm-6">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/KbcUp8HFCE0" title="YouTube video" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Benefits of TOEIC® test</h5>
                        <p class="card-text text-muted">
                           Discover how the TOEIC® test can open doors to better job opportunities and career growth across the globe.
                        </p>
                        <a href="https://youtu.be/KbcUp8HFCE0" target="_blank" class="btn btn-primary rounded-pill">
                            Watch on YouTube
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-4 col-sm-6">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/ndCUaJLm4sY" title="YouTube video" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">TOEIC® Tests Prove English Language Proficiency</h5>
                        <p class="card-text text-muted">
                           Show your English skills to employers with trusted TOEIC® scores.
                        </p>
                        <a href="https://youtu.be/ndCUaJLm4sY" target="_blank" class="btn btn-primary rounded-pill">
                            Watch on YouTube
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-xl-3">
        <div class="preparation-materials bg-white p-3 rounded shadow-sm">
            <h5 class="fw-semibold mb-3">Preparation Materials</h5>

            <ul class="list-unstyled mb-0">
                <li class="mb-3">
                    <h6 class="mb-1">How the Test Works</h6>
                    <a href="https://www.ets.org/pdfs/toeic/toeic-bridge-listening-reading-tests-examinee-handbook.pdf" target="_blank" class="btn btn-sm btn-outline-primary">
                        Read More
                    </a>
                </li>
                <li class="mb-3">
                    <h6 class="mb-1">How Scores Work</h6>
                    <a href="https://www.ets.org/content/dam/ets-org/pdfs/toeic/toeic-listening-reading-score-descriptors.pdf" target="_blank" class="btn btn-sm btn-outline-primary">
                        Read More
                    </a>
                </li>
                <li class="mb-3">
                    <h6 class="mb-1">Test Rules</h6>
                    <a href="https://www.ets.org/content/dam/ets-org/pdfs/toeic/toeic-listening-reading-score-descriptors.pdf" target="_blank" class="btn btn-sm btn-outline-primary">
                        Read More
                    </a>
                </li>
                <li>
                    <h6 class="mb-1">Official Test Guide</h6>
                    <a href="https://www.ets.org/content/dam/ets-org/pdfs/toeic/toeic-listening-reading-sample-test.pdf" target="_blank" class="btn btn-sm btn-outline-primary">
                        Download PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script src="https://cdn.lordicon.com/lordicon.js"></script>
@endpush
