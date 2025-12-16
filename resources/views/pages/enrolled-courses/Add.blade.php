@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Enrollments</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_enRolled_Course')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('enrolled-course.index') }}">Home</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active">
                                {{ $rolledCourse ? 'Edit Enrollment' : 'Add Enrollment' }}
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
                                <h4 class="card-title">Student Enrollments</h4>
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

                                    <form action="{{ $rolledCourse ? route('enrolled-course.update', $rolledCourse->id) : route('enrolled-course.store') }}"
                                          method="POST" class="floating-labels" enctype="multipart/form-data">

                                        @csrf
                                        @if($rolledCourse)
                                            @method('PUT')
                                        @endif
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group cust-form-input col-12">
                                                        <label for="student_id">Student<span class="is-required">*</span></label>
                                                        @php $current = old('student_id', optional($rolledCourse)->student_id); @endphp
                                                        <select class="form-control my-2 select2" name="student_id" id="student_id" required>
                                                            <option value="" {{ $current ? '' : 'selected' }}>Select Student</option>
                                                            @foreach($students as $id => $name)
                                                                <option value="{{ $id }}" @selected($current == $id)>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('student_id') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group cust-form-input col-12">
                                                        <label for="course_id">Course(s)<span class="is-required">*</span></label>
                                                        @php
                                                            $current = old('course_id', $rolledCourse ? $rolledCourse->getCourses->pluck('id')->toArray() : []);
                                                        @endphp
                                                        <select  multiple class="form-control my-2 select2" name="course_id[]" id="course_id" required>
                                                            @foreach($courses as $course )
                                                                <option data-price="{{$course->price}}" value="{{ $course->id }}" @selected(in_array($course->id, $current))>{{ $course->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('course_id') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="form-group cust-form-input col-12">
                                                        <label for="amount">Total Amount <span>*</span></label>
                                                        <input id="amount" required type="number" class="form-control"
                                                               name="amount" placeholder="Enter Amount"
                                                               value="{{ old('amount', $rolledCourse->total_amount ?? '') }}" readonly>

                                                        @error('amount')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    @if(!$rolledCourse)
                                                    <div class="form-group cust-form-input col-12">
                                                        <label for="r_amount">Received Amount </label>
                                                        <input id="r_amount"  type="number" class="form-control"
                                                               name="r_amount" placeholder="Enter Received Amount"
                                                               value="{{ old('amount', $rolledCourse->received_amount ?? 0) }}" >

                                                        @error('r_amount')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                    <div class="form-group ml-2 cust-form-input col-12">
                                                        <input type="hidden" name="paid" value="0">
                                                        <input type="checkbox" name="paid" value="1" class="form-check-input" id="paid" />
                                                        <label for="paid" class="form-check-label">Fully Paid</label>
                                                        @error('paid')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                        @endif


                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-actions">

                                                    @can('List_enRolled_Course')
                                                        <a href="{{ route('enrolled-course.index') }}" class="btn btn-warning mr-1 button-cancel">
                                                            <i class="ft-x"></i>&nbsp;Cancel
                                                        </a>
                                                    @endcan
                                                        @canany(['Add_enRolled_Course', 'Edit_enRolled_Course'])
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


@section('customjs')
<script src="{{asset('cms/custom/enrollment.js')}}"></script>
@endsection
