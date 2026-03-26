@extends('layouts.app')

@section('title', 'Edit Purchase Order')

@section('content')
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle"></i> Editing a Purchase Order will recalculate the total amount based on the items.
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <h2><i class="bi bi-file-earmark-check"></i> Edit Purchase Order</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('purchase-orders.update', $purchaseOrder) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">PO Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('po_number') is-invalid @enderror" 
                           name="po_number" value="{{ old('po_number', $purchaseOrder->po_number) }}" required>
                    @error('po_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">PR Reference <span class="text-danger">*</span></label>
                    <select class="form-select @error('purchase_request_id') is-invalid @enderror" 
                            name="purchase_request_id" required>
                        <option value="">Select PR</option>
                        @foreach($purchaseRequests as $pr)
                            <option value="{{ $pr->id }}" 
                                {{ old('purchase_request_id', $purchaseOrder->purchase_request_id) == $pr->id ? 'selected' : '' }}>
                                {{ $pr->pr_number }}
                            </option>
                        @endforeach
                    </select>
                    @error('purchase_request_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Supplier <span class="text-danger">*</span></label>
                    <select class="form-select @error('supplier_id') is-invalid @enderror" 
                            name="supplier_id" required>
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" 
                                {{ old('supplier_id', $purchaseOrder->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Order Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('order_date') is-invalid @enderror" 
                           name="order_date" value="{{ old('order_date', $purchaseOrder->order_date->format('Y-m-d')) }}" required>
                    @error('order_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Expected Date</label>
                    <input type="date" class="form-control @error('expected_date') is-invalid @enderror" 
                           name="expected_date" value="{{ old('expected_date', $purchaseOrder->expected_date?->format('Y-m-d')) }}">
                    @error('expected_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="draft" {{ old('status', $purchaseOrder->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ old('status', $purchaseOrder->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $purchaseOrder->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="completed" {{ old('status', $purchaseOrder->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $purchaseOrder->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              name="notes" rows="2">{{ old('notes', $purchaseOrder->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>
            <h5>Items <span class="text-muted">(Edit, add, or remove items)</span></h5>
            <div id="itemsContainer">
                @foreach($purchaseOrder->details as $index => $detail)
                <div class="row item-row mb-2">
                    <div class="col-md-4">
                        <select class="form-select @error('items.'.$index.'.item_id') is-invalid @enderror" 
                                name="items[{{ $index }}][item_id]" required>
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('items.'.$index.'.item_id', $detail->item_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->code }} - {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('items.'.$index.'.item_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control @error('items.'.$index.'.quantity') is-invalid @enderror" 
                               name="items[{{ $index }}][quantity]" 
                               value="{{ old('items.'.$index.'.quantity', $detail->quantity) }}" 
                               placeholder="Quantity" min="1" required>
                        @error('items.'.$index.'.quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control @error('items.'.$index.'.price') is-invalid @enderror" 
                               name="items[{{ $index }}][price]" 
                               value="{{ old('items.'.$index.'.price', $detail->price) }}" 
                               placeholder="Price" min="0" step="0.01" required>
                        @error('items.'.$index.'.price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-1">
                        @if($loop->first)
                            <button type="button" class="btn btn-success btn-sm w-100" onclick="addItem()">+</button>
                        @else
                            <button type="button" class="btn btn-danger btn-sm w-100" onclick="this.closest('.item-row').remove()">-</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Purchase Order</button>
            <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
        </form>
    </div>
</div>

@section('scripts')
<script>
let itemIndex = {{ $purchaseOrder->details->count() }};

function addItem() {
    const container = document.getElementById('itemsContainer');
    const newRow = `
        <div class="row item-row mb-2">
            <div class="col-md-4">
                <select class="form-select" name="items[${itemIndex}][item_id]" required>
                    <option value="">Select Item</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="items[${itemIndex}][quantity]" placeholder="Quantity" min="1" required>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="items[${itemIndex}][price]" placeholder="Price" min="0" step="0.01" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="this.closest('.item-row').remove()">-</button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newRow);
    itemIndex++;
}
</script>
@endsection
@endsection
