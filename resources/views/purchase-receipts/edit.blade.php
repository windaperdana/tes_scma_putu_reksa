@extends('layouts.app')

@section('title', 'Edit Purchase Receipt')

@section('content')
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle"></i> 
    <strong>Important:</strong> Editing this receipt will revert old stock changes and apply new ones based on your modifications.
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <h2><i class="bi bi-file-earmark-arrow-down"></i> Edit Purchase Receipt</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('purchase-receipts.update', $purchaseReceipt) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">PB Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('pb_number') is-invalid @enderror" 
                           name="pb_number" value="{{ old('pb_number', $purchaseReceipt->pb_number) }}" required>
                    @error('pb_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">PO Reference <span class="text-danger">*</span></label>
                    <select class="form-select @error('purchase_order_id') is-invalid @enderror" 
                            name="purchase_order_id" required>
                        <option value="">Select PO</option>
                        @foreach($purchaseOrders as $po)
                            <option value="{{ $po->id }}" 
                                {{ old('purchase_order_id', $purchaseReceipt->purchase_order_id) == $po->id ? 'selected' : '' }}>
                                {{ $po->po_number }} - {{ $po->supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('purchase_order_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Receipt Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('receipt_date') is-invalid @enderror" 
                           name="receipt_date" value="{{ old('receipt_date', $purchaseReceipt->receipt_date->format('Y-m-d')) }}" required>
                    @error('receipt_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="draft" {{ old('status', $purchaseReceipt->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="partial" {{ old('status', $purchaseReceipt->status) == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="completed" {{ old('status', $purchaseReceipt->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              name="notes" rows="2">{{ old('notes', $purchaseReceipt->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>
            <h5>Items Received <span class="text-muted">(Edit quantities will update stock accordingly)</span></h5>
            <div id="itemsContainer">
                @foreach($purchaseReceipt->details as $index => $detail)
                <div class="row item-row mb-2">
                    <div class="col-md-5">
                        <select class="form-select @error('items.'.$index.'.item_id') is-invalid @enderror" 
                                name="items[{{ $index }}][item_id]" required>
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('items.'.$index.'.item_id', $detail->item_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->code }} - {{ $item->name }} (Stock: {{ $item->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('items.'.$index.'.item_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control @error('items.'.$index.'.quantity_received') is-invalid @enderror" 
                               name="items[{{ $index }}][quantity_received]" 
                               value="{{ old('items.'.$index.'.quantity_received', $detail->quantity_received) }}" 
                               placeholder="Qty Received" min="1" required>
                        @error('items.'.$index.'.quantity_received')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Original: {{ $detail->quantity_received }}</small>
                    </div>
                    <div class="col-md-3">
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

            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i> 
                <strong>Stock Update Process:</strong>
                <ol class="mb-0 mt-2">
                    <li>Old quantities will be deducted from current stock</li>
                    <li>New quantities will be added to stock</li>
                    <li>Net effect: Stock adjustment = (New Qty - Old Qty)</li>
                </ol>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Receipt & Adjust Stock</button>
            <a href="{{ route('purchase-receipts.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
        </form>
    </div>
</div>

@section('scripts')
<script>
let itemIndex = {{ $purchaseReceipt->details->count() }};

function addItem() {
    const container = document.getElementById('itemsContainer');
    const newRow = `
        <div class="row item-row mb-2">
            <div class="col-md-5">
                <select class="form-select" name="items[${itemIndex}][item_id]" required>
                    <option value="">Select Item</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }} (Stock: {{ $item->stock }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="items[${itemIndex}][quantity_received]" placeholder="Qty Received" min="1" required>
            </div>
            <div class="col-md-3">
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
