@extends('layouts.app')

@section('content')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

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
        border-radius: 10px 10px 0 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .back-btn {
        text-decoration: none;
        margin-top: 20px;
        background: darkgray;
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .back-btn:hover {
        background: grey;
    }
</style>

<div class="container mt-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="cart-header shadow">My Order History</div>

    <div class="card p-4 shadow">
        @foreach ($orders as $order)

            <div class="mb-4">
                <h5><strong>Order ID:</strong> #{{ $order->id }}</h5>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>

                <p>
                    <strong>Order Status:</strong>
                    @if ($order->order_status === 'success')
                        <span class="text-success">Success</span>
                    @elseif ($order->order_status === 'pending')
                        <span class="text-warning">Pending</span>
                    @else
                        <span class="text-danger">Cancelled</span>
                    @endif
                </p>

                <p>
                    Download Receipt:
                    <a href="{{ route('order.download', $order->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-download"></i>
                    </a>
                </p>

                <hr>

                {{-- ORDER ITEMS --}}
                <h5><strong>Order List:</strong></h5>
                <table class="table table-bordered text-center">
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
                            <td>
                                <strong>
                                    RM {{ number_format(
                                        $order->items->sum(fn($i) => $i->order_quantity * $i->menu->price),
                                        2
                                    ) }}
                                </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- ACTION BUTTONS --}}
                <div class="d-flex justify-content-end gap-3 mt-3">

                    {{-- REORDER --}}
                    <form action="{{ route('order.reorder', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="width:110px;">
                            Reorder
                        </button>
                    </form>

                    {{-- ADD FEEDBACK --}}
                    @if (Auth::user()->role === 'customer' && $order->order_status === 'success')
                        <a href="{{ route('view_add_Feedback', ['order_id' => $order->id]) }}"
                           class="btn btn-success"
                           style="width:140px;">
                            Add Feedback
                        </a>
                    @endif

                    {{-- DELETE --}}
                    <button type="button"
                        class="btn btn-danger"
                        style="width:110px;"
                        onclick="showDeleteConfirmation('{{ route('reorder.delete', $order->id) }}')">
                        Delete
                    </button>

                </div>

                <hr>
            </div>

        @endforeach
    </div>

    <div class="mt-5 text-center">
        <a href="{{ route('menu') }}" class="back-btn">Back to Menu</a>
    </div>
</div>

{{-- DELETE CONFIRMATION MODAL --}}
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Order?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this order?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showDeleteConfirmation(url) {
        document.getElementById('deleteForm').action = url;
        $('#deleteConfirmationModal').modal('show');
    }
</script>

@endsection
