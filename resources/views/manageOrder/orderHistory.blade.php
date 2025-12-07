@extends('layouts.app')

@section('content')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"></head>
<style>
        body {
            background-color: #f8f9fa;
        }

        .cart-container {
            max-width: 600px;
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

        .cart-body {
            padding: 20px;
        }

        .table th,
        .table td {
            text-align: center;
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

        .cart-items {
            width: 100%;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

    </style>
    <div class="container mt-5">

        <!-- Display success message if present -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="cart-header shadow">My Order History</div>
        <div class="card p-4 shadow">
            <div class="cart-items">

                <!-- Loop through all orders -->
                @foreach ($orders as $order)
                    <div class="mb-4">
                        <h5><strong>Order ID:</strong> #{{ $order->id }}</h5>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                            @if ($order->first()->order_status == 'success')
                                Order Status: <b><span class="text-success">Success</span></b>
                            @elseif ($order->first()->order_status == 'pending')
                                Order Status: <b><span class="text-warning">Pending</span></b>
                            @else
                                Order Status: <b><span class="text-danger">Cancelled</span></b>
                            @endif
                            <p >
                                Download Receipt:
                                <a href="{{ route('order.download', $order->id) }}" class="btn btn-primary">
                                    <i class="fas fa-download"></i></a>
                            </p>
                        <hr>
                        

                        <!-- Order List Section -->
                        <h5><strong>Order List:</strong></h5>
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
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>RM
                                            {{ number_format($order->items->sum(fn($item) => $item->order_quantity * $item->menu->price), 2) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3 mt-3 flex">
                            <!-- Reorder button -->
                            <form action="{{ route('order.reorder', $order->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm action-btn float-end" style="width:100px; margin-right:20px; height:50px;">Reorder</button>
                                <button type="button" class="btn btn-danger btn-sm action-btn float-end" style="width:100px; margin-right:20px; height:50px;"
                                onclick="showDeleteConfirmation('{{ route('reorder.delete', $order->id) }}')">
                                Delete
                            </button>
                            </form>
                        </div>
                    </div>
                    <hr>
                @endforeach

            </div>
        </div>

        <!-- Back Button -->
        <div class="cart-footer">
            <div style="margin-top:50px;">
                <a href="{{ route('menu') }}" class="back-btn">Back to Menu</a>
            </div>
        </div>

        <!-- Modal for Delete Confirmation -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Order Details?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this order's details?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="" method="POST" id="deleteForm" style="display: inline-block;">
                            @csrf
                            @method('DELETE') <!-- This simulates the DELETE request -->
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showDeleteConfirmation(deleteUrl) {
                // Set the action of the delete form to the delete URL
                document.getElementById('deleteForm').action = deleteUrl;

                // Show the delete confirmation modal
                $('#deleteConfirmationModal').modal('show');
            }
        </script>

@endsection