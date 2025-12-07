@extends('layouts.app')

<head>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .order-table {
            margin: 20px auto;
            max-width: 800px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-view {
            color: #fff;
            background-color: #007bff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-view:hover {
            background-color: #0056b3;
        }
    </style>
</head>

@section('content')
    <div class="container">
        <div class="order-header">Order List</div>
        <table class="table table-bordered order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                        <td>RM {{ number_format($order->items->sum(fn($item) => $item->order_quantity * $item->menu->price), 2) }}</td>
                        <td>
                            <a href="{{ route('staff.orderDetails', $order->id) }}" class="btn-view" style="text-decoration:none;">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection