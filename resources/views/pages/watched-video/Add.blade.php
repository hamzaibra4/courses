@extends('layouts.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Watched videos</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Watched_Video')   <li class="breadcrumb-item"><a href="{{route("watched-video.index")}}">Home</a></li>@endcan
                            <li class="breadcrumb-item active">{{ $watchedvideo ? 'Edit watched videos' : 'Add watched videos' }}</li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="file-export">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Watched videos</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <form action="{{ $watchedvideo ? route('watched-video.update', $watchedvideo->id) : route('watched-video.store') }}"
                                                  method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf
                                                @if($watchedvideo)
                                                    @method('PUT')
                                                @endif


                                                <div class="form-body">

                                                    {{-- Title --}}
                                                    <div class="form-group">
                                                        <label for="studentid" class="form-label">Select Student</label>
                                                        <select class="form-select" name="studentid" id="studentid">
                                                            <option value="">Select Section</option>

                                                            @foreach ($student as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ isset($watchedvideo) && $watchedvideo->student_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->f_name  }} {{ $obj->l_name  }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('$watchedvideo')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>



                                                    <div class="form-group">
                                                        <label for="sectionid" class="form-label">Select Section</label>
                                                        <select class="form-select" name="sectionvideo" id="sectionvideo">
                                                            <option value="">Select Section</option>

                                                            @foreach ($sectionvideo as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ isset($watchedvideo) && $watchedvideo->section_video_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->path }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('$watchedvideo')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                {{-- Buttons --}}
                                                <div class="mt-2">
                                                    @can('List_Watched_Video')
                                                        <a href="{{ route('watched-video.index') }}" class="btn btn-warning">
                                                            <i class="ft-x"></i> Cancel
                                                        </a>
                                                    @endcan

                                                    @if(!$watchedvideo)
                                                        @can('Add_Watched_Video')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Watched_Video')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcan
                                                    @endif
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
