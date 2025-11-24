@extends('layouts.app')
@section('content')
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Students Types</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Students_Type')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('student-type.index') }}">Home</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active">
                                {{ $types ? 'Edit Students Types' : 'Add Students Types' }}
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
                                <h4 class="card-title">Students Types</h4>
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

                                    <form action="{{ $types ? route('student-type.update', $types->id) : route('student-type.store') }}"
                                          method="POST" class="floating-labels" enctype="multipart/form-data">

                                        @csrf
                                        @if($types)
                                            @method('PUT')
                                        @endif
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Name<span>*</span></label>
                                                        <input id="name" required type="text" class="form-control"
                                                               name="name" placeholder="Enter Name"
                                                               value="{{ old('name', $types->name ?? '') }}">

                                                        @error('name')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="email_extension">Email Extension<span>*</span></label>
                                                        <input id="email_extension" required type="text" class="form-control"
                                                               name="email_extension" placeholder="Enter your Email Extension"
                                                               value="{{ old('email_extension', $types->email_extension ?? '') }}">

                                                        @error('email_extension')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-actions">

                                                    @can('List_Students_Type')
                                                        <a href="{{ route('student-type.index') }}" class="btn btn-warning mr-1 button-cancel">
                                                            <i class="ft-x"></i>&nbsp;Cancel
                                                        </a>
                                                    @endcan

                                                    @if(is_null($types))
                                                        @can('Add_Students_Type')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i>&nbsp;Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Students_Type')
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
