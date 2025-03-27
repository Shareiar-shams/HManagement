<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Thank you for your order, {{ $order['customer_name'] }}!</h2>
    <p>We have received your order successfully. Here are the details:</p>

    <h4>Order Summary:</h4>
    <ul>
        <li><strong>Room:</strong> {{ $order['room_name'] }}</li>
        <li><strong>Room Price:</strong> {{ $order['price'] }} BDT</li>
        <li><strong>Check-in:</strong> {{ $order['checkinDate'] }}</li>
        <li><strong>Check-out:</strong> {{ $order['checkoutDate'] }}</li>
        <li><strong>Total Days:</strong> {{ $order['days'] }}</li>
        <li><strong>Amount Paid:</strong> {{ $order['total_amount'] }} BDT</li>
    </ul>

    <p>If you have any questions, feel free to contact us.</p>

    <p>Best regards,<br>Your Hotel Team</p>
</body>
</html>
