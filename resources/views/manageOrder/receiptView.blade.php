<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .header { text-align: center; font-size: 24px; font-weight: bold; }
        .order-details, .order-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .order-table th, .order-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .order-table th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="header">Oder Receipt</div>
    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}</p>
    <p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
    <hr>
    <h4>Order Items</h4>
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
                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>RM{{ number_format($order->order_total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>