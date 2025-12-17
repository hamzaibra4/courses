@extends('layouts.app')

@section('content')
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Section</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Section')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('section.index') }}">Home</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active">
                                {{ $section ? 'Edit section' : 'Add section' }}
                            </li>
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
                                <h4 class="card-title">Section</h4>
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
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

                                    <form action="{{ $section ? route('section.update', $section->id) : route('section.store') }}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @if($section)
                                            @method('PUT')
                                        @endif

                                        <div class="form-body">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Name</label>
                                                        <input id="title"
                                                               type="text"
                                                               class="form-control"
                                                               name="title"
                                                               placeholder="Enter the Section Name"
                                                               value="{{ old('title', $section->title ?? '') }}">
                                                        @error('title')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nb_of_hours">Number of Hours</label>
                                                        <input id="nb_of_hours"
                                                               type="text"
                                                               class="form-control"
                                                               name="nb_of_hours"
                                                               placeholder="Enter Number of hours"
                                                               value="{{ old('nb_of_hours', $section->nb_of_hours ?? '') }}">
                                                        @error('nb_of_hours')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea id="description"
                                                                  class="form-control ckeditor"
                                                                  name="description"
                                                                  placeholder="Enter your Description">{{ old('description', $section->description ?? ($section->document ?? '')) }}</textarea>
                                                        @error('description')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_index">Index</label>
                                                        <input id="item_index"
                                                               type="number"
                                                               class="form-control"
                                                               name="item_index"
                                                               placeholder="Enter your Index"
                                                               value="{{ old('item_index', $section->item_index ?? '') }}">
                                                        @error('item_index')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="chapter_id">Chapter <span class="is-required">*</span></label>
                                                        @php $current = old('chapter_id', optional($section)->chapter_id); @endphp
                                                        <select class="form-control my-2 select2"
                                                                name="chapter_id"
                                                                id="chapter_id"
                                                                required>
                                                            <option value="" {{ $current ? '' : 'selected' }}>Select Chapter</option>
                                                            @foreach($chapters as $id => $name)
                                                                <option value="{{ $id }}" @selected($current == $id)>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('chapter_id')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
{{--                                            <div class="row">--}}
{{--                                                <div class="col-md-12">--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <label for="material_id">Material</label>--}}
{{--                                                        @php $current = old('material_id', optional($section)->material_id); @endphp--}}
{{--                                                        <select class="form-control my-2 select2"--}}
{{--                                                                name="material_id"--}}
{{--                                                                id="material_id"--}}
{{--                                                                required>--}}
{{--                                                            <option value="" {{ $current ? '' : 'selected' }}>Select Material</option>--}}
{{--                                                            @foreach($materials as $id => $name)--}}
{{--                                                                <option value="{{ $id }}" @selected($current == $id)>{{ $name }}</option>--}}
{{--                                                            @endforeach--}}
{{--                                                        </select>--}}
{{--                                                        @error('material_id')--}}
{{--                                                        <div class="error-msg">{{ $message }}</div>--}}
{{--                                                        @enderror--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="projectinput1">Video <span>*</span></label>

                                                        <input type="file"
                                                               name="path"
                                                               accept="video/*"
                                                               onchange="previewFile(this, 'previewVideo')"
                                                               id="projectinput1"
                                                               class="form-control"
                                                               @if(empty($section->video_path)) required @endif>

                                                        @error('path')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="image-area remove-black margin1020">
                                                            <video controls id="previewVideo" class="img onadd" width="200" height="auto">
                                                                @if($section?->video_path)
                                                                    <source src="{{ asset($section->video_path) }}" type="video/mp4">
                                                                @else
                                                                    <source src="{{ old('video_path') }}" type="video/mp4">
                                                                @endif
                                                            </video>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="mt-2">
                                            @can('List_Section')
                                                <a href="{{ route('section.index') }}" class="btn btn-warning">
                                                    <i class="ft-x"></i> Cancel
                                                </a>
                                            @endcan

                                            @canany(['Add_Section', 'Edit_Section'])
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            @endcanany
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
    <script src="https://cdn.ckeditor.com/4.15.1/full-all/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
