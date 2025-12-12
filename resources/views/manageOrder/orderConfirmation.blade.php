@extends('layouts.app')

<head>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
    
        .cart-header {
            background: #fff;
            color: #000;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
    
        .cart-items {
            width: 100%;
            padding: 20px 40px 20px 40px;
        }
    
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
    
        .cart-item img {
            width: 200px;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }
    
        .cart-item-details {
            flex: 1;
            margin-left: 20px;
        }
    
        .cart-item-name {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
    
        .cart-item-price {
            color: #28a745;
            font-weight: bold;
        }
    
        .cart-item-quantity button {
            background: #ddd;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 16px;
        }
    
        .cart-item-quantity .quantity-input {
            width: 40px;
            text-align: center;
        }
    
        .total {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            text-align: right;
        }
    
        .checkout-btn {
            background: #dc3545;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin :20px 0 0 820px;
        }
    
        .checkout-btn:hover {
            background: #c82333;
        }
    
        .back-btn {
            background: darkgray;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin:20px 0 20px 0;
        }
    
        .back-btn:hover {
            background: grey;
        }
    </style>
</head>
@section('content')
    <div class="container">
        @include('manageOrder.progress', ['step' => 2])

            <div class="cart-header shadow">Order Confirmation</div>
            <div class="card p-4 shadow">

                <!-- Items -->
                <div class="cart-items">
                    @foreach ($cartItems as $item)
                        <div class="cart-item">
                            <img src="{{ asset('asset/default-image/' . $item->menu->image_path) }}" alt="{{ $item->menu->name }}">
                            <div class="cart-item-details">
                                <p class="cart-item-name"><b>{{ $item->menu->name }} x{{ $item->order_quantity }}</b></p>
                                <p class="cart-item-remark">{{ $item->order_portion }}</b></p>
                                <p class="cart-item-remark"><i><b>*{{ $item->order_remark }}</b><i></p>
                            </div>
                            <div class="cart-item-price">
                                RM{{ number_format($item->menu->price * $item->order_quantity, 2) }}
                            </div>
                        </div>
                    <hr>
                    @endforeach
                    <div class="total">Total: RM{{ number_format($item->order->order_total, 2) }}</div>
                   
                    <div class="cart-footer">
                        <button class="checkout-btn" onclick="confirmOrder({{ $item->order->id }})">Place Order</button>
                    </div>
                </div>
            </div>
            <button class="back-btn" onclick="history.back()">Back</button>
    </div>
    </div>

<script>
    function confirmOrder(orderId) {
        if (confirm("Are you sure you want to place this order?")) {
            // Send the request to change the order status
            fetch(/confirm-order/${orderId}, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(HTTP error! status: ${response.status});
                }
                return response.json(); // Parse the JSON response
            })
            .then(data => {
                if (data.success) {
                    // Redirect to the Order Status page
                    window.location.href = /order-status/${orderId};
                } else {
                    alert(data.message || "Failed to place the order. Please try again.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            });
        }
    }
</script>

    
    
@endsection