@extends('layouts.app')

@section('title', 'Create Supplier')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2><i class="bi bi-truck"></i> Create New Supplier</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           name="code" value="{{ old('code') }}" required>
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Person</label>
                    <input type="text" class="form-control" name="contact_person" value="{{ old('contact_person') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
        </form>
    </div>
</div>
@endsection
