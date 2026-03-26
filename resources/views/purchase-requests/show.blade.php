@extends('layouts.app')

@section('title', 'Purchase Request Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-file-earmark-text"></i> Purchase Request Details</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('purchase-requests.edit', $purchaseRequest) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('purchase-requests.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Header Information</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th width="200">PR Number</th><td><strong>{{ $purchaseRequest->pr_number }}</strong></td></tr>
            <tr><th>Branch</th><td>{{ $purchaseRequest->branch->name }}</td></tr>
            <tr><th>Request Date</th><td>{{ $purchaseRequest->request_date->format('d M Y') }}</td></tr>
            <tr><th>Status</th><td>
                @if($purchaseRequest->status == 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @elseif($purchaseRequest->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($purchaseRequest->status == 'approved')
                    <span class="badge bg-success">Approved</span>
                @elseif($purchaseRequest->status == 'rejected')
                    <span class="badge bg-danger">Rejected</span>
                @else
                    <span class="badge bg-info">Completed</span>
                @endif
            </td></tr>
            <tr><th>Notes</th><td>{{ $purchaseRequest->notes ?? '-' }}</td></tr>
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
                    <th>Estimated Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseRequest->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->item->code }}</td>
                    <td>{{ $detail->item->name }}</td>
                    <td>{{ $detail->quantity }} {{ $detail->item->unit }}</td>
                    <td>Rp {{ number_format($detail->estimated_price ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(($detail->estimated_price ?? 0) * $detail->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
