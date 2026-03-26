<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['purchaseRequest', 'supplier'])->orderBy('order_date', 'desc')->get();
        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $purchaseRequests = PurchaseRequest::where('status', 'approved')->get();
        $suppliers = Supplier::where('is_active', true)->get();
        $items = Item::where('is_active', true)->get();
        return view('purchase-orders.create', compact('purchaseRequests', 'suppliers', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders|max:50',
            'purchase_request_id' => 'required|exists:purchase_requests,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_date' => 'nullable|date',
            'status' => 'required|in:draft,pending,approved,completed,cancelled',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            $po = PurchaseOrder::create([
                'po_number' => $validated['po_number'],
                'purchase_request_id' => $validated['purchase_request_id'],
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'expected_date' => $validated['expected_date'] ?? null,
                'total_amount' => $totalAmount,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                PurchaseOrderDetail::create([
                    'purchase_order_id' => $po->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['purchaseRequest', 'supplier', 'details.item']);
        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('details');
        $purchaseRequests = PurchaseRequest::where('status', 'approved')->get();
        $suppliers = Supplier::where('is_active', true)->get();
        $items = Item::where('is_active', true)->get();
        return view('purchase-orders.edit', compact('purchaseOrder', 'purchaseRequests', 'suppliers', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'po_number' => 'required|max:50|unique:purchase_orders,po_number,' . $purchaseOrder->id,
            'purchase_request_id' => 'required|exists:purchase_requests,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_date' => 'nullable|date',
            'status' => 'required|in:draft,pending,approved,completed,cancelled',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $purchaseOrder) {
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            $purchaseOrder->update([
                'po_number' => $validated['po_number'],
                'purchase_request_id' => $validated['purchase_request_id'],
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'expected_date' => $validated['expected_date'] ?? null,
                'total_amount' => $totalAmount,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete existing details and recreate
            $purchaseOrder->details()->delete();

            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                PurchaseOrderDetail::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order deleted successfully.');
    }
}
