<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Appointment Reminder</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f7;
            color: #51545E;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            width: 100%;
            padding: 20px;
        }

        .email-content {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }

        .email-header h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .email-body {
            font-size: 16px;
            line-height: 1.6;
        }

        .email-footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #888;
        }

        .btn {
            display: inline-block;
            background-color: #3869D4;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="email-header">
                <h1>Appointment Reminder</h1>
            </div>
            <div class="email-body">
                <p>{{ $messageText  }}</p>
                <p>Best regards,<br>Your Healthcare Team</p>
            </div>
            <div class="email-footer">
                <p>If you have any questions, just reply to this email—we're happy to help.</p>
            </div>
        </div>
    </div>
</body>

</html>