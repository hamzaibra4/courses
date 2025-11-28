@extends('layouts.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Chapter</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Chapter')   <li class="breadcrumb-item"><a href="{{route("chapter.index")}}">Home</a></li>@endcan
                            <li class="breadcrumb-item active">{{ $chapter ? 'Edit chapter' : 'Add chapter' }}</li>

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
                                <h4 class="card-title">Chapter</h4>
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
                                            <form action="{{ $chapter ? route('chapter.update', $chapter->id) : route('chapter.store') }}" method="POST" class="floating-labels" enctype="multipart/form-data">
                                                @if($chapter)
                                                    @method('PUT')
                                                @endif
                                                @csrf
                                                <div class="form-body">
                                                    <div class="form-body">
                                                        <div class="form-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">Name: <span></span></label>
                                                                        <input id="name" required type="text" class="form-control" name="name" placeholder="Enter the name" value="{{ $chapter->name ?? old('name') }}"/>
                                                                        @error('title')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>




                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="text">Text</label>
                                                                            <textarea id="text"

                                                                                      class="form-control"
                                                                                      name="text"
                                                                                      rows="5"
                                                                                      placeholder="Enter your text">{{ $chapter->text ?? old('text') }}</textarea>

                                                                            @error('fulltext')
                                                                            <div class="error-msg">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                    <label for="itemindex">Index</label>
                                                                    <input type="number"  class="form-control"  name="itemindex" value="{{ old('itemindex', $chapter->item_index ?? '') }}""
                                                                    >
                                                                    @error('itemindex')
                                                                    <div class='error-msg'>{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="course_id" class="form-label">Select Course</label>
                                                                    <select class="form-select" name="course_id" id="course_id">
                                                                        <option value="">Select Course</option>

                                                                        @foreach ($course as $obj)
                                                                            <option value="{{ $obj->id }}"
                                                                                {{ isset($chapter) && $chapter->course_id == $obj->id ? 'selected' : '' }}>
                                                                                {{ $obj->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                                <div id="preview-container" class="d-flex flex-wrap"></div>

                                                        @error('image.*')
                                                        <div class='error-msg'>{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                @can('List_Chapter')
                                                        <a href="{{route('chapter.index')}}">
                                                            <button type="button" class="btn btn-warning mr-1 button-cancel">
                                                                <i class="ft-x"></i>&nbsp;Cancel
                                                            </button>
                                                        </a>
                                                    @endcan
                                                    @if(is_null($chapter))
                                                        @can('Add_Chapter')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i>&nbsp;Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Chapter')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i>&nbsp;Save
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
