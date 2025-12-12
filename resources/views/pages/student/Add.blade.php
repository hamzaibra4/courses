@extends('layouts.app')
@section('content')
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Students</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Students')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('student.index') }}">Home</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active">
                                {{ $students ? 'Edit Students' : 'Add Students' }}
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
                                <h4 class="card-title">Students</h4>
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

                                    <form action="{{ $students ? route('student.update', $students->id) : route('student.store') }}"
                                          method="POST" class="floating-labels" enctype="multipart/form-data">

                                        @csrf
                                        @if($students)
                                            @method('PUT')
                                        @endif
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="f_name">First Name<span>*</span></label>
                                                        <input id="f_name" required type="text" class="form-control"
                                                               name="f_name" placeholder="Enter your First Name"
                                                               value="{{ old('f_name', $students->f_name ?? '') }}">

                                                        @error('f_name')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="l_name">Last Name<span>*</span></label>
                                                        <input id="l_name" required type="text" class="form-control"
                                                               name="l_name" placeholder="Enter your Last Name"
                                                               value="{{ old('l_name', $students->l_name ?? '') }}">

                                                        @error('l_name')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="telephone">Phone Number<span>*</span></label>
                                                        <input id="telephone" required type="number" class="form-control"
                                                               name="telephone" placeholder="Enter your Phone Number"
                                                               value="{{ old('telephone', $students->telephone ?? '') }}">

                                                        @error('telephone')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dob">Date of Birthday<span>*</span></label>
                                                        <input id="dob" type="text" class="form-control dobpickdate_year" name="dob" required  value="{{ old('dob', $students->dob ?? '') }}">
                                                        @error('dob')
                                                        <div class='error-msg'>{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group cust-form-input col-12">
                                                    <label for="student_type_id">Student Type<span class="is-required">*</span></label>
                                                    @php $current = old('student_type_id', optional($students)->student_type_id); @endphp
                                                    <select class="form-control my-2 select2" name="student_type_id" id="student_type_id" required>
                                                        <option value="" {{ $current ? '' : 'selected' }}>Select Student Type</option>
                                                        @foreach($types as $id => $name)
                                                            <option value="{{ $id }}" @selected($current == $id)>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('student_type_id') <div class="error-msg">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-check mt-1">
                                                            <input type="hidden" name="is_active" value="0">

                                                            <input id="is_active"
                                                                   type="checkbox"
                                                                   name="is_active"
                                                                   class="form-check-input"
                                                                   value="1"
                                                                {{ old('is_active', $students->is_active ?? 0) == 1 ? 'checked' : '' }}>

                                                            <label class="form-check-label" for="is_active"> isActive ?</label>
                                                        </div>

                                                        @error('is_active')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-actions">

                                                    @can('List_Students')
                                                        <a href="{{ route('student.index') }}" class="btn btn-warning mr-1 button-cancel">
                                                            <i class="ft-x"></i>&nbsp;Cancel
                                                        </a>
                                                    @endcan
                                                        @canany(['Add_Students', 'Edit_Students'])
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcanany

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
