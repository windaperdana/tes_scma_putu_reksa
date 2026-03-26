<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;
use App\Models\Branch;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseRequests = PurchaseRequest::with('branch')->orderBy('request_date', 'desc')->get();
        return view('purchase-requests.index', compact('purchaseRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        $items = Item::where('is_active', true)->get();
        return view('purchase-requests.create', compact('branches', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pr_number' => 'required|unique:purchase_requests|max:50',
            'branch_id' => 'required|exists:branches,id',
            'request_date' => 'required|date',
            'status' => 'required|in:draft,pending,approved,rejected,completed',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.estimated_price' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $pr = PurchaseRequest::create([
                'pr_number' => $validated['pr_number'],
                'branch_id' => $validated['branch_id'],
                'request_date' => $validated['request_date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                PurchaseRequestDetail::create([
                    'purchase_request_id' => $pr->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'estimated_price' => $item['estimated_price'] ?? null,
                ]);
            }
        });

        return redirect()->route('purchase-requests.index')
            ->with('success', 'Purchase Request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load(['branch', 'details.item']);
        return view('purchase-requests.show', compact('purchaseRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load('details');
        $branches = Branch::where('is_active', true)->get();
        $items = Item::where('is_active', true)->get();
        return view('purchase-requests.edit', compact('purchaseRequest', 'branches', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseRequest $purchaseRequest)
    {
        $validated = $request->validate([
            'pr_number' => 'required|max:50|unique:purchase_requests,pr_number,' . $purchaseRequest->id,
            'branch_id' => 'required|exists:branches,id',
            'request_date' => 'required|date',
            'status' => 'required|in:draft,pending,approved,rejected,completed',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.estimated_price' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $purchaseRequest) {
            $purchaseRequest->update([
                'pr_number' => $validated['pr_number'],
                'branch_id' => $validated['branch_id'],
                'request_date' => $validated['request_date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete existing details and recreate
            $purchaseRequest->details()->delete();

            foreach ($validated['items'] as $item) {
                PurchaseRequestDetail::create([
                    'purchase_request_id' => $purchaseRequest->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'estimated_price' => $item['estimated_price'] ?? null,
                ]);
            }
        });

        return redirect()->route('purchase-requests.index')
            ->with('success', 'Purchase Request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->delete();

        return redirect()->route('purchase-requests.index')
            ->with('success', 'Purchase Request deleted successfully.');
    }
}
