<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            color: #333;
            margin: 40px;
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
          <div class="media">
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
        <div class="invoice-heading">
            <h2>Invoice</h2>
            <p>#{{$data->enrollment_number}}</p>
        </div>
    </div>

    <div class="details-row">
        <div class="bill-to">
            <strong>Invoice To</strong><br>
            <p>{{$data->getStudent?->f_name}} {{$data->getStudent?->l_name}}</p>
            <p><a href="tel:{{ $data->getStudent?->telephone }}">{{ $data->getStudent?->telephone }}</a></p>
            @if(!empty($data->getStudent?->getUser?->email))
                <p><a href="mailto:{{ $data->getStudent?->getUser?->email }}">{{ $data->getStudent?->getUser?->email }}</a></p>
            @endif
        </div>

        <div class="invoice-meta">
            <p><strong>Total Amount:</strong> ${{ number_format($data->total_amount, 2, '.', ' ') }}</p>
            <p><strong>Invoice Date:</strong>  {{ $data->created_at->format('d/m/Y') }}</p>
        </div>


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
        @foreach($data->getCourses as $course)
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
        <table>
            <tr>
                <td class="label">Sub Total</td>
                <td class="value">$ {{ number_format($data->total_amount, 2, '.', ' ') }}</td>
            </tr>

            @if($data->total_amount > 0)
                <tr>
                    <td class="label">Received</td>
                    <td class="value">$ {{ number_format($data->received_amount, 2, '.', ' ') }}</td>
                </tr>
            @endif

            <tr>
                <td class="label">Balance Due</td>
                <td class="value">$ {{ number_format($data->remaining_amount, 2, '.', ' ') }}</td>
            </tr>

        </table>
    </div>

    <div>
        <p><strong>Payment Method</strong> <br>
            dsad
        </p>
    </div>
</div>


</body>
</html>
