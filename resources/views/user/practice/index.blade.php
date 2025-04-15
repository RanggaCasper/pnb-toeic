@extends('layouts.app')

@section('content')
<div class="row mb-3 pb-1">
    <div class="col-lg-12">
        <div class="overflow-hidden shadow-none card bg-light-info position-relative">
            <div class="px-4 py-3 card-body">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="mb-8 fs-3 fw-semibold">Start Practice TOEIC Test</h4>
                        <p class="fs-5">
                            Sharpen Your Skills, Boost Your Confidence <br>
                            Take Our Practice Test Today and Ace your TOEIC Dream Score
                        </p>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">  
                            <img src="https://expo2.lab-trpl.id/images/modelpractice.png" alt="" class="img-fluid" style="width: 350px;">
                        </div>
                    </div>
                </div>
                <button class="capitalize btn btn-sm waves-effect waves-light btn-primary fs-6">  Take Practice</button>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="text-center">
            <ul class="list-inline categories-filter animation-nav" id="filter">
                <li class="list-inline-item"><a class="categories active" data-filter="*">All</a></li>
                <li class="list-inline-item"><a class="categories" data-filter=".listening">Listening</a></li>
                <li class="list-inline-item"><a class="categories" data-filter=".reading">Reading</a></li>
            </ul>
        </div>

        <div class="row gallery-wrapper" style="position: relative; height: 1087.5px;">
            <div class="element-item col-xxl-3 col-xl-3 col-sm-6 listening" data-category="listening" style="position: absolute; left: 0px; top: 0px;">
                <div class="gallery-box card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper ">
                            <lord-icon src="https://cdn.lordicon.com/rszslpey.json" style="width: 80px; height: 80px;" trigger="loop">
                            </lord-icon>
                        </div>
                        <div class="box-content">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="text-muted mb-2 mb-md-0">
                                        <span class="text-body fs-5">Part 1 : Photographs</span>
                                        <br>
                                        <span class="fs-6">Listening</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="element-item col-xxl-3 col-xl-3 col-sm-6 listening" data-category="listening" style="position: absolute; left: 0px; top: 0px;">
                <div class="gallery-box card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper ">
                            <lord-icon src="https://cdn.lordicon.com/axteoudt.json" style="width: 80px; height: 80px;" trigger="loop">
                            </lord-icon>
                        </div>
                        <div class="box-content">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="text-muted mb-2 mb-md-0">
                                        <span class="text-body fs-5">Part 2: Question & Response</span>
                                        <br>
                                        <span class="fs-6">Listening</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="element-item col-xxl-3 col-xl-3 col-sm-6 listening" data-category="listening" style="position: absolute; left: 0px; top: 0px;">
                <div class="gallery-box card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper ">
                            <lord-icon src="https://cdn.lordicon.com/fozsorqm.json" style="width: 80px; height: 80px;" trigger="loop">
                            </lord-icon>
                        </div>
                        <div class="box-content">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="text-muted mb-2 mb-md-0">
                                        <span class="text-body fs-5">Part 3: Conversations</span>
                                        <br>
                                        <span class="fs-6">Listening</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="element-item col-xxl-3 col-xl-3 col-sm-6 listening" data-category="listening" style="position: absolute; left: 0px; top: 0px;">
                <div class="gallery-box card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper ">
                            <lord-icon src="https://cdn.lordicon.com/jdgfsfzr.json" style="width: 80px; height: 80px;" trigger="loop">
                            </lord-icon>
                        </div>
                        <div class="box-content">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="text-muted mb-2 mb-md-0">
                                        <span class="text-body fs-5">Part 4: Talks</span>
                                        <br>
                                        <span class="fs-6">Listening</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="element-item col-xxl-4 col-xl-4 col-sm-6 reading" data-category="reading" style="position: absolute; left: 0px; top: 0px;">
                <div class="gallery-box card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper ">
                            <lord-icon src="https://cdn.lordicon.com/ncmnezgk.json" style="width: 80px; height: 80px;" trigger="loop">
                            </lord-icon>
                        </div>
                        <div class="box-content">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="text-muted mb-2 mb-md-0">
                                        <span class="text-body fs-5">Part 5: Incomplete Sentences</span>
                                        <br>
                                        <span class="fs-6">Reading</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="element-item col-xxl-4 col-xl-4 col-sm-6 reading" data-category="reading" style="position: absolute; left: 0px; top: 0px;">
                <div class="gallery-box card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper ">
                            <lord-icon src="https://cdn.lordicon.com/fikcyfpp.json" style="width: 80px; height: 80px;" trigger="loop">
                            </lord-icon>
                        </div>
                        <div class="box-content">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="text-muted mb-2 mb-md-0">
                                        <span class="text-body fs-5">Part 6: Text Completion</span>
                                        <br>
                                        <span class="fs-6">Listening</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="element-item col-xxl-4 col-xl-4 col-sm-6 reading" data-category="reading" style="position: absolute; left: 0px; top: 0px;">
                <div class="gallery-box card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper">
                            <lord-icon src="https://cdn.lordicon.com/wjyqkiew.json" style="width: 80px; height: 80px;" trigger="loop">
                            </lord-icon>
                        </div>
                        <div class="box-content">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="text-muted mb-2 mb-md-0">
                                        <span class="text-body fs-5">Part 7: Reading Comprehension</span>
                                        <br>
                                        <span class="fs-6">Reading</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.lordicon.com/lordicon.js"></script>
<script src="https://themesbrand.com/velzon/html/master/assets/libs/isotope-layout/isotope.pkgd.min.js"></script>
<script src="https://themesbrand.com/velzon/html/master/assets/libs/glightbox/js/glightbox.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded",function(e){
        document.querySelector(".gallery-wrapper")&&(t=new Isotope(".gallery-wrapper",{
            itemSelector:".element-item",
            layoutMode:"fitRows"}
            ));
        var t,r=document.querySelector(".categories-filter"),r=(r&&r.addEventListener("click",function(e){
            matchesSelector(e.target,"li a")&&(e=e.target.getAttribute("data-filter"))&&t.arrange({filter:e})
        }),
        document.querySelectorAll(".categories-filter"));r&&Array.from(r).forEach(function(e){
            var t;(t=e).addEventListener("click",function(e){
                matchesSelector(e.target,"li a")&&(t.querySelector(".active").classList.remove("active"),e.target.classList.add("active"))
            })
        })
    });
    var lightbox=GLightbox({selector:".image-popup",title:!1});
</script>
@endpush
