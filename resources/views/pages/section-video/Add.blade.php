@extends('layouts.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Section videos</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Section_Video')   <li class="breadcrumb-item"><a href="{{route("section-video.index")}}">Home</a></li>@endcan
                            <li class="breadcrumb-item active">{{ $sectionvideo ? 'Edit section videos' : 'Add section videos' }}</li>

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
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <form action="{{ $sectionvideo ? route('section-video.update', $sectionvideo->id) : route('section-video.store') }}"
                                                  method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf
                                                @if($sectionvideo)
                                                    @method('PUT')
                                                @endif


                                                <div class="form-body">

                                                    {{-- Title --}}
                                                    <div class="form-group">
                                                        <label for="path">Video link</label>
                                                        <input id="path" type="text"  class="form-control"
                                                               name="path"
                                                               value="{{ $sectionvideo->path ?? old('path') }}"
                                                               placeholder="Enter video link">
                                                        @error('path') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>


                                                    {{-- Item Index --}}
                                                    <div class="form-group">
                                                        <label for="itemindex">Index</label>
                                                        <input type="number"
                                                               class="form-control"
                                                               name="itemindex"
                                                               value="{{ old('itemindex', $sectionvideo->item_index ?? '') }}">
                                                        @error('itemindex')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- Select Chapter --}}
                                                    <div class="form-group">
                                                        <label for="sectionid" class="form-label">Select Section</label>
                                                        <select class="form-select" name="sectionid" id="sectionid">
                                                            <option value="">Select Section</option>

                                                            @foreach ($section as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ isset($sectionvideo) && $sectionvideo->section_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('$sectionvideo')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                {{-- Buttons --}}
                                                <div class="mt-2">
                                                    @can('List_Section_Video')
                                                        <a href="{{ route('section-video.index') }}" class="btn btn-warning">
                                                            <i class="ft-x"></i> Cancel
                                                        </a>
                                                    @endcan

                                                    @if(!$section)
                                                        @can('Add_Section_Video')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Section_Video')
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
