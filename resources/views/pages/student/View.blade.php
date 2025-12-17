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
                                       id="baseIcon-tab33"
                                       data-toggle="tab"
                                       href="#tabIcon33"
                                       aria-controls="tabIcon33">
                                        <i class="fa-solid fa-book-open"></i> Courses
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link"
                                       id="baseIcon-tab22"
                                       data-toggle="tab"
                                       href="#tabIcon22"
                                       aria-controls="tabIcon22">
                                        <i class="fa-solid fa-bars"></i> Custom Field
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
                                        <div class="col-xl-4 col-lg-4 col-12">
                                            <div class="card crypto-card-3 bg-gradient-directional-amber">
                                                <div class="card-body pb-1">
                                                    <h4 class="text-white mb-3">
                                                        <i class="fa-solid fa-dollar-sign"></i> Total Amount
                                                    </h4>
                                                    <h6 class="text-white mb-1">
                                                        {{ $total_amount}}$
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-12">
                                            <div class="card crypto-card-3 bg-gradient-directional-success">
                                                <div class="card-body pb-1">
                                                    <h4 class="text-white mb-3">
                                                        <i class="fa-solid fa-dollar-sign"></i> Received Amount
                                                    </h4>
                                                    <h6 class="text-white mb-1">
                                                        {{ $received_amount}}$
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-xl-4 col-lg-4 col-12">
                                            <div class="card crypto-card-3 bg-gradient-directional-red">
                                                <div class="card-body pb-1">
                                                    <h4 class="text-white mb-3">
                                                        <i class="fa-solid fa-dollar-sign"></i> Remaining Amount
                                                    </h4>
                                                    <h6 class="text-white mb-1">
                                                        {{ $remaining_amount}}$
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="col-xl-4 col-lg-4 col-12">
                                            <div class="card crypto-card-3 bg-gradient-directional-info">
                                                <div class="card-body pb-1">
                                                    <h4 class="text-white mb-3">
                                                        # Payments
                                                    </h4>
                                                    <h6 class="text-white mb-1">
                                                        {{ count($student->getPayment) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-12">
                                            <div class="card crypto-card-3 bg-gradient-directional-blue-grey">
                                                <div class="card-body pb-1">
                                                    <h4 class="text-white mb-3">
                                                       # Enrolled Courses
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

                                {{-- TAB 2: TABLE VIEW (LIKE PAYMENTS) --}}
                                <div class="tab-pane"
                                     id="tabIcon33"
                                     aria-labelledby="baseIcon-tab33">

                                    <table class="table table-striped table-bordered file-export w-100">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Enrollment Number</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($student->getInRolledCourses as $enrollment)
                                            @foreach($enrollment->getCourses as $course)
                                            <tr>
                                                <td>{{ $course->name }}</td>
                                                <td>{{ $enrollment->enrollment_number }}</td>
                                                <td>
                                                    <a href="{{route('enrolled-invoice', ['id' => $enrollment->id])}}" class="icons"><i class="fa-solid fa-file-invoice"  data-toggle="tooltip" data-placement="top" title="Invoice"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Enrollment Number</th>
                                            <th>Actions</th>
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
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($student->getPayment as $obj)
                                            <tr>
                                                <td>{{ $obj->trx_number }} </td>
                                                <td>{{ $obj->date }} </td>
                                                <td>{{ $obj->amount }}$</td>
                                                <td>
                                                    <a href="{{route('payment-invoice', ['id' => $obj->id])}}" class="icons"><i class="fa-solid fa-file-invoice" data-toggle="tooltip" data-placement="top" title="Invoice"></i></a>
                                                    <a href="{{route('download-payment', ['id' => $obj->id])}}" class="icons"><i class="fa-solid fa-file-download"  data-toggle="tooltip" data-placement="top" title="Download"></i></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Payment Number</th>
                                            <th>Date</th>
                                            <th>Amount</th>
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
