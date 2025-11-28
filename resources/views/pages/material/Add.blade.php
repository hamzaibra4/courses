@extends('layouts.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Materials</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Material')   <li class="breadcrumb-item"><a href="{{route("material.index")}}">Home</a></li>@endcan
                            <li class="breadcrumb-item active">{{ $material ? 'Edit materials' : 'Add materials' }}</li>

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
                                <h4 class="card-title">Materials</h4>
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
                                            <form action="{{ $material ? route('material.update', $material->id) : route('material.store') }}"
                                                  method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf
                                                @if($material)
                                                    @method('PUT')
                                                @endif


                                                <div class="form-body">

                                                    {{-- Title --}}
                                                    <div class="form-group">
                                                        <label for="path">Link</label>
                                                        <input id="path" type="text"  class="form-control"
                                                               name="path"
                                                               value="{{ $material->path ?? old('path') }}"
                                                               placeholder="Enter video link">
                                                        @error('path') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>


                                                    {{-- Item Index --}}
                                                    <div class="form-group">
                                                        <label for="itemindex">Index</label>
                                                        <input type="number"
                                                               class="form-control"
                                                               name="itemindex"
                                                               value="{{ old('itemindex', $material->item_index ?? '') }}">
                                                        @error('itemindex')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- Select Chapter --}}
                                                    <div class="form-group">
                                                        <label for="courseid" class="form-label">Select course</label>
                                                        <select class="form-select" name="courseid" id="courseid">
                                                            <option value="">Select course</option>

                                                            @foreach ($course as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ isset($material) && $material->course_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('$material')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                {{-- Buttons --}}
                                                <div class="mt-2">
                                                    @can('List_Material')
                                                        <a href="{{ route('material.index') }}" class="btn btn-warning">
                                                            <i class="ft-x"></i> Cancel
                                                        </a>
                                                    @endcan

                                                    @if(!$material)
                                                        @can('Add_Material')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Material')
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
