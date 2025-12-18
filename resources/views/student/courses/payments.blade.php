@extends('layouts.front')


@section('content')
    <!-- Page Content -->
    <div class="page-section container2 page__container">
        <div class="page-separator">
            <div class="page-separator__text">Outstanding Payments</div>
        </div>

        <div class="card table-responsive">
            <table class="table table-flush table-nowrap">
                <thead>
                <tr>
                    <th>Payment no.</th>
                    <th>Date</th>
                    <th>Related Invoice</th>
                    <th class="text-center">Amount</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($data as $obj)
                <tr>
                    <td>
                        <a href="#"
                           class="text-underline">{{$obj->trx_number}}</a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($obj->date)->format('d/m/Y') }}</td>
                    <td>
                        <a class="text-underline" target="_blank" href="{{route('enrolled-invoice', ['id' => $obj->getEnrollment->id])}}">
                            {{$obj->getEnrollment->enrollment_number}} </a>
                    </td>
                    <td class="text-center">&dollar;{{$obj->amount}}</td>
                    <td class="text-right">
                        <div class="d-inline-flex align-items-center">
                            <a target="_blank" href="{{route('payment-invoice', ['id' => $obj->id])}}"
                               class="btn btn-sm btn-outline-secondary mr-16pt">View invoice <i class="icon--right material-icons">keyboard_arrow_right</i></a>
                            <a href="{{route('download-payment', ['id' => $obj->id])}}"
                               class="btn btn-sm btn-outline-secondary">Download <i class="icon--right material-icons">file_download</i></a>
                        </div>
                    </td>
                </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>

    <!-- // END Page Content -->
@endsection
