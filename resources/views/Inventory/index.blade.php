@extends('layouts.app')

@section('content')
<div class="inventory-wrapper">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Inventory Management</h2>
            <a href="{{ route('inventory.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Inventory
            </a>
        </div>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please fix the errors below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="filter-section mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <form method="GET" action="{{ route('inventory.index') }}" id="filterForm">
                        <label for="filterCategory" class="form-label">Filter by Category</label>
                        <select class="form-select" id="filterCategory" name="category" onchange="document.getElementById('filterForm').submit();">
                            <option value="all">All Categories</option>
                            @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $filterCategory === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @if ($filterDate)
                        <input type="hidden" name="date" value="{{ $filterDate }}">
                        @endif
                    </form>
                </div>
                <div class="col-md-3">
                    <form method="GET" action="{{ route('inventory.index') }}" id="dateFilterForm">
                        <label for="filterDate" class="form-label">Filter by Date</label>
                        <input type="date" class="form-control" id="filterDate" name="date" value="{{ $filterDate ?? '' }}" onchange="document.getElementById('dateFilterForm').submit();">
                        @if ($filterCategory && $filterCategory !== 'all')
                        <input type="hidden" name="category" value="{{ $filterCategory }}">
                        @endif
                    </form>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary w-100">Clear Filters</a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                @if ($inventories->count() > 0)
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Unit Price</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $currentCategory = null;
                        $today = \Carbon\Carbon::now()->format('Y-m-d');
                        @endphp
                        @foreach ($inventories as $inventory)
                        @if ($currentCategory !== $inventory->category)
                        @php
                        $currentCategory = $inventory->category;
                        @endphp
                        <tr class="table-light">
                            <td colspan="7" class="fw-bold text-muted">{{ $inventory->category }}</td>
                        </tr>
                        @endif
                        @php
                        $isToday = \Carbon\Carbon::parse($inventory->date)->format('Y-m-d') === $today;
                        $isFilterDate = $filterDate && \Carbon\Carbon::parse($inventory->date)->format('Y-m-d') === $filterDate;
                        @endphp
                        <tr @if($isFilterDate) class="highlight-row" @endif>
                            <td>{{ $inventory->item_name }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $inventory->category }}</span>
                            </td>
                            <td>{{ $inventory->quantity }}</td>
                            <td>{{ $inventory->unit }}</td>
                            <td>RM {{ number_format($inventory->unit_price, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($inventory->date)->format('d M Y') }} @if($isToday)<span class="badge bg-success">Today</span>@endif</td>
                            <td class="text-center">
                                <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-5 text-center">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No inventory items found. <a href="{{ route('inventory.create') }}">Add one now!</a></p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .inventory-wrapper {
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        padding: 20px;
        background-color: #fff;
        margin-bottom: 20px;
    }

    .filter-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
    }

    .filter-section .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .highlight-row {
        background-color: #fff3cd !important;
    }

    .highlight-row:hover {
        background-color: #ffe69c !important;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    h2 {
        color: #333;
        font-weight: 600;
    }
</style>
@endsection