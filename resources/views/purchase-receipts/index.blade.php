@extends('layouts.app')

@section('title', 'Purchase Receipts')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-file-earmark-arrow-down"></i> Purchase Receipts</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('purchase-receipts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Receipt
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>PB Number</th>
                        <th>PO Number</th>
                        <th>Receipt Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseReceipts as $pb)
                    <tr>
                        <td><strong>{{ $pb->pb_number }}</strong></td>
                        <td>{{ $pb->purchaseOrder->po_number }}</td>
                        <td>{{ $pb->receipt_date->format('d M Y') }}</td>
                        <td>
                            @if($pb->status == 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @elseif($pb->status == 'partial')
                                <span class="badge bg-warning">Partial</span>
                            @else
                                <span class="badge bg-success">Completed</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($pb->notes, 30) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('purchase-receipts.show', $pb) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('purchase-receipts.edit', $pb) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('purchase-receipts.destroy', $pb) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure? This will revert stock changes.')">
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
                        <td colspan="6" class="text-center">No purchase receipts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
