@extends('layouts.front')

@section('content')
    <!-- Page Content -->
    <div class="page-section">
        <div class="container page__container">

            <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-24pt"
                 style="white-space: nowrap;">
                <small class="flex text-muted text-headings text-uppercase mr-3 mb-2 mb-sm-0">
                    Displaying {{ $courses->count() }} out of {{ $courses->total() }} courses
                </small>

{{--                <div class="w-auto ml-sm-auto table d-flex align-items-center mb-2 mb-sm-0">--}}
{{--                    <small class="text-muted text-headings text-uppercase mr-3 d-none d-sm-block">Sort by</small>--}}
{{--                    <a href="#" class="sort desc small text-headings text-uppercase">Newest</a>--}}
{{--                    <a href="#" class="sort small text-headings text-uppercase ml-2">Popularity</a>--}}
{{--                </div>--}}

{{--                <a href="#"--}}
{{--                   data-target="#library-drawer"--}}
{{--                   data-toggle="sidebar"--}}
{{--                   class="btn btn-sm btn-white ml-sm-16pt">--}}
{{--                    <i class="material-icons icon--left">tune</i> Filters--}}
{{--                </a>--}}

            </div>

            <div class="page-separator">
                <div class="page-separator__text">Courses</div>
            </div>

            <!-- START COURSES GRID -->
            <div class="row card-group-row">

                @forelse($courses as $c)
                    @php $course = $c->getCourse; @endphp
                    <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                        <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card"
                             data-toggle="popover"
                             data-trigger="click">

                            <a href="student-course.html"
                               class="card-img-top js-image"
                               data-position=""
                               data-height="140">
                                <img src="{{asset($course->image)}}"
                                     alt="course">
                                <span class="overlay__content">
                                            <span class="overlay__action d-flex flex-column text-center">
                                                <i class="material-icons icon-32pt">play_circle_outline</i>
                                                <span class="card-title text-white">Preview</span>
                                            </span>
                                        </span>
                            </a>

                            <div class="card-body flex">
                                <div class="d-flex">
                                    <div class="flex">
                                        <a class="card-title"
                                           href="student-course.html">{{$course->name}}</a>
{{--                                        <small class="text-50 font-weight-bold mb-4pt">Ahmad Ibrahim</small>--}}
                                    </div>

                                </div>
{{--                                <div class="d-flex">--}}
{{--                                    <div class="rating flex">--}}
{{--                                        <span class="rating__item"><span class="material-icons">star</span></span>--}}
{{--                                        <span class="rating__item"><span class="material-icons">star</span></span>--}}
{{--                                        <span class="rating__item"><span class="material-icons">star</span></span>--}}
{{--                                        <span class="rating__item"><span class="material-icons">star</span></span>--}}
{{--                                        <span class="rating__item"><span class="material-icons">star_border</span></span>--}}
{{--                                    </div>--}}
{{--                                    <!-- <small class="text-50">6 hours</small> -->--}}
{{--                                </div>--}}
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-between">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>{{$course->nb_of_hours}}</small></p>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>{{count($course->getChapters)}} lessons</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="popoverContainer d-none">
                            <div class="media">
                                <div class="media-body">
                                    <div class="card-title mb-0">{{$course->name}}</div>
{{--                                    <p class="lh-1 mb-0">--}}
{{--                                        <span class="text-50 small">with</span>--}}
{{--                                        <span class="text-50 small font-weight-bold">Ahmad Ibrahim</span>--}}
{{--                                    </p>--}}
                                </div>
                            </div>

                            <p class="my-16pt text-70">{{$course->brief_description}}</p>

                            <div class="mb-16pt">
                                @foreach($course->getDetails as $details)
                                    <div class="d-flex align-items-center">
                                        <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>{{$details->title}}</small></p>
                                    </div>
                                @endforeach


                            </div>

                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center mb-4pt">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>{{$course->nb_of_hours}}</small></p>
                                    </div>
                                    <div class="d-flex align-items-center mb-4pt">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>{{count($course->getChapters)}} lessons</small></p>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <a href="{{route('view-course',['id'=>$course->id])}}"
                                       class="btn btn-primary">View Course</a>
                                </div>
                            </div>

                        </div>

                    </div>

                @empty
                    <p class="text-muted">No courses found.</p>
                @endforelse

            </div>
            <!-- END COURSES GRID -->

            <div class="mt-4 mb-32pt">
            {{ $courses->links('pagination.student-pagination') }}
            </div>

        </div>
    </div>

@endsection
