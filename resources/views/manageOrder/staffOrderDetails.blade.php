@extends('layouts.app')

<head>
    <link rel="stylesheet" href="styles.css">
    <style>
        .order-details-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .order-info {
            margin-bottom: 15px;
        }

        .order-info h5 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            margin-bottom: 15px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .total-row td {
            font-weight: bold;
        }
        .back-btn {
            margin: 50px 0 50px 0;
            background: darkgray;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: left;
        }
    </style>
</head>

@section('content')
    <div class="order-details-container">
        <div class="order-header">Order Details</div>

        <div class="order-info">
            <h5>Order ID: #{{ $order->id }}</h5>
            <h5>Order Date: {{ $order->created_at->format('F d, Y h:i A') }}</h5>
        </div>

        <h5>Order List:</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->menu->name }}</td>
                        <td>{{ $item->order_quantity }}</td>
                        <td>RM {{ number_format($item->menu->price, 2) }}</td>
                        <td>RM {{ number_format($item->order_quantity * $item->menu->price, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total:</td>
                    <td>RM {{ number_format($order->items->sum(fn($item) => $item->order_quantity * $item->menu->price), 2) }}</td>
                </tr>
            </tbody>
        </table>
        <div class="text-center mt-4">
        <div class="cart-footer">
                <button class="back-btn" onclick="history.back()">Back</button>
            </div>
        </div>
    </div>
@endsection