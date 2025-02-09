<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Production schedule test</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="text-center">
        <h1 class="mb-4">Welcome</h1>
        <h2 class="mb-4">Laravel Production Scheduler 🚀</h2>
        <div class="mt-4">
            <a href="{{ route('orders.create') }}" class="btn btn-primary">➕ Create New Order</a>
            <a href="{{ route('schedule.index') }}" class="btn btn-secondary">View Production Schedule</a>
        </div>
    </div>
</body>
</html>
