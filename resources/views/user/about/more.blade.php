@extends('layouts.app')

@section('content')
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<div class="hero text-center">
  <h1 class="display-6 fw-bold">TOEIC Listening & Reading Test</h1>
  <p class="display-6 lead">Test information.</p>
</div>

<div class="container">
  <!-- WHY CHOOSE -->
  <div class="card mb-4 card-custom">
    <div class="card-body">
      <h3 class="card-title"><i class="bi bi-stars"></i> Why Choose TOEIC?</h3>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">📈 Improve your English for work & study</li>
        <li class="list-group-item">🏆 Gain recognition from employers globally</li>
        <li class="list-group-item">📋 Track your English skill progress</li>
        <li class="list-group-item">🎯 Supports job promotions and graduation</li>
      </ul>
    </div>
  </div>

  <!-- FORMAT -->
  <div class="row mb-4">
    <div class="col-md-6 mb-3">
      <div class="card card-custom">
        <div class="card-body">
          <h4 class="card-title"><i class="bi bi-ear"></i> Listening Section</h4>
          <ul>
            <li>Part 1: Photographs</li>
            <li>Part 2: Q&A</li>
            <li>Part 3: Conversations</li>
            <li>Part 4: Talks</li>
            <li>100 questions | 45 min (2h ver)</li>
            <li>45 questions | 25 min (1h ver)</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card card-custom">
        <div class="card-body">
          <h4 class="card-title"><i class="bi bi-book"></i> Reading Section</h4>
          <ul>
            <li>Part 5: Incomplete Sentences</li>
            <li>Part 6: Text Completion</li>
            <li>Part 7: Reading Comprehension</li>
            <li>100 questions | 75 min (2h ver)</li>
            <li>45 questions | ~37 min (1h ver)</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- REGISTRATION -->
  <div class="card mb-4 card-custom">
    <div class="card-body">
      <h3 class="card-title"><i class="bi bi-pencil-square"></i> Registration</h3>
      <ul>
        <li>Register year-round in France</li>
        <li>Upload passport-style photo for certificate</li>
        <li>Register through institutions if applicable</li>
      </ul>
    </div>
  </div>

  <!-- TEST DAY -->
  <div class="card mb-4 card-custom">
    <div class="card-body">
      <h3 class="card-title"><i class="bi bi-calendar-check"></i> On Test Day</h3>
      <p>Bring these:</p>
      <ul>
        <li>🆔 Valid ID</li>
        <li>📝 Admission Form</li>
        <li>📄 Consent (if under 18)</li>
        <li>✏️ HB pencils & eraser (paper test)</li>
      </ul>
      <a href="https://etswebsiteprod.cdn.prismic.io/etswebsiteprod/ZnPW45m069VX153H_MAN037-ProctorExam_TOEIC-4-Skills_EXHB_IP_PP_CBT.pdf" class="btn btn-outline-primary btn-sm" target="_blank"><i class="bi bi-file-earmark-text"></i> Handbook PDF</a>
    </div>
  </div>

  <!-- SCORE -->
  <div class="card mb-4 card-custom">
    <div class="card-body">
      <h3 class="card-title"><i class="bi bi-bar-chart-line"></i> Score & Certificate</h3>
      <ul>
        <li>Range: 10–990</li>
        <li>Section scores: 5–495</li>
        <li>CEFR level mapped (A1–C1)</li>
        <li>Valid for 2 years</li>
        <li>Instant or 10–15 day delivery</li>
      </ul>
    </div>
  </div>

  <!-- PREP -->
  <div class="card mb-4 card-custom">
    <div class="card-body">
      <h3 class="card-title"><i class="bi bi-journal-bookmark"></i> Preparation</h3>
      <ul>
        <li><a href="https://etswebsiteprod.cdn.prismic.io/etswebsiteprod/29619a45-b3ed-4cdc-9fa4-8bd03a86b74f_toeic-listening-reading-sample-test.pdf" target="_blank">📄 Sample Test PDF</a></li>
        <li><a href="https://etswebsiteprod.cdn.prismic.io/etswebsiteprod/32325931-b50b-4959-9b79-fcd744eb2b89_Audio+Files+for+TOEIC+Sample+Test.zip" target="_blank">🎧 Sample Audio</a></li>
        <li>Official Online Prep Course (90+ hours)</li>
      </ul>
    </div>
  </div>

  <!-- REMOTE TEST -->
  <div class="card mb-4 card-custom">
    <div class="card-body">
      <h3 class="card-title"><i class="bi bi-laptop"></i> Remote Testing</h3>
      <ul>
        <li>1h or 2h versions available</li>
        <li>Accessible via institutions</li>
      </ul>
    </div>
  </div>

  <!-- QUICK INFO -->
  <div class="alert alert-dark">
    <h5><i class="bi bi-info-circle"></i> Quick Info</h5>
    <div class="row">
      <div class="col-md-6">
        <ul>
          <li>Total Duration: 1h or 2h</li>
          <li>Format: Paper or Online</li>
          <li>Skills: Listening & Reading</li>
        </ul>
      </div>
      <div class="col-md-6">
        <ul>
          <li>Score Validity: 2 Years</li>
          <li>CEFR Level: A1–C1</li>
          <li>Discounts: Students, Military, Job Seekers</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection