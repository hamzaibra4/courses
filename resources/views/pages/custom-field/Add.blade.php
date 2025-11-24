@extends('layouts.app')
@section('content')
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Custom Field</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Custom_Field')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('custom-field.index') }}">Home</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active">
                                {{ $obj ? 'Edit Custom Field' : 'Add Custom Field' }}
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
                                <h4 class="card-title">Custom Field</h4>
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

                                    <form action="{{ $obj ? route('custom-field.update', $obj->id) : route('custom-field.store') }}"
                                          method="POST" class="floating-labels" enctype="multipart/form-data">

                                        @csrf
                                        @if($obj)
                                            @method('PUT')
                                        @endif
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Name<span>*</span></label>
                                                        <input id="name" required type="text" class="form-control"
                                                               name="name" placeholder="Enter Name"
                                                               value="{{ old('name', $obj->name ?? '') }}">

                                                        @error('name')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="value">Value<span>*</span></label>
                                                        <input id="value" required type="text" class="form-control"
                                                               name="value" placeholder="Enter your value"
                                                               value="{{ old('value', $obj->value ?? '') }}">

                                                        @error('value')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group cust-form-input col-12">
                                                    <label for="student_id">Student<span class="is-required">*</span></label>
                                                    @php $current = old('student_id', optional($obj)->student_id); @endphp
                                                    <select class="form-control my-2 select2" name="student_id" id="student_id" required>
                                                        <option value="" {{ $current ? '' : 'selected' }}>Select Student</option>
                                                        @foreach($students as $id => $name)
                                                            <option value="{{ $id }}" @selected($current == $id)>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('student_id') <div class="error-msg">{{ $message }}</div> @enderror
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-actions">

                                                    @can('List_Custom_Field')
                                                        <a href="{{ route('custom-field.index') }}" class="btn btn-warning mr-1 button-cancel">
                                                            <i class="ft-x"></i>&nbsp;Cancel
                                                        </a>
                                                    @endcan

                                                    @if(is_null($obj))
                                                        @can('List_Custom_Field')
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i>&nbsp;Save
                                                            </button>
                                                        @endcan
                                                    @else
                                                        @can('Edit_Custom_Field')
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
