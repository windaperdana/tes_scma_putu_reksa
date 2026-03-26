@extends('layouts.app')

@section('title', 'Purchase Order Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-file-earmark-check"></i> Purchase Order Details</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Header Information</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="200">PO Number</th><td><strong>{{ $purchaseOrder->po_number }}</strong></td></tr>
            <tr><th>PR Number</th><td>{{ $purchaseOrder->purchaseRequest->pr_number }}</td></tr>
            <tr><th>Supplier</th><td>{{ $purchaseOrder->supplier->name }}</td></tr>
            <tr><th>Order Date</th><td>{{ $purchaseOrder->order_date->format('d M Y') }}</td></tr>
            <tr><th>Expected Date</th><td>{{ $purchaseOrder->expected_date ? $purchaseOrder->expected_date->format('d M Y') : '-' }}</td></tr>
            <tr><th>Total Amount</th><td><strong>Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</strong></td></tr>
            <tr><th>Status</th><td>
                @if($purchaseOrder->status == 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @elseif($purchaseOrder->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($purchaseOrder->status == 'approved')
                    <span class="badge bg-success">Approved</span>
                @elseif($purchaseOrder->status == 'completed')
                    <span class="badge bg-info">Completed</span>
                @else
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </td></tr>
            <tr><th>Notes</th><td>{{ $purchaseOrder->notes ?? '-' }}</td></tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Items Details</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->item->code }}</td>
                    <td>{{ $detail->item->name }}</td>
                    <td>{{ $detail->quantity }} {{ $detail->item->unit }}</td>
                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-end"><strong>Total:</strong></td>
                    <td><strong>Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
