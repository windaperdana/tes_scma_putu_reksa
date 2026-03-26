@extends('layouts.app')

@section('title', 'Create Purchase Request')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2><i class="bi bi-file-earmark-text"></i> Create New Purchase Request</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('purchase-requests.store') }}" method="POST" id="prForm">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">PR Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="pr_number" value="{{ old('pr_number') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Branch <span class="text-danger">*</span></label>
                    <select class="form-select" name="branch_id" required>
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Request Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="request_date" value="{{ old('request_date', date('Y-m-d')) }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="status" required>
                        <option value="draft">Draft</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                    </select>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <hr>
            <h5>Items</h5>
            <div id="itemsContainer">
                <div class="row item-row mb-2">
                    <div class="col-md-5">
                        <select class="form-select" name="items[0][item_id]" required>
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="items[0][quantity]" placeholder="Quantity" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="items[0][estimated_price]" placeholder="Est. Price" min="0" step="0.01">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-success btn-sm w-100" onclick="addItem()">+</button>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
            <a href="{{ route('purchase-requests.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
        </form>
    </div>
</div>

@section('scripts')
<script>
let itemIndex = 1;
function addItem() {
    const container = document.getElementById('itemsContainer');
    const newRow = `
        <div class="row item-row mb-2">
            <div class="col-md-5">
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
            <div class="col-md-3">
                <input type="number" class="form-control" name="items[${itemIndex}][estimated_price]" placeholder="Est. Price" min="0" step="0.01">
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
