@extends('layouts.app')

@section('content')
<div class="container mt-4">

    @if (session('blue-message'))
        <div class="alert alert-primary">{{ session('blue-message') }}</div>
    @elseif (session('red-message'))
        <div class="alert alert-danger">{{ session('red-message') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Feedback Details</h5>
        </div>

        <div class="card-body">

            <p><strong>Customer:</strong> {{ $feedback->user->name }}</p>
            <p><strong>Date:</strong> {{ $feedback->date }}</p>
            <p><strong>Order ID:</strong> #{{ $feedback->order_id }}</p>

            <hr>

            <h6>Order Items</h6>
            <ul class="list-group mb-3">
                @foreach ($feedback->order->items as $item)
                    <li class="list-group-item">
                        {{ $item->menu->name }} × {{ $item->order_quantity }}
                    </li>
                @endforeach
            </ul>

            <hr>

            <h6>Comment</h6>
            <p class="border rounded p-2 bg-light">{{ $feedback->comment }}</p>

            <h6>Rating</h6>
            <p>
                {{ $feedback->rating }}
                <i class="bi bi-star-fill text-warning"></i>
            </p>

            {{-- STAFF REPLY --}}
            @if (Auth::user()->role === 'staff')
                <hr>
                <h6>Staff Reply</h6>

                @if ($feedback->reply)
                    <div class="alert alert-success">
                        {{ $feedback->reply }}
                        <br>
                        <small>Replied at {{ $feedback->replied_at }}</small>
                    </div>

                    <form action="{{ route('delete_reply', $feedback->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete Reply</button>
                    </form>
                @else
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#replyModal">
                        Reply
                    </button>
                @endif
            @endif

        </div>
    </div>
</div>

{{-- REPLY Pop-up --}}
@if (Auth::user()->role === 'staff')
<div class="modal fade" id="replyModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('add_reply', $feedback->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea name="reply" class="form-control" rows="4" required></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@endsection
