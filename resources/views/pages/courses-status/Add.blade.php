@extends('layouts.app')
@section('content')
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Courses Status</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Courses_Status')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('courses-status.index') }}">Home</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active">
                                {{ $status ? 'Edit Courses Status' : 'Add Courses Status' }}
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
                                <h4 class="card-title">Courses Status</h4>
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
                                <div class="card-body">

                                    <form action="{{ $status ? route('courses-status.update', $status->id) : route('courses-status.store') }}"
                                          method="POST" class="floating-labels" enctype="multipart/form-data">

                                        @csrf
                                        @if($status)
                                            @method('PUT')
                                        @endif
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Name<span>*</span></label>
                                                        <input id="name" required type="text" class="form-control"
                                                               name="name" placeholder="Enter Name"
                                                               value="{{ old('name', $status->name ?? '') }}">

                                                        @error('name')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-actions">

                                                    @can('List_Custom_Field')
                                                        <a href="{{ route('courses-status.index') }}" class="btn btn-warning mr-1 button-cancel">
                                                            <i class="ft-x"></i>&nbsp;Cancel
                                                        </a>
                                                    @endcan

                                                    @if(is_null($status))
                                                        @can('List_Courses_Status')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i>&nbsp;Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Courses_Status')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i>&nbsp;Save
                                                            </button>
                                                        @endcan
                                                    @endif

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
