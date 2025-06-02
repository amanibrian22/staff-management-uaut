<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Risk Update Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #2e7d32;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #2e7d32;
        }
        .content p {
            margin: 10px 0;
        }
        .details {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .details p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #1976d2;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>UAUT Risk Management System</h1>
        </div>
        <div class="content">
            <h2>Risk Update Notification</h2>
            <p>Dear {{ $risk->reporter->name ?? 'User' }},</p>
            <p>Your reported risk has been updated with the following action: <strong>{{ ucfirst($action) }}</strong>.</p>
            <div class="details">
                <p><strong>Risk ID:</strong> {{ $risk->id }}</p>
                <p><strong>Description:</strong> {{ $risk->description }}</p>
                <p><strong>Type:</strong> {{ ucfirst($risk->type) }}</p>
                <p><strong>Urgency:</strong> {{ ucfirst($risk->urgency) }}</p>
                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $risk->status)) }}</p>
                <p><strong>Response:</strong> {{ $risk->response ?? 'N/A' }}</p>
                <p><strong>Responder:</strong> {{ $risk->responder->name ?? 'N/A' }}</p>
            </div>
            <p>Please log in to the UAUT Risk Management System to view full details or take further action.</p>
            <a href="{{ url('localhost:8000/staff/login') }}" class="button">View Dashboard</a>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} UAUT Risk Management System. All rights reserved.</p>
            <p>This is an automated email, please do not reply directly.</p>
        </div>
    </div>
</body>
</html>
