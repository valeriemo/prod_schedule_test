<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5 bg-light">

    <div class="text-center mb-4">
        <h2 class="text-primary">📅 Production Schedule</h2>
    </div>
    @if(empty($schedule))
        <div class="alert alert-warning mt-4">
            No orders available. Please create a new order to generate the production schedule.
        </div>
        <a href="{{ route('orders.create') }}" class="btn btn-success mt-3">➕ Create New Order</a>
    @else
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Due Date</th>
                        <th>Production Time</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($schedule as $item)
                    @if($item['has_changeover_delay'])
                    <tr class="table-warning" style="line-height: 0.8; font-size: 0.85rem;">
                        <td colspan="7" class="py-1">⏳ Changeover Delay of 30 minutes</td>
                    </tr>
                    @endif
                    <tr>
                        <td>{{ $item['order_id'] ?? '-' }}</td>
                        <td><strong>{{ $item['product'] }}</strong></td>
                        <td>{{ $item['quantity'] ?? '-' }}</td>
                        <td>{{ $item['due_date'] ?? '-' }}</td>
                        <td>{{ $item['production_time'] }}</td>
                        <td>{{ $item['start_time'] }}</td>
                        <td>{{ $item['end_time'] }}</td>
                    </tr>
                @endforeach
            </tbody>

            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            ➕ Create New Order
        </a>
        <a href="{{ route('welcome') }}" class="btn btn-secondary">
            🏠 Back Home
        </a>
    </div>
    @endif
</body>
</html>
