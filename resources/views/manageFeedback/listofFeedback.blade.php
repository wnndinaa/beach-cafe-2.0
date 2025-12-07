@extends('layouts.app')

@section('content')
    @php
        if ($user->role == 'customer') {
            $color = 'bg-primary';
        } elseif ($user->role == 'staff') {
            $color = 'bg-success';  
        }
    @endphp

    <div class="container mt-4">

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
            <div class="card-header {{ $color }} text-white rounded-top">
                <h5 class="mb-0">Feedback List</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col" class="text-center">No</th>

                        @if ($user->role == 'Staff')
                            <th scope="col">Customer Name</th>
                        @endif
                        
                        <th scope="col">Menu</th>
                            <th scope="col">Date</th>
                            <th scope="col">Rating</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feedbacks as $index => $feedback)
                            <tr class="{{ $index % 2 === 0 ? 'table-light' : 'table-secondary' }}">
                                <th scope="row" class="text-center fw-bold">{{ $index + 1 }}</th>

                            @if ($user->role == 'Staff')
                                <td>{{ $feedback->user->name }}</td>
                            @endif

                                <td>{{ $feedback->menu->name }}</td>
                                <td>{{ $feedback->date }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $feedback->rating }} 
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('view_feedback_details', ['id' => $feedback->id]) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    
                                    @if ($user->role == 'customer')
                                        <a href="{{ route('edit_feedback_details', ['id' => $feedback->id]) }}" class="btn btn-sm btn-outline-warning me-1">
                                            <i class="bi bi-eye"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('delete_feedback', ['id' => $feedback->id]) }}" method="post" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                        
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                        
                                        <script>
                                            function confirmDelete() {
                                                return confirm("Are you sure you want to delete this feedback?");
                                            }
                                        </script>
                                        
                                    @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
