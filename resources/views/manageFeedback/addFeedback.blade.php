@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- Flash Messages --}}
    @if (session('blue-message'))
        <div class="alert alert-primary text-primary" id="quick-message">
            {{ session('blue-message') }}
        </div>
    @elseif (session('red-message'))
        <div class="alert alert-danger text-danger" id="quick-message">
            {{ session('red-message') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add Feedback</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('create_feedback') }}" method="POST">
                @csrf

                {{-- Hidden fields --}}
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                {{-- Order Items (instead of menu) --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Order Items</label>
                    <ul class="list-group">
                        @foreach ($order->items as $item)
                            <li class="list-group-item">
                                {{ $item->menu->name }} (x{{ $item->order_quantity }})
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Comment --}}
                <div class="mb-3">
                    <label for="comment" class="form-label fw-semibold">Comment</label>
                    <textarea
                        class="form-control @error('comment') is-invalid @enderror"
                        id="comment"
                        name="comment"
                        rows="4"
                        placeholder="Write your feedback here...">{{ old('comment') }}</textarea>

                    @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Rating --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Rating</label>
                    <div class="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <input
                                type="radio"
                                id="star{{ $i }}"
                                name="rating"
                                value="{{ $i }}"
                                class="d-none"
                                {{ old('rating') == $i ? 'checked' : '' }}>
                            <label for="star{{ $i }}" class="star">&#9733;</label>
                        @endfor
                    </div>

                    @error('rating')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Date --}}
                <div class="mb-3">
                    <label for="feedbackDate" class="form-label fw-semibold">Date</label>
                    <input
                        type="date"
                        class="form-control @error('date') is-invalid @enderror"
                        id="feedbackDate"
                        name="date"
                        max="{{ now()->toDateString() }}"
                        value="{{ old('date') }}">

                    @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
