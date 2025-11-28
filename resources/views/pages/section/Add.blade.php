@extends('layouts.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Section</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Section')   <li class="breadcrumb-item"><a href="{{route("section.index")}}">Home</a></li>@endcan
                            <li class="breadcrumb-item active">{{ $section ? 'Edit section' : 'Add section' }}</li>

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
                                            <form action="{{ $section ? route('section.update', $section->id) : route('section.store') }}"
                                                  method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf
                                                @if($section)
                                                    @method('PUT')
                                                @endif


                                                <div class="form-body">

                                                    {{-- Title --}}
                                                    <div class="form-group">
                                                        <label for="title">Name:</label>
                                                        <input id="title"
                                                               type="text"
                                                               class="form-control"
                                                               name="title"
                                                               placeholder="Enter the name"
                                                               value="{{ old('title', $section->title ?? '') }}">
                                                        @error('title')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- Document --}}
                                                    <div class="form-group">
                                                        <label for="document">Text</label>
                                                        <textarea id="document"
                                                                  class="form-control"
                                                                  name="document"
                                                                  rows="5"
                                                                  placeholder="Enter your text">{{ old('document', $section->document ?? '') }}</textarea>
                                                        @error('document')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- Item Index --}}
                                                    <div class="form-group">
                                                        <label for="itemindex">Index</label>
                                                        <input type="number"
                                                               class="form-control"
                                                               name="itemindex"
                                                               value="{{ old('itemindex', $section->item_index ?? '') }}">
                                                        @error('itemindex')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- Select Chapter --}}
                                                    <div class="form-group">
                                                        <label for="chapterid" class="form-label">Select Chapter</label>
                                                        <select class="form-select" name="chapterid" id="chapterid">
                                                            <option value="">Select Chapter</option>

                                                            @foreach ($chapters as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ isset($section) && $section->chapter_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('chapterid')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                {{-- Buttons --}}
                                                <div class="mt-2">
                                                    @can('List_Section')
                                                        <a href="{{ route('section.index') }}" class="btn btn-warning">
                                                            <i class="ft-x"></i> Cancel
                                                        </a>
                                                    @endcan

                                                    @if(!$section)
                                                        @can('Add_Section')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Section')
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
