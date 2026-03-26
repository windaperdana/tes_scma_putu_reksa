@extends('layouts.app')

@section('title', 'Dashboard - Purchasing System')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-database"></i> Master Data
                </h5>
                <p class="card-text">Manage branches, suppliers, and items</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('branches.index') }}" class="btn btn-light">
                        <i class="bi bi-building"></i> Branches
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-light">
                        <i class="bi bi-truck"></i> Suppliers
                    </a>
                    <a href="{{ route('items.index') }}" class="btn btn-light">
                        <i class="bi bi-box-seam"></i> Items
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-text"></i> Purchase Requests
                </h5>
                <p class="card-text">Create and manage purchase requests</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('purchase-requests.index') }}" class="btn btn-light">
                        <i class="bi bi-list"></i> View All
                    </a>
                    <a href="{{ route('purchase-requests.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-circle"></i> Create New
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-check"></i> Purchase Orders
                </h5>
                <p class="card-text">Process purchase orders</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('purchase-orders.index') }}" class="btn btn-light">
                        <i class="bi bi-list"></i> View All
                    </a>
                    <a href="{{ route('purchase-orders.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-circle"></i> Create New
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-arrow-down"></i> Purchase Receipts
                </h5>
                <p class="card-text">Record goods received</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('purchase-receipts.index') }}" class="btn btn-light">
                        <i class="bi bi-list"></i> View All
                    </a>
                    <a href="{{ route('purchase-receipts.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-circle"></i> Create New
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> System Information</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>System:</strong> Purchasing Management System</p>
                <p class="mb-1"><strong>Version:</strong> 1.0.0</p>
                <p class="mb-0"><strong>Framework:</strong> Laravel {{ app()->version() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
