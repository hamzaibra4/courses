@extends('layouts.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Favorite videos</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Favorite_Video')   <li class="breadcrumb-item"><a href="{{route("favorite-video.index")}}">Home</a></li>@endcan
                            <li class="breadcrumb-item active">{{ $favoritevideo ? 'Edit favorite videos' : 'Add favorite videos' }}</li>

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
                                <h4 class="card-title">Favorite videos</h4>
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
                                            <form action="{{ $favoritevideo ? route('favorite-video.update', $favoritevideo->id) : route('favorite-video.store') }}"
                                                  method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf
                                                @if($favoritevideo)
                                                    @method('PUT')
                                                @endif


                                                <div class="form-body">


                                                    {{-- Select Chapter --}}
                                                    <div class="form-group">
                                                        <label for="studentid" class="form-label">Select Student</label>
                                                        <select class="form-select" name="studentid" id="studentid">
                                                            <option value="">Select student</option>

                                                            @foreach ($student as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ isset($favoritevideo) && $favoritevideo->student_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->f_name }} {{ $obj->l_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('studentid')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="sectionid" class="form-label">Select Section video</label>
                                                        <select class="form-select" name="sectionid" id="sectionid">
                                                            <option value="">Select Section video</option>

                                                            @foreach ($sectionvideo as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ isset($favoritevideo) && $favoritevideo->section_video_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->path }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('sectionid')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Buttons --}}
                                                <div class="mt-2">
                                                    @can('List_Favorite_Video')
                                                        <a href="{{ route('favorite-video.index') }}" class="btn btn-warning">
                                                            <i class="ft-x"></i> Cancel
                                                        </a>
                                                    @endcan

                                                    @if(!$favoritevideo)
                                                        @can('Add_Favorite_Video')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Favorite_Video')
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
