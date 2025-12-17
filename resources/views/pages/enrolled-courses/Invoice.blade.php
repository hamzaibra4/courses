@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row hide-on-print no-print">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Invoice</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Invoice</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="card">
                <div id="invoice-template" class="card-body">
                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row">
                        <div class="col-md-6 col-sm-12 text-center text-md-left">
                            <div class="media">
                                <img src="{{asset($company->logo)}}"  alt="company logo" class="img-width"
                                />
                                <div class="media-body mt-2">
                                    <ul class="ml-2 px-0 list-unstyled">
                                        <li class="text-bold-800">{{$company->name}}</li>
                                        @isset($company->address)
                                            <li>
                                               {{$company->address}}
                                            </li>
                                        @endisset

                                        @isset($company->telephone)
                                            <li>
                                                <a href="tel:{{$company->telephone}}">{{$company->telephone}}</a>
                                            </li>
                                        @endisset

                                        @isset($company->email)
                                            <li>
                                                <a href="mailto:{{$company->email}}">{{$company->email}}</a>
                                            </li>
                                        @endisset

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 text-center text-md-right">
                            <h2>Invoice</h2>
                            <p class="pb-3">#{{$obj->enrollment_number}}</p>
                            <ul class="px-0 list-unstyled">
                                <li>Balance Due</li>
                                <li class="lead text-bold-800">$ {{ number_format($obj->remaining_amount, 2, '.', ' ') }}</li>
                            </ul>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->
                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-sm-12 text-center text-md-left">
                            <p class="text-muted">Bill To</p>
                        </div>
                        <div class="col-md-6 col-sm-12 text-center text-md-left">
                            <ul class="px-0 list-unstyled">
                                <li class="text-bold-800">{{$obj->getStudent->f_name}}{{$obj->getStudent->l_name}}</li>
                                <li>{{$obj->getStudent->telephone}}</li>
                                {{$obj->getStudent->email}}
                                {{$obj->getStudent->getUser->email}}
                            </ul>
                        </div>
                        <div class="col-md-6 col-sm-12 text-center text-md-right">
                            <p>
                                <span class="text-muted">Invoice Date :</span> {{ $obj->created_at->format('d/m/Y') }}</p>
                            <p>
                                <span class="text-muted">Status :</span> {{$obj->getStatus->name}}</p>
                        </div>

                    </div>
                    <!--/ Invoice Customer Details -->
                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item & Description</th>
                                        <th>Unit Price</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($obj->getCourses as $course)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <p>{{$course->name}}</p>
                                            </td>
                                            <td >{{ number_format($course->price, 2, '.', ' ') }}</td>
                                            <td >$ {{ number_format($course->price, 2, '.', ' ') }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-center text-md-left">
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead">Total due
                                </p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Sub Total</td>
                                            <td class="text-right">$ {{ number_format($obj->total_amount, 2, '.', ' ') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Received</td>
                                            <td class="text-right">$ {{ number_format($obj->received_amount, 2, '.', ' ') }}</td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800">Balance Due</td>
                                            <td class="text-bold-800 text-right">$ {{ number_format($obj->remaining_amount, 2, '.', ' ') }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @isset($company->signature_image)
                                <div class="text-center">
                                    <p>Authorized person</p>
                                    <img src="{{asset($company->signature_image)}}" alt="signature" class="height-100"
                                    />
                                </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Footer -->
                    <div id="invoice-footer">
                        <div class="row">
                            <div class="col-md-7 col-sm-12">
{{--                                <h6>Terms & Condition</h6>--}}
{{--                                <p>You know, being a test pilot isn't always the healthiest business--}}
{{--                                    in the world. We predict too much for the next year and yet far--}}
{{--                                    too little for the next 10.</p>--}}
                            </div>
                            <div class="col-md-5 col-sm-12 text-center no-print">
                              <a class="btn btn-info btn-lg my-1" href="{{route('download-enrollment',['id'=>$obj->id])}}"><i class="la la-download"></i> Download Invoice</a>
                            </div>
                        </div>
                    </div>
                    <!--/ Invoice Footer -->
                </div>

            </section>

        </div>
    </div>

@endsection
