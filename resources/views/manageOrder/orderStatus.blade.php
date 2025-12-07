@extends('layouts.app')

<head>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .cart-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 10px 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            background: #fff;
            color: #000;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .row {
            padding: 15px;
            background: #fff;
            color: #000;
            font-size: 18px;
            font-weight: bold;
        }

        .back-btn {
            text-decoration: none;
            margin-top: 20px;
            background: darkgray;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-btn:hover {
            background: grey;
        }

        .order-status {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            margin-top: 20px;
        }

        .order-details {
            padding: 20px;
        }

        .order-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .order-table th, .order-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .order-table th {
            background-color: #f8f9fa;
        }

        .order-table tfoot td {
            font-weight: bold;
        }
    </style>
</head>

@section('content')
    @include('manageOrder.progress', ['step' => 3])

    <br>
    <div class="container">
        <div class="cart-header shadow">Invoice Order</div>
        <div class="card p-4 shadow">

            <!-- Display Success Message -->
            @if (session('order_placed'))
                <div class="alert alert-success" role="alert">
                    {{ session('order_placed') }}
                </div>
            @endif

            <!-- Order Details Section -->
            <div class="order-details">
                @if ($items->isNotEmpty())
                    <h5><strong>Order ID:</strong> #{{ $items->first()->order->id }}</h5>
                    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($items->first()->order->order_date)->format('F d, Y') }}</p>
                    <p>
                        @if ($items->first()->order->order_status == 'success')
                        Order Status: <b><span class="text-success">Success</span></b>
                        @elseif ($items->first()->order->order_status == 'pending')
                            Order Status: <b><span class="text-warning">Pending</span></b>
                        @else
                        Order Status: <b><span class="text-danger">Cancelled</span></b>
                        @endif
                    </p>
                    <p>
                        Download Receipt: 
                        <a href="{{ route('invoice.download', ['order_id' => $items->first()->order->id]) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i></a>
                    </p>
                    <hr>
                @endif

                <!-- Order List Section -->
                <h5><strong>Order List</strong></h5>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->menu->name }}</td>
                                <td>{{ $item->order_quantity }}</td>
                                <td>RM{{ number_format($item->menu->price, 2) }}</td>
                                <td>RM{{ number_format($item->menu->price * $item->order_quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>RM{{ number_format($items->first()->order->order_total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Back Button -->
        <div class="cart-footer">
            <div style="margin-top:50px;">
                <a href="{{ route('menu') }}" class="back-btn">Back to Menu</a>
            </div>
        </div>
    </div>
@endsection