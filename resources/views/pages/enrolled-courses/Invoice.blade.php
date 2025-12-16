@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row hide-on-print">
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
                                        <li class="text-bold-800">{{$company->name}},</li>
                                        <li>{{$company->telephone}},</li>
                                        <li>{{$company->address}}.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 text-center text-md-right">
                            <h2>Enrollment Number</h2>
                            <p class="pb-3">{{$obj->enrollment_number}}</p>
                            <ul class="px-0 list-unstyled">
                                <li><h4>Amount</h4></li>
                                <li class="lead text-bold-800">{{$obj->total_amount}}$</li>
                                <li class="lead text-bold-800">{{$obj->getStatus->name}}</li>
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
                                <span class="text-muted">Date: </span>
                            {{ $obj->created_at->format('d/m/Y') }}
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

                                        <th>Received Amount</th>
                                        <th class="text">Remaining Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        @if($obj->received_amount)
                                            <td>
                                                <p class="text-muted">{{$obj->received_amount}}</p>
                                            </td>
                                        @else
                                            <td>
                                                <p class="text-muted">NA</p>
                                            </td>
                                        @endif
                                            @if($obj->remaining_amount)
                                                <td>
                                                    <p class="text-muted">{{$obj->remaining_amount}}</p>
                                                </td>
                                            @else
                                                <td>
                                                    <p class="text-muted">NA</p>
                                                </td>
                                            @endif
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-center text-md-left">
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead">Total</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        {{--                                            <tr>--}}
                                        {{--                                                <td>{{ __('messages.subtotal') }}</td>--}}
                                        {{--                                                <td class="text-right">{{$invoice->subtotal}}$</td>--}}
                                        {{--                                            </tr>--}}
                                        <tr>
                                            <td class="text-bold-800">Total</td>
                                            <td class="text-bold-800 text-right"> {{$obj->total_amount}}$</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Footer -->
                    <div id="invoice-footer">
                    </div>
                    <!--/ Invoice Footer -->
                </div>

            </section>

        </div>
    </div>

@endsection
