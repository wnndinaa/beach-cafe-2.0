@extends('layouts.app')

@section('content')
<div class="inventory-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inventory-form-wrapper">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                {{ isset($inventory) ? 'Edit Inventory Item' : 'Add New Inventory Item' }}
                            </h5>
                        </div>

                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form action="{{ isset($inventory) ? route('inventory.update', $inventory->id) : route('inventory.store') }}" method="POST">
                                @csrf
                                @if (isset($inventory))
                                @method('PUT')
                                @endif

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="item_name" class="form-label">Item Name <span class="text-danger">*</span></label>
                                        <select class="form-select @error('item_name') is-invalid @enderror"
                                            id="item_name" name="item_name">
                                            <option value="">Select Item Name</option>
                                            @foreach ($itemNames as $name)
                                            <option value="{{ $name }}" {{ (isset($inventory) && $inventory->item_name === $name) || old('item_name') === $name ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                            <option value="__add_new__">── Add New Item ──</option>
                                        </select>
                                        <input type="text" class="form-control mt-2 d-none @error('item_name') is-invalid @enderror"
                                            id="item_name_input" name="item_name_new" placeholder="Enter new item name">
                                        @error('item_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                        <select class="form-select @error('category') is-invalid @enderror"
                                            id="category" name="category">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $cat)
                                            <option value="{{ $cat }}" {{ (isset($inventory) && $inventory->category === $cat) || old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                            <option value="__add_new__">── Add New Category ──</option>
                                        </select>
                                        <input type="text" class="form-control mt-2 d-none @error('category') is-invalid @enderror"
                                            id="category_input" name="category_new" placeholder="Enter new category">
                                        @error('category')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                            id="quantity" name="quantity"
                                            value="{{ isset($inventory) ? $inventory->quantity : old('quantity', 0) }}"
                                            min="0" required>
                                        @error('quantity')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                                        <select class="form-select @error('unit') is-invalid @enderror"
                                            id="unit" name="unit" required>
                                            <option value="">Select Unit</option>
                                            <option value="pcs" {{ (isset($inventory) && $inventory->unit === 'pcs') || old('unit') === 'pcs' ? 'selected' : '' }}>pcs (Pieces)</option>
                                            <option value="kg" {{ (isset($inventory) && $inventory->unit === 'kg') || old('unit') === 'kg' ? 'selected' : '' }}>kg</option>
                                            <option value="g" {{ (isset($inventory) && $inventory->unit === 'g') || old('unit') === 'g' ? 'selected' : '' }}>g</option>
                                            <option value="L" {{ (isset($inventory) && $inventory->unit === 'L') || old('unit') === 'L' ? 'selected' : '' }}>L (Liters)</option>
                                            <option value="ml" {{ (isset($inventory) && $inventory->unit === 'ml') || old('unit') === 'ml' ? 'selected' : '' }}>ml</option>
                                            <option value="box" {{ (isset($inventory) && $inventory->unit === 'box') || old('unit') === 'box' ? 'selected' : '' }}>box</option>
                                            <option value="bundle" {{ (isset($inventory) && $inventory->unit === 'bundle') || old('unit') === 'bundle' ? 'selected' : '' }}>bundle</option>
                                        </select>
                                        @error('unit')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="unit_price" class="form-label">Unit Price (RM) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('unit_price') is-invalid @enderror"
                                            id="unit_price" name="unit_price"
                                            value="{{ isset($inventory) ? number_format($inventory->unit_price, 2, '.', '') : old('unit_price', '') }}"
                                            min="0" step="0.01" placeholder="0.00" inputmode="decimal" required>
                                        @error('unit_price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        id="date" name="date"
                                        value="{{ isset($inventory)? \Carbon\Carbon::parse($inventory->date)->format('Y-m-d'): old('date', date('Y-m-d')) }}"

                                        required>
                                    @error('date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> {{ isset($inventory) ? 'Update' : 'Save' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

    .inventory-form-wrapper {
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        padding: 20px;
        background-color: #fff;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .text-danger {
        color: #dc3545;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemNameSelect = document.getElementById('item_name');
        const itemNameInput = document.getElementById('item_name_input');
        const categorySelect = document.getElementById('category');
        const categoryInput = document.getElementById('category_input');

        itemNameSelect.addEventListener('change', function() {
            if (this.value === '__add_new__') {
                itemNameInput.classList.remove('d-none');
                itemNameInput.focus();
                itemNameInput.value = '';
                itemNameInput.required = true;
            } else {
                itemNameInput.classList.add('d-none');
                itemNameInput.value = '';
                itemNameInput.required = false;
            }
        });

        categorySelect.addEventListener('change', function() {
            if (this.value === '__add_new__') {
                categoryInput.classList.remove('d-none');
                categoryInput.focus();
                categoryInput.value = '';
                categoryInput.required = true;
            } else {
                categoryInput.classList.add('d-none');
                categoryInput.value = '';
                categoryInput.required = false;
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            let isValid = true;

            if (itemNameSelect.value === '__add_new__') {
                if (itemNameInput.value === '') {
                    e.preventDefault();
                    itemNameSelect.classList.add('is-invalid');
                    isValid = false;
                } else {
                    itemNameSelect.classList.remove('is-invalid');
                    itemNameSelect.value = itemNameInput.value;
                }
            } else if (itemNameSelect.value === '') {
                e.preventDefault();
                itemNameSelect.classList.add('is-invalid');
                isValid = false;
            } else {
                itemNameSelect.classList.remove('is-invalid');
            }

            if (categorySelect.value === '__add_new__') {
                if (categoryInput.value === '') {
                    e.preventDefault();
                    categorySelect.classList.add('is-invalid');
                    isValid = false;
                } else {
                    categorySelect.classList.remove('is-invalid');
                    categorySelect.value = categoryInput.value;
                }
            } else if (categorySelect.value === '') {
                e.preventDefault();
                categorySelect.classList.add('is-invalid');
                isValid = false;
            } else {
                categorySelect.classList.remove('is-invalid');
            }

            if (!isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } else {
                if (itemNameSelect.value === '__add_new__' || itemNameSelect.value.startsWith('new_')) {
                    itemNameInput.value = itemNameSelect.value;
                }
                if (categorySelect.value === '__add_new__' || categorySelect.value.startsWith('new_')) {
                    categoryInput.value = categorySelect.value;
                }
            }
        });

        itemNameInput.addEventListener('input', function() {
            if (this.value) {
                itemNameSelect.classList.remove('is-invalid');
            }
        });

        categoryInput.addEventListener('input', function() {
            if (this.value) {
                categorySelect.classList.remove('is-invalid');
            }
        });
    });
</script>
@endsection