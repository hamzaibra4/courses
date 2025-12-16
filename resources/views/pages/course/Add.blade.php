@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Course</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Course')
                                <li class="breadcrumb-item"><a href="{{route('course.index')}}">Home</a></li>
                            @endcan
                            <li class="breadcrumb-item active">{{ $course ? 'Edit course' : 'Add course' }}</li>
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
                                <h4 class="card-title">Course</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body">

                                    <form action="{{ $course ? route('course.update', $course->id) : route('course.store') }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @if($course) @method('PUT') @endif

                                        <div class="form-body">
                                            <div class="row">
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name<span>*</span></label>
                                                <input id="name" type="text" required class="form-control" name="name" value="{{ $course->name ?? old('name') }}" placeholder="Enter Course Name">
                                                @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                                            </div>
                                            </div>
                                                <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Price<span>*</span></label>
                                                <input id="price" type="number" class="form-control" name="price" value="{{ $course->price ?? old('price') }}" placeholder="Enter your Price">
                                                @error('price') <div class="error-msg">{{ $message }}</div> @enderror
                                            </div>
                                                </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="itemindex">Index<span>*</span></label>
                                                    <input id="itemindex" type="number" class="form-control" name="itemindex" value="{{ $course->item_index ?? old('item_index') }}" placeholder="Enter your Index">
                                                    @error('itemindex') <div class="error-msg">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nb_of_hours">Course Hours<span>*</span></label>
                                                    <input id="nb_of_hours" type="number" class="form-control" name="nb_of_hours" value="{{ $course->nb_of_hours ?? old('nb_of_hours') }}" placeholder="Enter the Course Hours">
                                                    @error('nb_of_hours') <div class="error-msg">{{ $message }}</div> @enderror
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description<span>*</span></label>
                                                <textarea id="description" class="form-control" name="description">{{ $course->description ?? old('description') }}</textarea>
                                                @error('description') <div class="error-msg">{{ $message }}</div> @enderror
                                            </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="brief_description">Brief Description<span>*</span></label>
                                                    <textarea id="brief_description" class="form-control" name="brief_description">{{ $course->brief_description ?? old('brief_description') }}</textarea>
                                                    @error('brief_description') <div class="error-msg">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group ml-2">
                                                <input type="hidden" name="feature" value="0">

                                                <input type="checkbox" name="feature" value="1" class="form-check-input" id="feature"
                                                    {{ isset($course) && $course->is_featured == 1 ? 'checked' : '' }}>

                                                <label for="feature" class="form-check-label">Mark as Featured</label>

                                                @error('feature')
                                                <div class="error-msg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label for="projectinput1">Image<span>*</span></label>
                                                        <input type="file" @if(empty($course->image)) required @endif name="image" onchange="previewFile(this, 'previewImage')" id="projectinput1" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                @if($course?->image)
                                                    <div class="form-group">
                                                        <div class="image-area remove-black margin1020">
                                                            <img  src="{{asset($course->image)}}" data-enlargable id="previewImage" class="img" width="200px">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <div class="image-area remove-black margin1020">
                                                            <img src="{{ old('image') }}" data-enlargable id="previewImage" class="img onadd" width="200px">
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                                    <div class="col-md-12">
                                                        <label>What you will learn
                                                            <a  onclick="addNewItem()">
                                                                <i class="fa fa-plus icon-plus iconStyle"></i>
                                                            </a>
                                                        </label>
                                                    </div>

                                                    <div class="col-md-12 pr-0" id="append-here">
                                                        <input type="hidden" id="description-counter" name="counter" value="0">
                                                        @if($course && $course->getDetails && $course->getDetails->count() > 0)
                                                            <input type="hidden" id="existing-data" value="{{ json_encode($course->getDetails->map(function($detail) { return ['title' => $detail->title]; })->toArray()) }}">
                                                        @else
                                                            <input type="hidden" id="existing-data" value="">
                                                        @endif
                                                    </div>

                                            </div>
                                            <div class="form-actions mt-3">
                                                @can('List_Course')
                                                    <a href="{{ route('course.index') }}">
                                                        <button type="button" class="btn btn-warning">
                                                            <i class="ft-x"></i> Cancel
                                                        </button>
                                                    </a>
                                                @endcan

                                                    @canany(['Add_Course', 'Edit_Course'])
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="la la-check-square-o"></i> Save
                                                        </button>
                                                    @endcanany
                                            </div>

                                        </div>
                                            </div>
                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
@section('customjs')
    <script src="{{asset('cms/custom/course.js')}}" type="text/javascript"></script>
@endsection
