@extends('layouts.app')

@section('title', 'Edit Item')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2><i class="bi bi-box-seam"></i> Edit Item</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('items.update', $item) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="code" value="{{ old('code', $item->code) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $item->name) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description', $item->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Unit <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="unit" value="{{ old('unit', $item->unit) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="price" value="{{ old('price', $item->price) }}" min="0" step="0.01" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="stock" value="{{ old('stock', $item->stock) }}" min="0" required>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
        </form>
    </div>
</div>
@endsection
