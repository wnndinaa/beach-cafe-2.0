@extends('layouts.app')

<head>
    <!-- Font Awesome for the bell icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

@section('content')
    <style>
        .back-btn {
            margin-top: 70px;
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

        .notification-icon {
            cursor: pointer;
            font-size: 18px;
            color: grey;
            margin-left: 10px;
        }

        .notification-icon:hover {
            color: blue;
        }

        .notification-message {
            display: none;
            background-color: #90EE90;
            color: #721c24;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }
    </style>

    <div class="container mt-5">
        <!-- Display success message at the top -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-center mb-4">Customize Your Order</h2>
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
        
            <div class="card p-4 shadow">
                <!-- Menu Item Details -->
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('asset/default-image/' . $menu->image_path) }}" alt="{{ $menu->name }}" style="width: 300px;">
                    </div>
                    <div class="col-md-8">
                        <div>
                            <span><strong style="font-size:x-large;">{{ $menu->name }}</strong> / <i>RM{{ $menu->price }}</i></span>
                        </div><br>

                        <!-- Customization Options -->
                        <form role="form" method="POST" action="{{ route('order.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                            <!-- Portion Size -->
                            <div class="mb-3">
                                <label for="portion-size" class="form-label"><strong>Portion Size</strong></label>
                                <select id="order_portion" name="order_portion" class="form-select">
                                    <option value="Regular">Regular</option>
                                    <option value="Large">Large</option>
                                </select>
                            </div>

                            <!-- Special Instructions -->
                            <div class="mb-3">
                                <label for="special-instructions" class="form-label"><strong>Remark</strong>
                                    <span class="notification-icon" id="notificationIcon">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </label>
                                <!-- Hidden message that will be displayed when the bell is clicked -->
                                <div class="notification-message" id="notificationMessage">
                                    Remark your order to tell the kitchen.
                                </div><br>
                                <textarea id="order_remark" name="order_remark" rows="3" class="form-control" placeholder="E.g., No pickles, extra sauce"></textarea>
                            </div>

                            <!-- Quantity -->
                            <div class="mb-3">
                                <label for="quantity" class="form-label"><strong>Quantity</strong></label>
                                <input type="number" id="order_quantity" name="order_quantity" class="form-control" value="1" min="1">
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="cart-footer">
                <button class="back-btn" onclick="history.back()">Back</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS (Necessary for modals and other components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript to Handle Click Event -->
    <script>
        // Handle the click event for the bell icon
        document.getElementById('notificationIcon').addEventListener('click', function() {
            // Show or hide the notification message
            var message = document.getElementById('notificationMessage');
            if (message.style.display === 'none' || message.style.display === '') {
                message.style.display = 'block'; // Show message
            } else {
                message.style.display = 'none'; // Hide message
            }
        });
    </script>
@endsection