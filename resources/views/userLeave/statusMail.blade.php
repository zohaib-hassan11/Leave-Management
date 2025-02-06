<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Leave Status Update</title>
</head>
<body>
    <h1>Leave Status Update</h1>
    <p>Hello {{ $leave->user->name }},</p>
    <p>Your leave request from {{ $leave->start_date }} to {{ $leave->end_date }} has been updated to: <strong>{{ $leave->status }}</strong></p>
    <p>Reason: {{ $leave->reason }}</p>
    <p>If you have any questions, feel free to contact us.</p>
    <p>Thank you!</p>
</body>
</html>
