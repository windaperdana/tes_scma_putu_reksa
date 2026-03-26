@extends('layouts.app')

@section('title', 'Item Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-box-seam"></i> Item Details</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('items.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="200">Code</th><td>{{ $item->code }}</td></tr>
            <tr><th>Name</th><td>{{ $item->name }}</td></tr>
            <tr><th>Description</th><td>{{ $item->description ?? '-' }}</td></tr>
            <tr><th>Unit</th><td>{{ $item->unit }}</td></tr>
            <tr><th>Price</th><td>Rp {{ number_format($item->price, 0, ',', '.') }}</td></tr>
            <tr><th>Stock</th><td>{{ $item->stock }}</td></tr>
            <tr><th>Status</th><td>
                @if($item->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </td></tr>
        </table>
    </div>
</div>
@endsection
