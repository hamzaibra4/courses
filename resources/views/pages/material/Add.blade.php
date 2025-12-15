@extends('layouts.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">

        <!-- Header -->
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Materials</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Material')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('material.index') }}">Home</a>
                                </li>
                            @endcan

                            <li class="breadcrumb-item active">
                                {{ $material ? 'Edit materials' : 'Add materials' }}
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
                                <h4 class="card-title">Materials</h4>
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

                                    <div class="card-body">

                                        <form action="{{ $material ? route('material.update', $material->id) : route('material.store') }}"
                                              method="POST" enctype="multipart/form-data">

                                            @csrf
                                            @if($material)
                                                @method('PUT')
                                            @endif
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="item_index">Index</label>
                                                    <input id="item_index"
                                                           type="number"
                                                           class="form-control"
                                                           name="item_index"
                                                           placeholder="Enter Item Index"
                                                           value="{{ old('item_index', $material->item_index ?? '') }}">

                                                    @error('item_index')
                                                    <div class="error-msg">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="course_id">Chapter <span class="is-required">*</span></label>

                                                            @php $current = old('chapter_id', optional($material)->chapter_id); @endphp

                                                            <select class="form-control my-2 select2"
                                                                    name="chapter_id" id="chapter_id" required>

                                                                <option value="" {{ $current ? '' : 'selected' }}>
                                                                    Select Chapter
                                                                </option>

                                                                @foreach($chapters as $id => $name)
                                                                    <option value="{{ $id }}" @selected($current == $id)>
                                                                        {{ $name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>

                                                            @error('chapter_id')
                                                            <div class="error-msg">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- PDF Upload -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="projectinput1">PDF Document(s)
                                                            </label>
                                                            <input type="file"
                                                                   id="projectinput1"
                                                                   class="form-control"
                                                                   name="path[]"
                                                                   accept="application/pdf,.pdf"
                                                                   multiple>
                                                            @error('path')
                                                            <div class="error-msg">{{ $message }}</div>
                                                            @enderror
                                                            @error('path.*')
                                                            <div class="error-msg">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- PDF Preview Buttons -->
                                                @if($material && $material->getMaterialPdfs->count() > 0)
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Uploaded PDFs:</label>
                                                                <div class="d-flex flex-wrap" id="pdf-list">
                                                                    @foreach($material->getMaterialPdfs as $pdf)
                                                                        <div class="mr-2 mb-2 pdf-item d-inline-flex align-items-center" data-pdf-id="{{ $pdf->id }}">
                                                                            <a href="{{ asset($pdf->path) }}" target="_blank"
                                                                               class="btn btn-primary btn-sm mr-1">
                                                                                <i class="fa fa-file-pdf"></i> PDF {{ $loop->iteration }}
                                                                            </a>
                                                                            <button type="button"
                                                                                    class="btn btn-danger btn-sm delete-pdf-btn"
                                                                                    data-pdf-id="{{ $pdf->id }}"
                                                                                    data-delete-url="{{ route('material-pdf.delete', $pdf->id) }}"
                                                                                    title="Delete PDF">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div> <!-- /form-body -->


                                            <!-- Action Buttons -->
                                            <div class="mt-2">

                                                @can('List_Material')
                                                    <a href="{{ route('material.index') }}" class="btn btn-warning">
                                                        <i class="ft-x"></i> Cancel
                                                    </a>
                                                @endcan
                                                    @canany(['Add_Material', 'Edit_Material'])
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="la la-check-square-o"></i> Save
                                                        </button>
                                                    @endcanany

                                            </div>


                                        </form>

                                    </div> <!-- /card-body -->

                                </div>
                            </div>

                        </div> <!-- /card -->

                    </div>
                </div>
            </section>
        </div>

    </div>
@endsection

@section('customjs')
<script src="{{asset('cms/custom/material.js')}}" type="text/javascript"></script>
@endsection
