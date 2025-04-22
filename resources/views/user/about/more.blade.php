@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="hero text-center">
  <h1 class=" fw-bold">TOEIC Listening & Reading Test</h1>
  <h3 class="fw-normal">Test information.</h3>
</div>

<div class="container">
  <div class="accordion" id="toeicAccordion">

    <!-- Why Choose TOEIC -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingWhy">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWhy">
          <i class="bi bi-stars me-2"></i> Why Choose TOEIC?
        </button>
      </h2>
      <div id="collapseWhy" class="accordion-collapse collapse show" data-bs-parent="#toeicAccordion">
        <div class="accordion-body">
          <ul>
            <li>📈 Improve your English for work & study</li>
            <li>🏆 Gain recognition from employers globally</li>
            <li>📋 Track your English skill progress</li>
            <li>🎯 Supports job promotions and graduation</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Format -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingFormat">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFormat">
          <i class="bi bi-layout-text-window-reverse me-2"></i> Test Format
        </button>
      </h2>
      <div id="collapseFormat" class="accordion-collapse collapse" data-bs-parent="#toeicAccordion">
        <div class="accordion-body">
          <div class="row">
            <div class="col-md-6">
              <h5><i class="bi bi-ear me-1"></i> Listening Section</h5>
              <ul>
                <li>Part 1: Photographs</li>
                <li>Part 2: Q&A</li>
                <li>Part 3: Conversations</li>
                <li>Part 4: Talks</li>
                <li>100 questions | 45 min (2h ver)</li>
                <li>45 questions | 25 min (1h ver)</li>
              </ul>
            </div>
            <div class="col-md-6">
              <h5><i class="bi bi-book me-1"></i> Reading Section</h5>
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
    </div>

    <!-- Registration -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingRegis">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRegis">
          <i class="bi bi-pencil-square me-2"></i> Registration
        </button>
      </h2>
      <div id="collapseRegis" class="accordion-collapse collapse" data-bs-parent="#toeicAccordion">
        <div class="accordion-body">
          <ul>
            <li>Register year-round in France</li>
            <li>Upload passport-style photo for certificate</li>
            <li>Register through institutions if applicable</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Test Day -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTestDay">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTestDay">
          <i class="bi bi-calendar-check me-2"></i> On Test Day
        </button>
      </h2>
      <div id="collapseTestDay" class="accordion-collapse collapse" data-bs-parent="#toeicAccordion">
        <div class="accordion-body">
          <p>Bring these:</p>
          <ul>
            <li>🆔 Valid ID</li>
            <li>📝 Admission Form</li>
            <li>📄 Consent (if under 18)</li>
            <li>✏️ HB pencils & eraser (paper test)</li>
          </ul>
          <a href="https://etswebsiteprod.cdn.prismic.io/etswebsiteprod/ZnPW45m069VX153H_MAN037-ProctorExam_TOEIC-4-Skills_EXHB_IP_PP_CBT.pdf" class="btn btn-outline-primary btn-sm" target="_blank">
            <i class="bi bi-file-earmark-text"></i> Handbook PDF
          </a>
        </div>
      </div>
    </div>

    <!-- Score -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingScore">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseScore">
          <i class="bi bi-bar-chart-line me-2"></i> Score & Certificate
        </button>
      </h2>
      <div id="collapseScore" class="accordion-collapse collapse" data-bs-parent="#toeicAccordion">
        <div class="accordion-body">
          <ul>
            <li>Range: 10–990</li>
            <li>Section scores: 5–495</li>
            <li>CEFR level mapped (A1–C1)</li>
            <li>Valid for 2 years</li>
            <li>Instant or 10–15 day delivery</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Preparation -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingPrep">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrep">
          <i class="bi bi-journal-bookmark me-2"></i> Preparation
        </button>
      </h2>
      <div id="collapsePrep" class="accordion-collapse collapse" data-bs-parent="#toeicAccordion">
        <div class="accordion-body">
          <ul>
            <li><a href="https://etswebsiteprod.cdn.prismic.io/etswebsiteprod/29619a45-b3ed-4cdc-9fa4-8bd03a86b74f_toeic-listening-reading-sample-test.pdf" target="_blank">📄 Sample Test PDF</a></li>
            <li><a href="https://etswebsiteprod.cdn.prismic.io/etswebsiteprod/32325931-b50b-4959-9b79-fcd744eb2b89_Audio+Files+for+TOEIC+Sample+Test.zip" target="_blank">🎧 Sample Audio</a></li>
            <li>Official Online Prep Course (90+ hours)</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Remote Test -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingRemote">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRemote">
          <i class="bi bi-laptop me-2"></i> Remote Testing
        </button>
      </h2>
      <div id="collapseRemote" class="accordion-collapse collapse" data-bs-parent="#toeicAccordion">
        <div class="accordion-body">
          <ul>
            <li>1h or 2h versions available</li>
            <li>Accessible via institutions</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Quick Info -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingQuickInfo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQuickInfo">
          <i class="bi bi-info-circle me-2"></i> Quick Info
        </button>
      </h2>
      <div id="collapseQuickInfo" class="accordion-collapse collapse" data-bs-parent="#toeicAccordion">
        <div class="accordion-body">
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
    </div>

  </div>
</div>
<br><br><br>
@endsection
