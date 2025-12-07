@extends('layouts.app')

@section('content')
<div class="container mt-4 d-flex justify-content-center">
    <div class="card shadow-sm p-4" style="width: 400px;">
        <h2 class="mb-4 text-center">Edit Role</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.updateRole', ['id' => $user->id]) }}" method="post">
            @csrf
            @method('PATCH')

            <!-- Display Name -->
            <div class="form-group mb-3">
                <label class="fw-bold">Name</label>
                <p class="form-control-plaintext">{{ ucwords($user->name) }}</p>
            </div>

            <!-- Display Email -->
            <div class="form-group mb-3">
                <label class="fw-bold">Email</label>
                <p class="form-control-plaintext">{{ $user->email }}</p>
            </div>

            <!-- Editable Role -->
            <div class="form-group mb-3">
                <label class="fw-bold" for="role">Role</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Update Role</button>
                <a href="{{ route('profile.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
