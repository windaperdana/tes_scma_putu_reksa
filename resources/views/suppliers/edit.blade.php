@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2><i class="bi bi-truck"></i> Edit Supplier</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="code" value="{{ old('code', $supplier->code) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $supplier->name) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Person</label>
                    <input type="text" class="form-control" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $supplier->phone) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $supplier->email) }}">
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
        </form>
    </div>
</div>
@endsection
