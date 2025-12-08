@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div id="user-profile">
                <div class="row">
                    <div class="col-12">
                        <div class="card profile-with-cover margin15 ">
                            <div class="media profil-cover-details w-100 ">
                                <div class="media-left pl-2 pt-2">
                                </div>
                                <div class="media-body pt-3 px-2">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-title"><strong> Student Name: {{$student->f_name}} {{$student->l_name}} </strong></h3>
                                            <h5 class="card-title"><strong>Phone Number: {{$student->telephone}} </strong></h5>
                                            <h5 class="card-title"><strong>Birthday Date: {{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}
                                                </strong></h5>
                                        </div>
                                        <div class="col">
                                            <h3 class="card-title"><strong> Type : {{$student->getStudentType->name}} </strong></h3>
                                            <h6 class="card-title"><strong> Email: {{$student->getUser->email}} </strong> </h6>
                                            <h6 class="card-title"><strong> Information: {{$student->getCustoms->first()?->value}} </strong> </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs nav-underline">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="baseIcon-tab21" data-toggle="tab" aria-controls="tabIcon21"
                                                           href="#tabIcon21" aria-expanded="true"><i class="fas fa-address-card"></i>General Information</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="baseIcon-tab23" data-toggle="tab" aria-controls="tabIcon23"
                                                           href="#tabIcon23" aria-expanded="false"><i class="fa-solid fa-dollar-sign"></i>Payments</a>
                                                    </li>
{{--                                                    <li class="nav-item">--}}
{{--                                                        <a class="nav-link" id="baseIcon-tab24" data-toggle="tab" aria-controls="tabIcon24"--}}
{{--                                                           href="#tabIcon24" aria-expanded="false"><i class="fa-solid fa-list-check"></i>Reservations</a>--}}
{{--                                                    </li>--}}
                                                </ul>

                                                <div class="tab-content px-1 pt-1">
                                                    <div role="tabpanel" class="tab-pane active" id="tabIcon21" aria-expanded="true"
                                                         aria-labelledby="baseIcon-tab21">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">
                                                                    <div class="card-content">
                                                                        <div class="row">
{{--                                                                            @foreach($user->getServiceUser as $obj)--}}
{{--                                                                                <div class="col-xl-3 col-lg-3 col-12">--}}
{{--                                                                                    <div class="card crypto-card-3 bg-gradient-directional-blue">--}}
{{--                                                                                        <div class="card-content">--}}
{{--                                                                                            <div class="card-body pb-1">--}}
{{--                                                                                                <h4 class="text-white mb-3"><i class="fa-solid fa-receipt"></i>&nbsp;&nbsp;Service</h4>--}}
{{--                                                                                                <h6 class="text-white mb-1">--}}
{{--                                                                                                    {{$obj->getService->name}} - {{$obj->name}}--}}
{{--                                                                                                </h6>--}}
{{--                                                                                            </div>--}}
{{--                                                                                        </div>--}}
{{--                                                                                    </div>--}}
{{--                                                                                </div>--}}
{{--                                                                            @endforeach--}}
                                                                                <div class="col-xl-3 col-lg-3 col-12">
                                                                                    <div class="card crypto-card-3 bg-gradient-directional-red">
                                                                                        <div class="card-content">
                                                                                            <div class="card-body pb-1">
                                                                                                    <h4 class="text-white mb-3"><i class="fa-solid fa-dollar-sign"></i>&nbsp;&nbsp;Payment</h4>
                                                                                                <h6 class="text-white mb-1">
                                                                                                    {{count($student->getPayment)}}
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <div class="col-xl-3 col-lg-3 col-12">
                                                                                <div class="card crypto-card-3 bg-gradient-directional-blue">
                                                                                    <div class="card-content">
                                                                                        <div class="card-body pb-1">
                                                                                            <h4 class="text-white mb-3"><i class="fa-solid fa-paperclip"></i>&nbsp;&nbsp;In Rolled Courses</h4>
                                                                                            <h6 class="text-white mb-1">
                                                                                                {{count($student->getInRolledCourses)}}
                                                                                            </h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tabIcon23" aria-labelledby="baseIcon-tab23">
                                                        <table class="table table-striped table-bordered file-export w-100">
                                                            <thead>
                                                            <tr>
                                                                <th>Payment Number</th>
                                                                <th>Date</th>
                                                                <th>Courses</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($student->getPayment as $obj)
                                                                    <tr>
                                                                        <td>{{$obj->trx_number}}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($obj->date)->format('d/m/Y') }}</td>
                                                                        <td>
                                                                            @foreach($obj->getCourses as $course)
                                                                                {{$course->name}}@if(!$loop->last), @endif
                                                                            @endforeach
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Payment Number</th>
                                                                <th>Date</th>
                                                                <th>Courses</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection

