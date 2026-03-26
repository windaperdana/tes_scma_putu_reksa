@extends('layouts.app')

@section('title', 'Branches')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-building"></i> Branches</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('branches.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Branch
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
                    <tr>
                        <td>{{ $branch->code }}</td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->address }}</td>
                        <td>{{ $branch->phone }}</td>
                        <td>{{ $branch->email }}</td>
                        <td>
                            @if($branch->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('branches.show', $branch) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('branches.edit', $branch) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No branches found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
