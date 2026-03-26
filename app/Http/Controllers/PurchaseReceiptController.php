<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReceipt;
use App\Models\PurchaseReceiptDetail;
use App\Models\PurchaseOrder;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseReceipts = PurchaseReceipt::with('purchaseOrder')->orderBy('receipt_date', 'desc')->get();
        return view('purchase-receipts.index', compact('purchaseReceipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $purchaseOrders = PurchaseOrder::where('status', 'approved')->get();
        $items = Item::where('is_active', true)->get();
        return view('purchase-receipts.create', compact('purchaseOrders', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pb_number' => 'required|unique:purchase_receipts|max:50',
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'receipt_date' => 'required|date',
            'status' => 'required|in:draft,partial,completed',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity_received' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $pb = PurchaseReceipt::create([
                'pb_number' => $validated['pb_number'],
                'purchase_order_id' => $validated['purchase_order_id'],
                'receipt_date' => $validated['receipt_date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                PurchaseReceiptDetail::create([
                    'purchase_receipt_id' => $pb->id,
                    'item_id' => $item['item_id'],
                    'quantity_received' => $item['quantity_received'],
                    'price' => $item['price'],
                ]);

                // Update item stock
                $itemModel = Item::find($item['item_id']);
                $itemModel->increment('stock', $item['quantity_received']);
            }
        });

        return redirect()->route('purchase-receipts.index')
            ->with('success', 'Purchase Receipt created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseReceipt $purchaseReceipt)
    {
        $purchaseReceipt->load(['purchaseOrder', 'details.item']);
        return view('purchase-receipts.show', compact('purchaseReceipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseReceipt $purchaseReceipt)
    {
        $purchaseReceipt->load('details');
        $purchaseOrders = PurchaseOrder::where('status', 'approved')->get();
        $items = Item::where('is_active', true)->get();
        return view('purchase-receipts.edit', compact('purchaseReceipt', 'purchaseOrders', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseReceipt $purchaseReceipt)
    {
        $validated = $request->validate([
            'pb_number' => 'required|max:50|unique:purchase_receipts,pb_number,' . $purchaseReceipt->id,
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'receipt_date' => 'required|date',
            'status' => 'required|in:draft,partial,completed',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity_received' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $purchaseReceipt) {
            // Revert old stock changes
            foreach ($purchaseReceipt->details as $detail) {
                $itemModel = Item::find($detail->item_id);
                $itemModel->decrement('stock', $detail->quantity_received);
            }

            $purchaseReceipt->update([
                'pb_number' => $validated['pb_number'],
                'purchase_order_id' => $validated['purchase_order_id'],
                'receipt_date' => $validated['receipt_date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete existing details and recreate
            $purchaseReceipt->details()->delete();

            foreach ($validated['items'] as $item) {
                PurchaseReceiptDetail::create([
                    'purchase_receipt_id' => $purchaseReceipt->id,
                    'item_id' => $item['item_id'],
                    'quantity_received' => $item['quantity_received'],
                    'price' => $item['price'],
                ]);

                // Update item stock
                $itemModel = Item::find($item['item_id']);
                $itemModel->increment('stock', $item['quantity_received']);
            }
        });

        return redirect()->route('purchase-receipts.index')
            ->with('success', 'Purchase Receipt updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseReceipt $purchaseReceipt)
    {
        DB::transaction(function () use ($purchaseReceipt) {
            // Revert stock changes
            foreach ($purchaseReceipt->details as $detail) {
                $itemModel = Item::find($detail->item_id);
                $itemModel->decrement('stock', $detail->quantity_received);
            }

            $purchaseReceipt->delete();
        });

        return redirect()->route('purchase-receipts.index')
            ->with('success', 'Purchase Receipt deleted successfully.');
    }
}
