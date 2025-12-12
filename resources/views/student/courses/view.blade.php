@extends('layouts.front')

@section('content')
    <!-- Page Content -->
    <div class="mdk-box bg-primary mdk-box--bg-gradient-primary2 js-mdk-box mb-0"
         data-effects="blend-background">
        <div class="mdk-box__content">
            <div class="hero py-64pt text-center text-sm-left">
                <div class="container page__container">
                    <h1 class="text-white">{{$course->name}}</h1>
                    <p class="lead text-white-50 measure-hero-lead mb-24pt text-justify">{{$course->brief_description}}</p>
                </div>
            </div>
            <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
                <div class="container page__container">
                    <ul class="nav navbar-nav flex align-items-sm-center">
                        <li class="nav-item navbar-list__item">
                            <i class="material-icons text-muted icon--left">schedule</i>
                            {{$course->nb_of_hours}}
                        </li>
                        <li class="nav-item navbar-list__item">
                            <i class="material-icons text-muted icon--left">play_circle_outline</i>
                            {{count($course->getChapters)}} lessons
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section bg-white border-top-2 border-bottom-2">

        <div class="container page__container">
            <div class="row ">
                <div class="col-md-7">
                    <div class="page-separator">
                        <div class="page-separator__text">About this course</div>
                    </div>
                    <p class="text-70 text-justify">{{$course->description}}</p>
                </div>
                @if(count($course->getDetails) > 0)
                <div class="col-md-5">
                    <div class="page-separator">
                        <div class="page-separator__text bg-white">What you’ll learn</div>
                    </div>
                    <ul class="list-unstyled">
                        @foreach($course->getDetails as $details)
                        <li class="d-flex align-items-center">
                            <span class="material-icons text-50 mr-8pt">check</span>
                            <span class="text-70">{{$details->title}}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                    @endif
            </div>
        </div>

    </div>

    <div class="container page__container">
        <div class="row">

            <div class="col-lg-7">
                <div class="border-left-2 page-section pl-32pt">

                    @foreach($course->getChapters as $chapter)
                    <div class="d-flex align-items-center page-num-container">
                        <div class="page-num">{{ $loop->iteration }}</div>
                        <h4>{{$chapter->name}}</h4>
                    </div>
                    <p class="text-70 mb-24pt text-justify">{{$chapter->text}}</p>
                    @if(count($chapter->getSections) > 0)
                    <div class="card mb-32pt mb-lg-32pt">
                        <ul class="accordion accordion--boxed js-accordion mb-0"
                            id="toc-{{ $chapter->id }}">
                            <li class="accordion__item open">
                                <a class="accordion__toggle"
                                   data-toggle="collapse"
                                   data-parent="#toc-{{  $chapter->id }}"
                                   href="#toc-content-{{  $chapter->id }}">
                                    <span class="flex">1 of {{count($chapter->getSections)}} lessons</span>
                                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_up</span>
                                </a>
                                <div class="accordion__menu">
                                    <ul class="list-unstyled collapse"
                                        id="toc-content-{{  $chapter->id }}">
                                        @foreach($chapter->getSections as $section)
                                            <li class="accordion__menu-link">
                                                <span class="material-icons icon-16pt icon--left text-body">play_circle_outline</span>
                                                <a class="flex"
                                                   href="{{route('view-lesson',['id'=>$section->id])}}">{{$section->title}}</a>
                                                <span class="text-muted">{{$section->nb_of_hours}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @endif


                        @if(count($chapter->getMaterials) > 0)
                            <div class="card mb-32pt mb-lg-64pt">
                                <ul class="accordion accordion--boxed js-accordion mb-0"
                                    id="toc-{{ $chapter->id }}-2">
                                    <li class="accordion__item open">
                                        <a class="accordion__toggle"
                                           data-toggle="collapse"
                                           data-parent="#toc-{{  $chapter->id }}-2"
                                           href="#toc-content-{{  $chapter->id }}-2">
                                            <span class="flex">{{count($chapter->getMaterials)}} Materials</span>
                                            <span class="accordion__toggle-icon material-icons">keyboard_arrow_up</span>
                                        </a>
                                        <div class="accordion__menu">
                                            <ul class="list-unstyled collapse"
                                                id="toc-content-{{  $chapter->id }}-2">
                                                @foreach($chapter->getMaterials as $material)
                                                    <li class="accordion__menu-link">
                                                        @foreach($material->getMaterialPdfs as $pdf)
                                                        <span class="material-icons icon-16pt icon--left text-body">receipt</span>
                                                        <a class="flex"
                                                          download href="{{asset($pdf->path)}}">{{$pdf->name}}</a>
                                                        @endforeach
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endif

                    @endforeach

                </div>
            </div>

            <div class="col-lg-5 page-nav">
                <div class="page-section">
                    <div class="page-nav__content">
                        <div class="page-separator">
                            <div class="page-separator__text">Table of contents</div>
                        </div>

                    </div>
                    <nav class="nav page-nav__menu">
                        @foreach($course->getChapters as $chapter)
                        <a class="nav-link active"
                           href="#">{{$chapter->name}}</a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- // END Page Content -->

@endsection
