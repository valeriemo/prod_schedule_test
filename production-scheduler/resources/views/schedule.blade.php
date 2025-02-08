<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Production Schedule</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedule as $task)
                <tr>
                    <!-- <td>{{ $task['order_id'] }}</td>
                    <td>{{ $task['product'] }}</td>
                    <td>{{ $task['start_time'] }}</td>
                    <td>{{ $task['end_time'] }}</td> -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.create') }}" class="btn btn-primary mt-3">Back to Orders</a>
</body>
</html>
