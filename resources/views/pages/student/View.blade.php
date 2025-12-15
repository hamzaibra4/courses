@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row"></div>

        <div class="content-body">
            <div id="user-profile">

                {{-- STUDENT HEADER --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card profile-with-cover margin15">
                            <div class="media profil-cover-details w-100">
                                <div class="media-body pt-3 px-2">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-title">
                                                <strong>Student Name: {{ $student->f_name }} {{ $student->l_name }}</strong>
                                            </h3>
                                            <h5 class="card-title">
                                                <strong>Phone Number: {{ $student->telephone }}</strong>
                                            </h5>
                                            <h5 class="card-title">
                                                <strong>Birthday Date:
                                                    {{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}
                                                </strong>
                                            </h5>
                                        </div>
                                        <div class="col">
                                            <h3 class="card-title">
                                                <strong>Type: {{ $student->getStudentType->name }}</strong>
                                            </h3>
                                            <h6 class="card-title">
                                                <strong>Email: {{ $student->getUser->email }}</strong>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABS --}}
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- TAB BUTTONS --}}
                            <ul class="nav nav-tabs nav-underline">
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       id="baseIcon-tab21"
                                       data-toggle="tab"
                                       href="#tabIcon21"
                                       aria-controls="tabIcon21">
                                        <i class="fas fa-address-card"></i> General Information
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link"
                                       id="baseIcon-tab22"
                                       data-toggle="tab"
                                       href="#tabIcon22"
                                       aria-controls="tabIcon22">
                                    Custom Field
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link"
                                       id="baseIcon-tab23"
                                       data-toggle="tab"
                                       href="#tabIcon23"
                                       aria-controls="tabIcon23">
                                        <i class="fa-solid fa-dollar-sign"></i> Payments
                                    </a>
                                </li>
                            </ul>

                            {{-- TAB CONTENT --}}
                            <div class="tab-content px-1 pt-1">

                                {{-- TAB 1: GENERAL INFORMATION (UNCHANGED) --}}
                                <div class="tab-pane active"
                                     id="tabIcon21"
                                     aria-labelledby="baseIcon-tab21">

                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-12">
                                            <div class="card crypto-card-3 bg-gradient-directional-red">
                                                <div class="card-body pb-1">
                                                    <h4 class="text-white mb-3">
                                                        <i class="fa-solid fa-dollar-sign"></i> Payment
                                                    </h4>
                                                    <h6 class="text-white mb-1">
                                                        {{ count($student->getPayment) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-12">
                                            <div class="card crypto-card-3 bg-gradient-directional-blue">
                                                <div class="card-body pb-1">
                                                    <h4 class="text-white mb-3">
                                                        <i class="fa-solid fa-paperclip"></i> In Rolled Courses
                                                    </h4>
                                                    <h6 class="text-white mb-1">
                                                        {{ count($student->getInRolledCourses) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB 2: TABLE VIEW (LIKE PAYMENTS) --}}
                                <div class="tab-pane"
                                     id="tabIcon22"
                                     aria-labelledby="baseIcon-tab22">

                                    <table class="table table-striped table-bordered file-export w-100">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($student->getCustoms as $obj)
                                            <tr>
                                                <td>{{ $obj->name }}</td>
                                                <td>{{ $obj->value }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Value</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                {{-- TAB 3: PAYMENTS (UNCHANGED) --}}
                                <div class="tab-pane"
                                     id="tabIcon23"
                                     aria-labelledby="baseIcon-tab23">

                                    <table class="table table-striped table-bordered file-export w-100">
                                        <thead>
                                        <tr>
                                            <th>Payment Number</th>
                                            <th>Courses</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($student->getPayment as $obj)
                                            <tr>
                                                <td>{{ $obj->trx_number }}</td>
                                                <td>
                                                    @foreach($obj->getCourses as $course)
                                                        {{ $course->name }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Payment Number</th>
                                            <th>Courses</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                            {{-- END TAB CONTENT --}}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
