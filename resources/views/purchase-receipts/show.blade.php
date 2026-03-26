@extends('layouts.app')

@section('title', 'Purchase Receipt Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-file-earmark-arrow-down"></i> Purchase Receipt Details</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('purchase-receipts.edit', $purchaseReceipt) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('purchase-receipts.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Header Information</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="200">PB Number</th><td><strong>{{ $purchaseReceipt->pb_number }}</strong></td></tr>
            <tr><th>PO Number</th><td>{{ $purchaseReceipt->purchaseOrder->po_number }}</td></tr>
            <tr><th>Supplier</th><td>{{ $purchaseReceipt->purchaseOrder->supplier->name }}</td></tr>
            <tr><th>Receipt Date</th><td>{{ $purchaseReceipt->receipt_date->format('d M Y') }}</td></tr>
            <tr><th>Status</th><td>
                @if($purchaseReceipt->status == 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @elseif($purchaseReceipt->status == 'partial')
                    <span class="badge bg-warning">Partial</span>
                @else
                    <span class="badge bg-success">Completed</span>
                @endif
            </td></tr>
            <tr><th>Notes</th><td>{{ $purchaseReceipt->notes ?? '-' }}</td></tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Items Received</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Quantity Received</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseReceipt->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->item->code }}</td>
                    <td>{{ $detail->item->name }}</td>
                    <td>{{ $detail->quantity_received }} {{ $detail->item->unit }}</td>
                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->price * $detail->quantity_received, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
