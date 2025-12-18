@extends('layouts.front')


@section('content')
    <!-- Page Content -->
    <div class="page-section container2 page__container">
        <div class="page-separator">
            <div class="page-separator__text">Invoices</div>
        </div>

        <div class="card table-responsive">
            <table class="table table-flush table-nowrap">
                <thead>
                <tr>
                    <th>Invoice no.</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-center">Total Amount</th>
                    <th class="text-center">Paid Amount</th>
                    <th class="text-center">Remaining Amount</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($data as $obj)
                <tr>
                    <td>
                        <a href="#"
                           class="text-underline">{{$obj->enrollment_number}}</a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($obj->created_at)->format('d/m/Y') }}</td>
                    <td>{{$obj->getStatus->name}}</td>
                    <td class="text-center">&dollar;{{$obj->total_amount}}</td>
                    <td class="text-center">&dollar;{{$obj->received_amount}}</td>
                    <td class="text-center">&dollar;{{$obj->remaining_amount}}</td>
                    <td class="text-right">
                        <div class="d-inline-flex align-items-center">
                            <a target="_blank" href="{{route('enrolled-invoice', ['id' => $obj->id])}}"
                               class="btn btn-sm btn-outline-secondary mr-16pt">View invoice <i class="icon--right material-icons">keyboard_arrow_right</i></a>
                            <a href="{{route('download-enrollment', ['id' => $obj->id])}}"
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
