@extends('layouts.app')

@section('title', 'Branch Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-building"></i> Branch Details</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('branches.edit', $branch) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">Code</th>
                <td>{{ $branch->code }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $branch->name }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $branch->address ?? '-' }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $branch->phone ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $branch->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($branch->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $branch->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $branch->updated_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
