@extends('layouts.app')

@section('title', 'Purchase Requests')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-file-earmark-text"></i> Purchase Requests</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('purchase-requests.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New PR
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>PR Number</th>
                        <th>Branch</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseRequests as $pr)
                    <tr>
                        <td><strong>{{ $pr->pr_number }}</strong></td>
                        <td>{{ $pr->branch->name }}</td>
                        <td>{{ $pr->request_date->format('d M Y') }}</td>
                        <td>
                            @if($pr->status == 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @elseif($pr->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($pr->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($pr->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-info">Completed</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($pr->notes, 30) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('purchase-requests.show', $pr) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('purchase-requests.edit', $pr) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('purchase-requests.destroy', $pr) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="6" class="text-center">No purchase requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
