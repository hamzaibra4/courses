@extends('layouts.front')

@section('content')
    <!-- Page Content -->
    <div class="navbar navbar-light border-0 navbar-expand-sm"
         style="white-space: nowrap;">
        <div class="container page__container flex-column flex-sm-row">
            <nav class="nav navbar-nav">
                <div class="nav-item py-16pt py-sm-0">
                    <div class="media flex-nowrap">
                        <div class="media-body d-flex flex-column">
                            <a href="student-take-course.html"
                               class="card-title">{{$lesson->getChapter->getCourse->name}}</a>
                            <div class="d-flex">
                                <span class="text-50 small font-weight-bold mr-8pt">{{$lesson->getChapter->name}} -</span>
                                <span class="text-50 small">{{$lesson->title}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="bg-primary pb-lg-64pt py-32pt">
        <div class="container page__container">
            <nav class="course-nav">
                <a data-toggle="tooltip"
                   data-placement="bottom"
                   data-title="Getting Started with Angular: Introduction"
                   href="#"><span class="material-icons">check_circle</span></a>
                <a data-toggle="tooltip"
                   data-placement="bottom"
                   data-title="Getting Started with Angular: Introduction to TypeScript"
                   href="#"><span class="material-icons text-primary">account_circle</span></a>
                <a data-toggle="tooltip"
                   data-placement="bottom"
                   data-title="Getting Started with Angular: Comparing Angular to AngularJS"
                   href="#"><span class="material-icons">play_circle_outline</span></a>
                <a data-toggle="tooltip"
                   data-placement="bottom"
                   data-title="Quiz: Getting Started with Angular"
                   href="student-take-quiz.html"><span class="material-icons">hourglass_empty</span></a>
            </nav>
            <div class="js-player bg-primary embed-responsive embed-responsive-16by9 mb-32pt">
                <div class="player embed-responsive-item">
                    <div class="player__content">
                        <div class="player__image"
                             style="--player-image: url(public/images/illustration/player.svg)"></div>
                        <a href="#"
                           class="player__play bg-primary">
                            <span class="material-icons">play_arrow</span>
                        </a>
                    </div>
                    <div class="player__embed d-none">
                        <iframe class="embed-responsive-item"
                                src="https://player.vimeo.com/video/97243285?title=0&amp;byline=0&amp;portrait=0"
                                allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap align-items-end mb-16pt">
                <h1 class="text-white flex m-0">{{$lesson->title}}</h1>
                <p class="h1 text-white-50 font-weight-light m-0">{{$lesson->nb_of_hours}}</p>
            </div>


        </div>
    </div>
    <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
        <div class=" container page__container">
            <div class="card dashboard-area-tabs p-relative o-hidden mb-0 w-100 border-0 no-border-radius">
                <!-- Tabs -->
                <div class="card-header2 p-0 nav">
                    <div class="row no-gutters" role="tablist">
                        <div class="col-auto">
                            <a href="#tab-active"
                               data-toggle="tab"
                               role="tab"
                               aria-selected="true"
                               class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start active">
                                <span class="h2 mb-0 mr-3">1</span>
                                <span class="flex d-flex flex-column">
                        <strong class="card-title">Content</strong>
                        <small class="card-subtitle text-50">Overview</small>
                    </span>
                            </a>
                        </div>

                        <div class="col-auto border-left border-right">
                            <a href="#tab-archived"
                               data-toggle="tab"
                               role="tab"
                               aria-selected="false"
                               class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start">
                                <span class="h2 mb-0 mr-3">2</span>
                                <span class="flex d-flex flex-column">
                        <strong class="card-title">Materials</strong>
                        <small class="card-subtitle text-50">Learning Tools</small>
                    </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tab contents -->
                <div class="card-body tab-content  ">
                    <div id="tab-active" class="tab-pane fade show active text-70 w-100">
                        <p class="mb-24pt text-justify">{{$lesson->description}}</p>
                    </div>

                    <div id="tab-archived" class="tab-pane fade text-70 w-100">
                        @if(count($lesson->getMaterials) > 0)
                                        <div class="accordion__menu">
                                            <ul class="list-unstyled collapse show"
                                                id="toc-content-{{  $lesson->id }}-2">
                                                @foreach($lesson->getMaterials as $material)
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
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
