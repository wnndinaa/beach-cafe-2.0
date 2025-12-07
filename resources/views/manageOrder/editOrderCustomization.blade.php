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
        margin-top: 20px 0 50px 0;
        background: darkgray;
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        float:left;
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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <div class="container mt-5">

        <h2 class="text-center mb-4">Edit Your Order</h2>
        @if ($menus->isNotEmpty())
            <form action="{{ route('order.update', $menus->first()->order_id) }}" method="POST">
                @csrf
                @method('PUT')

                @foreach ($menus as $menu)
                    <div class="card p-4 shadow mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('asset/default-image/' . $menu->menu->image_path) }}" 
                                     alt="{{ $menu->menu->name }}" style="width: 300px;">
                            </div>
                            <div class="col-md-8">
                            <div>
                                <span><strong style="font-size:x-large;">{{ $menu->menu->name }}</strong> / <i>RM{{ $menu->menu->price }}</i></span>
                            </div><br>

                                <!-- Portion Size -->
                                <div class="mb-3">
                                    <label for="order_portion_{{ $menu->id }}" class="form-label"><strong>Portion Size</strong></label>
                                    <select id="order_portion_{{ $menu->id }}" name="order_portion[{{ $menu->id }}]" class="form-select">
                                        <option value="regular" {{ $menu->order_portion === 'regular' ? 'selected' : '' }}>Regular</option>
                                        <option value="large" {{ $menu->order_portion === 'large' ? 'selected' : '' }}>Large</option>
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
                                <textarea id="order_remark_{{ $menu->id }}" name="order_remark[{{ $menu->id }}]" rows="3" class="form-control" placeholder="E.g., No pickles, extra sauce">{{ $menu->order_remark }}</textarea>
                            </div>

                                <!-- Quantity -->
                                <div class="mb-3">
                                    <label for="order_quantity_{{ $menu->id }}" class="form-label"><strong>Quantity</strong></label>
                                    <input type="number" id="order_quantity_{{ $menu->id }}" name="order_quantity[{{ $menu->id }}]" 
                                           class="form-control" value="{{ $menu->order_quantity }}" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Update Order</button>
                        </div>
                    </div> 
                @endforeach
            </form>
                
        @else
            <p class="text-center text-danger">No items found for this order.</p>
        @endif

        <div class="text-center mt-4">
            <button class="back-btn" onclick="history.back()">Back</button>
        </div>
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