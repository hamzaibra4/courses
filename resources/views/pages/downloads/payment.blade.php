<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            color: #333;

            line-height: 1.6;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        .top-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        .clinic-info {
            color: #555;
        }
        .clinic-info a {
            color: #2a9fd6;
            text-decoration: none;
        }
        .invoice-heading {
            text-align: right;
        }
        .invoice-heading h2 {
            margin: 0;
        }

        .details-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        .invoice-meta, .bill-to {
            flex: 1;
            min-width: 250px;

        }

        .invoice-meta{
            text-align: end;

        }
        .bill-to p, .invoice-meta p {
            margin: 2px 0;
        }
        .bill-to a {
            color: #2a9fd6;
            text-decoration: none;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .table th, .table td {
            border-bottom: 1px solid #eee;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        .amounts {
            margin-top: 30px;
            width: 40%;
            float: right;
        }
        .amounts table {
            width: 100%;
        }
        .amounts td {
            padding: 8px 10px;
        }
        .amounts .label {
            color: #555;
        }
        .amounts .value {
            text-align: right;
        }
        .amounts .received {
            color: green;
        }

        .signature {
            clear: both;
            text-align: right;
            margin-top: 60px;
        }
        .signature img {
            height: 60px;
        }
        .footer-note {
            font-style: italic;
            text-align: right;
            color: #555;
        }
        .avatar-80 {
            height: 80px;
            width: 80px;
            line-height: 80px;
            font-size: 1.6rem;
        }
        .align-self-center {
            -webkit-align-self: center !important;
            -ms-flex-item-align: center !important;
            align-self: center !important;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .media {
            display: flex;
            align-items: flex-start;
        }


        .amount-table {
            width: 100%;

            border-collapse: collapse;
            margin-top: 25px;
            font-size: 14px;
            background-color: #fafafa;
        }

        .amount-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e6e6e6;
        }

        .amount-table .label {
            color: #666;
        }

        .amount-table .value {
            text-align: right;
            font-weight: 500;
            color: #333;
        }

        .amount-table .received {
            color: #2e7d32;
        }

        .amount-table .total-row td {
            border-top: 2px solid #333;
            background-color: #f2f2f2;
            font-size: 15px;
        }

        .amount-table .total {
            font-weight: bold;
            color: #000;
        }

        .amount-table .signature-row td {
            border: none;
            text-align: center;
            padding-top: 28px;
        }

        .signature-row {
            margin-top: 50px;
            text-align: center;
        }

        .signature-cell {
            display: inline-block;
        }

        .signature-label {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #777;
            font-style: italic;
        }

        .details-row {
            margin-top: 30px;
        }

        .bill-to {
            float: left;
            width: 55%;
        }

        .invoice-heading {
            float: right;
            width: 40%;
            text-align: right;
        }

        .bill-to p,
        .invoice-heading p {
            margin: 3px 0;
        }




    </style>

    @if($download == 0)
        <style>
            .container {
                border: 2px solid #ccc; /* Light gray border */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Subtle shadow */
                margin: auto;
                padding: 20px;
                background-color: #fff; /* Optional for better contrast */
            }

            @media print {
                .container {
                    border: none !important;
                    box-shadow: none !important;
                }
            }

        </style>
    @endif
</head>
<body>

<div class="container">
    <div class="top-section">
        <div class="clinic-info">
            <div style="float: right">
                <h2>Receipt <br> <span style="font-size: 18px"> #{{$data->trx_number}} </span> </h2>

            </div>
            <div class="media">

              <img src="{{ public_path($company->logo) }}" width="120">
              <p>
                  {{$company->name}}<br>
                  @if($company->address)
                      @isset($company->address) {{$company->address}},@endisset
                      <br>
                  @endif
                  @isset($company->telephone) Telephone: <a href="tel:{{$company->telephone}}">{{$company->telephone}}</a> <br> @endisset
                  @isset($company->email) Email: <a href="mailto:{{$company->email}}">{{$company->email}}</a> <br> @endisset
              </p>
          </div>

        </div>
    </div>

    <div class="details-row">
        <div class="bill-to">
            <strong>Receipt To</strong><br>
            <p>{{ $data->getStudent?->f_name }} {{ $data->getStudent?->l_name }}</p>
            <p>{{ $data->getStudent?->telephone }}</p>

            @if(!empty($data->getStudent?->getUser?->email))
                <p>{{ $data->getStudent?->getUser?->email }}</p>
            @endif
        </div>

        <div class="invoice-heading">
            <p>
                <strong>Total Amount:</strong>
                ${{ number_format($data->amount, 2, '.', ' ') }}<br>

                <strong>Invoice Date:</strong>
                {{ $data->created_at->format('d/m/Y') }}
            </p>
        </div>

        <div style="clear: both;"></div>
    </div>

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
        @foreach($data->getEnrollment->getCourses as $course)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <p>{{$course->name}}</p>
                </td>
                <td class="text-right">{{ number_format($course->price, 2, '.', ' ') }}</td>
                <td class="text-right">$ {{ number_format($course->price, 2, '.', ' ') }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="amounts">
        <table class="amount-table">

        <tr>
                <td class="label">Total Amount Paid</td>
                <td class="value">$ {{ number_format($data->amount, 2, '.', ' ') }}</td>
            </tr>

        </table>


        <div class="signature-row">
            <div class="signature-cell">
                <img src="{{ public_path($company->signature_image) }}" width="120"><br>
                <span class="signature-label">Authorized Signature</span>
            </div>
        </div>




    </div>

{{--    <div>--}}
{{--        <p><strong>Payment Method</strong> <br>--}}

{{--        </p>--}}
{{--    </div>--}}
</div>


</body>
</html>
