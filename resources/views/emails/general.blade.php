<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $mailData['document_type'] ?? 'Document' }} - {{ $mailData['document_number'] ?? '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #089bab;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .content h2 {
            margin-top: 0;
            color: #089bab;
        }

        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #999;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .details-table td {
            padding: 8px;
        }

        .details-table .label {
            font-weight: bold;
            width: 35%;
        }

        @media only screen and (max-width: 600px) {
            .content, .header {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $mailData['document_type'] ?? 'Document' }}</h1>
    </div>

    <div class="content">
        <h2>Dear {{ $mailData['client_name'] ?? 'Valued Client' }},</h2>

        <p>Please find your {{ strtolower($mailData['document_type'] ?? 'document') }} <strong>#{{ $mailData['document_number'] ?? '' }}</strong> attached.</p>

        <table class="details-table">
            <tr>
                <td class="label">Date:</td>
                <td>{{ $mailData['date'] ?? now()->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <td class="label">Amount:</td>
                <td>{{ $mailData['amount'] ?? 'N/A' }} {{ $mailData['currency'] ?? '' }}</td>
            </tr>
            @if(!empty($mailData['notes']))
                <tr>
                    <td class="label">Notes:</td>
                    <td>{{ $mailData['notes'] }}</td>
                </tr>
            @endif
        </table>

        <p>If you have any questions, feel free to reply to this email.</p>

        <p>Thank you for your business!</p>
    </div>

    <div class="footer">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
</body>
</html>
