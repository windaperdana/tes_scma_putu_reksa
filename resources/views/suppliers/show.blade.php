@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-truck"></i> Supplier Details</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="200">Code</th><td>{{ $supplier->code }}</td></tr>
            <tr><th>Name</th><td>{{ $supplier->name }}</td></tr>
            <tr><th>Address</th><td>{{ $supplier->address ?? '-' }}</td></tr>
            <tr><th>Contact Person</th><td>{{ $supplier->contact_person ?? '-' }}</td></tr>
            <tr><th>Phone</th><td>{{ $supplier->phone ?? '-' }}</td></tr>
            <tr><th>Email</th><td>{{ $supplier->email ?? '-' }}</td></tr>
            <tr><th>Status</th><td>
                @if($supplier->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </td></tr>
        </table>
    </div>
</div>
@endsection
