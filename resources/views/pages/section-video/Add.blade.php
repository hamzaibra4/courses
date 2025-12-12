@extends('layouts.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">

        <!-- Header -->
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Section videos</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Section_Video')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('section-video.index') }}">Home</a>
                                </li>
                            @endcan

                            <li class="breadcrumb-item active">
                                {{ $sectionvideo ? 'Edit section videos' : 'Add section videos' }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Header -->


        <div class="content-body">
            <section id="file-export">
                <div class="row">
                    <div class="col-12">

                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title">Section videos</h4>
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

                                    <div class="card-body">

                                        <form action="{{ $sectionvideo ? route('section-video.update', $sectionvideo->id) : route('section-video.store') }}"
                                              method="POST" enctype="multipart/form-data">

                                            @csrf
                                            @if($sectionvideo)
                                                @method('PUT')
                                            @endif
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="item_index">Index</label>
                                                    <input id="item_index" type="number" class="form-control" name="item_index" value="{{ old('item_index', $sectionvideo->item_index ?? '') }}">
                                                    @error('item_index')
                                                    <div class="error-msg">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="section_id">Section <span class="is-required">*</span></label>
                                                            @php $current = old('section_id', optional($sectionvideo)->section_id); @endphp

                                                            <select class="form-control my-2 select2" name="section_id"
                                                                    id="section_id" required>
                                                                <option value="" {{ $current ? '' : 'selected' }}>Select Section</option>

                                                                @foreach($sections as $id => $name)
                                                                    <option value="{{ $id }}" @selected($current == $id)>
                                                                        {{ $name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            @error('section_id')
                                                            <div class="error-msg">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
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
                                                                   @if(empty($sectionvideo->path)) required @endif>

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
                                                                <video controls id="previewVideo" class="img" width="200px" height="auto">
                                                                    @if($sectionvideo?->path)
                                                                        <source src="{{ asset($sectionvideo->path) }}" type="video/mp4">
                                                                    @else
                                                                        <source src="{{ old('path') }}" type="video/mp4">
                                                                    @endif
                                                                </video>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="mt-2">

                                                @can('List_Section_Video')
                                                    <a href="{{ route('section-video.index') }}" class="btn btn-warning">
                                                        <i class="ft-x"></i> Cancel
                                                    </a>
                                                @endcan
                                                    @canany(['Add_Section_Video', 'Edit_Section_Video'])
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="la la-check-square-o"></i> Save
                                                        </button>
                                                    @endcanany

                                            </div>

                                        </form>

                                    </div> <!-- card-body -->

                                </div>
                            </div>

                        </div> <!-- card -->

                    </div>
                </div>
            </section>
        </div>

    </div>
@endsection
