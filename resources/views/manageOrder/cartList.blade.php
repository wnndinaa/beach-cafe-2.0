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
    </style>
    
</head>
@section('content')
    <div class="container">
        @include('manageOrder.progress', ['step' => 1])
        <div class="cart-header shadow">My Cart</div>
        <div class="card p-4 shadow">
            <div class="cart-items">
                <form method="POST" action="{{ route('checkout') }}">
                    @csrf
                    @if ($cartItems->isEmpty())
                        <p>Your cart is empty.</p>
                    @else
                        @foreach ($cartItems as $data)
                            <div class="cart-item" data-price="{{ $data->menu->price }}">
                                <img src="{{ asset('asset/default-image/' . $data->menu->image_path) }}"
                                    alt="{{ $data->menu->name }}" style="width: 200px;">
                                <div class="cart-item-details">
                                    <b>
                                        <p class="cart-item-name">{{ $data->menu->name }}</p>
                                    </b>
                                    <p class="cart-item-remark">{{ $data->order_portion }}</p>
                                    <p class="cart-item-remark"><b><i>*{{ $data->order_remark }}</i></b></p>
                                    <div class="cart-item-quantity">
                                        <button type="button" class="minus">-</button>
                                        <input type="number" class="quantity-input" name="cartItems[{{ $data->id }}]"
                                            min="1" value="{{ $data->order_quantity }}">
                                        <button type="button" class="plus">+</button>
                                        <br><br>
                                        <!-- Inside the foreach loop for cart items -->
                                        <a href="{{ route('order.edit', ['orderId' => $data->order_id, 'menuId' => $data->menu_id]) }}">
                                            <i class="fas fa-edit" style="padding-right:15px;color:blue"></i>
                                        </a>

                                        <a href="#"
                                            onclick="showDeleteConfirmation('{{ route('order.destroy', $data->id) }}');">
                                            <i class="fas fa-trash" style="padding-right:15px;color:rgb(255, 5, 5)"></i>
                                        </a>

                                    </div>
                                </div>
                                <div class="cart-item-price">RM <span
                                        class="item-total">{{ $data->menu->price * $data->order_quantity }}</span></div>
                            </div>
                            
                        <hr>
                        @endforeach
                        <div class="total">Total: RM <span id="grand-total">0</span></div>
                        <div class="cart-footer">
                            <button type="submit" class="checkout-btn">Checkout</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        
        <div class="cart-footer">
            <div style="margin-top:50px;">
                <a href="{{ route('menu') }}" class="back-btn">Back to Menu</a>
            </div>
        </div>

        {{-- !-- Padam Aduan Modal --> --}}
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Order Details ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete this order details ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="" id="deleteLink" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTotals() {
            let grandTotal = 0;

            document.querySelectorAll('.cart-item').forEach(item => {
                const price = parseFloat(item.getAttribute('data-price'));
                const quantity = parseInt(item.querySelector('.quantity-input').value);
                const itemTotal = price * quantity;

                item.querySelector('.item-total').textContent = itemTotal.toFixed(2);
                grandTotal += itemTotal;
            });

            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
        }

        document.querySelectorAll('.plus').forEach((button, index) => {
            button.addEventListener('click', () => {
                const input = document.querySelectorAll('.quantity-input')[index];
                input.value = parseInt(input.value) + 1;
                updateTotals();
            });
        });

        document.querySelectorAll('.minus').forEach((button, index) => {
            button.addEventListener('click', () => {
                const input = document.querySelectorAll('.quantity-input')[index];
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    updateTotals();
                }
            });
        });

        updateTotals();
    </script>

    <!--  End Padam Aduan Modal -->
    <script>
        function showDeleteConfirmation(deleteUrl) {
            // Set the href attribute of the delete link in the modal
            document.getElementById('deleteLink').href = deleteUrl;

            // Show the delete confirmation modal
            $('#deleteConfirmationModal').modal('show');
        }
    </script>
@endsection