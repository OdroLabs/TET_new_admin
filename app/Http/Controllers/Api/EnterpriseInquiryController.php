<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EnterpriseInquiry;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class EnterpriseInquiryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:product_order,hall_booking',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'item_name' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:1',
            'estimated_total' => 'nullable|numeric',
            'message' => 'nullable|string',
        ]);

        $prefix = $validated['type'] === 'product_order' ? 'TET-ORD-' : 'TET-HAL-';
        $reference = $prefix . strtoupper(Str::random(6));

        $inquiry = EnterpriseInquiry::create([
            'reference' => $reference,
            'type' => $validated['type'],
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? null,
            'item_name' => $validated['item_name'] ?? null,
            'quantity' => $validated['quantity'] ?? 1,
            'estimated_total' => $validated['estimated_total'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'new',
        ]);

        return response()->json([
            'success' => true,
            'reference' => $inquiry->reference,
            'type' => $inquiry->type,
            'message' => 'Your request has been received. A TET representative will contact you shortly.',
        ], 201);
    }
}