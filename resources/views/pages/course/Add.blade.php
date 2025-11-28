@extends('layouts.app')
@section('content')

    <style>
        /* Improve form visuals */
        .form-group label {
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .form-control {
            border-radius: 6px !important;
            padding: 10px 12px !important;
        }

        .preview-img {
            margin-top: 10px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #ccc;
        }
    </style>

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Course</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_News')
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

                                            {{-- Title --}}
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input id="name" type="text" required class="form-control"
                                                       name="name"
                                                       value="{{ $course->name ?? old('name') }}"
                                                       placeholder="Enter name">
                                                @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                                            </div>

                                            {{-- Small Text --}}
                                            <div class="form-group">
                                                <label for="price">Price </label>
                                                <input id="price" type="number" class="form-control"
                                                       name="price"
                                                       value="{{ $course->price ?? old('price') }}"
                                                       placeholder="amount in $">
                                                @error('price') <div class="error-msg">{{ $message }}</div> @enderror
                                            </div>

                                            {{-- Full Text --}}
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea id="description" class="form-control" name="description"
                                                          rows="5"
                                                          placeholder="Text">{{ $course->description ?? old('description') }}</textarea>
                                                @error('description') <div class="error-msg">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="itemindex">Index</label>
                                                    <input type="number"  class="form-control"  name="itemindex" value="{{ old('itemindex', $course->item_index ?? '') }}""
                                                    >
                                                    @error('itemindex')
                                                    <div class='error-msg'>{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <input type="hidden" name="feature" value="0">

                                                <input type="checkbox"
                                                       name="feature"
                                                       value="1"
                                                       class="form-check-input"
                                                       id="feature"
                                                    {{ isset($course) && $course->is_featured == 1 ? 'checked' : '' }}>

                                                <label for="feature" class="form-check-label">Mark as Featured</label>

                                                @error('feature')
                                                <div class="error-msg">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Image Upload --}}
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="projectinput13">Image</label>
                                                    <input type="file" id="projectinput13" class="form-control"
                                                           name="image"
                                                           onchange="previewFile(this,'previewImg')">
                                                </div>
                                                <img id="previewImg" class="onadd"  width="150" height="150"/>
                                                @error('image')
                                                <div class='error-msg'>{{ $message }}</div>
                                                @enderror
                                            </div>


                                            {{-- Buttons --}}
                                            <div class="form-actions mt-3">
                                                @can('List_Course')
                                                    <a href="{{ route('course.index') }}">
                                                        <button type="button" class="btn btn-warning">
                                                            <i class="ft-x"></i> Cancel
                                                        </button>
                                                    </a>
                                                @endcan

                                                @if(!$course)
                                                    @can('Add_Course')
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="la la-check-square-o"></i> Save
                                                        </button>
                                                    @endcan
                                                @else
                                                    @can('Edit_Course')
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="la la-check-square-o"></i> Update
                                                        </button>
                                                    @endcan
                                                @endif
                                            </div>

                                        </div> {{-- end form-body --}}
                                    </form>

                                </div> {{-- end card-body --}}
                            </div>

                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
