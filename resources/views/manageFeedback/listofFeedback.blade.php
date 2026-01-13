@extends('layouts.app')

@section('content')
@php
    $color = $user->role === 'staff' ? 'bg-success' : 'bg-primary';
@endphp

<div class="container mt-4">

    @if (session('blue-message'))
        <div class="alert alert-primary">{{ session('blue-message') }}</div>
    @elseif (session('red-message'))
        <div class="alert alert-danger">{{ session('red-message') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded">
        <div class="card-header {{ $color }} text-white">
            <h5 class="mb-0">Feedback List</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 5%">No</th>
                        <th style="width: 20%">Order ID</th>
                        <th style="width: 30%">Date</th>
                        <th style="width: 15%">Rating</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                </thead>

                <tbody>
                {{-- STAFF VIEW (GROUPED BY ORDER ID) --}}
                @if ($user->role === 'staff')

                    @php $no = 1; @endphp

                    @foreach ($feedbacks as $orderId => $orderFeedbacks)
                        @foreach ($orderFeedbacks as $feedback)
                            <tr class="text-center">
                                <td>{{ $no++ }}</td>
                                <td><strong>#{{ $orderId }}</strong></td>
                                <td>{{ $feedback->date }}</td>
                                <td>
                                    {{ $feedback->rating }}
                                    <i class="bi bi-star-fill text-warning"></i>
                                </td>
                                <td>
                                    <a href="{{ route('view_feedback_details', $feedback->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                {{-- CUSTOMER VIEW --}}
                @else

                    @foreach ($feedbacks as $index => $feedback)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td><strong>#{{ $feedback->order_id }}</strong></td>
                            <td>{{ $feedback->date }}</td>
                            <td>
                                {{ $feedback->rating }}
                                <i class="bi bi-star-fill text-warning"></i>
                            </td>
                            <td>
                                <a href="{{ route('view_feedback_details', $feedback->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach

                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
