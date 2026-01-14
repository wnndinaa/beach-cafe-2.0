@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        {{-- Use a smaller column (e.g., col-md-6) to make the form feel more compact --}}
        <div class="col-md-6">
            <div class="card shadow-sm">

                {{-- Card Header --}}
                <div class="card-header bg-light fw-bold">
                    Add Menu Item
                </div>

                <div class="card-body p-4">

                    {{-- Form begins (Note: Input name 'image' is preserved as requested) --}}
                    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Name Input --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        {{-- Price Input --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            {{-- Changed type to number for better validation, as per best practice --}}
                            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                        </div>

                        {{-- Status & Category in one row for better layout and compactness --}}
                        <div class="row">
                            {{-- Status Select --}}
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>

                            {{-- Category Select --}}
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category:</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="Side Dish">Side Dish</option>
                                    <option value="Drink">Drink</option>
                                    <option value="Food">Food</option>
                                </select>
                            </div>
                        </div>

                        {{-- Image Input --}}
                        <div class="mb-4">
                            <label for="image" class="form-label">Image:</label>
                            <input type="file" name="image" id="image" class="form-control" required>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-between pt-2">
                            <button type="submit" class="btn btn-primary me-2">Add Menu</button>
                            <a href="{{ route('staff-menu') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
