@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">User Profiles</h1>

    <div class="mb-3 text-center">
        <small><span class="text-success">●</span> Staff | <span class="text-primary">●</span> Customer</small>
    </div>
    
    <!-- Filter and Search Form -->
    <form action="{{ route('profile.index') }}" method="GET" class="mb-4 d-flex justify-content-center align-items-center">
        <div class="form-group mb-0 mx-2">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Search by name or email" 
                value="{{ request('search') }}"
                style="width: 250px;"
            >
        </div>
        <div class="form-group mb-0 mx-2">
            <select name="role" class="form-control" style="width: 150px;">
                <option value="">All Roles</option>
                <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mx-2">Search</button>
        <a href="{{ route('profile.index') }}" class="btn btn-secondary mx-2">Clear</a>
    </form>
    
    
    <!-- User Table -->
    <ul class="list-group">
        @if($users->isEmpty())
            <li class="list-group-item text-center">No users found.</li>
        @else
            @foreach($users as $user)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <!-- Conditionally color the name based on role -->
                        <strong class="{{ $user->role === 'staff' ? 'text-success' : 'text-primary' }}">
                            {{ ucwords($user->name) }}
                        </strong> <br>
                        <small>{{ $user->email }}</small> <br>
                        <span class="badge badge-secondary">{{ ucfirst($user->role) }}</span> <!-- Display the role -->
                    </div>
                    <div>
                        <!-- Edit Role Button -->
                        <a href="{{ route('profile.editRole', ['id' => $user->id]) }}" class="btn btn-primary btn-sm">
                            Edit Role
                        </a>
    
                        <!-- Delete Button -->
                        <form action="{{ route('profile.delete', ['id' => $user->id]) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this profile?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
@endsection
