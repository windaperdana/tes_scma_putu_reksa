@extends('layouts.app')

@section('title', 'Purchase Orders')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-file-earmark-check"></i> Purchase Orders</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New PO
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>PR Number</th>
                        <th>Supplier</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrders as $po)
                    <tr>
                        <td><strong>{{ $po->po_number }}</strong></td>
                        <td>{{ $po->purchaseRequest->pr_number }}</td>
                        <td>{{ $po->supplier->name }}</td>
                        <td>{{ $po->order_date->format('d M Y') }}</td>
                        <td>Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @if($po->status == 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @elseif($po->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($po->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($po->status == 'completed')
                                <span class="badge bg-info">Completed</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('purchase-orders.edit', $po) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('purchase-orders.destroy', $po) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="7" class="text-center">No purchase orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
