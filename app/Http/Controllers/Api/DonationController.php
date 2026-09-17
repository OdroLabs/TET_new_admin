<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'payment_method' => 'required|string|in:card,bank_transfer',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $reference = 'TET-DON-' . strtoupper(Str::random(6));

        $donation = Donation::create([
            'reference' => $reference,
            'donor_name' => $validated['is_anonymous'] ? 'Anonymous Donor' : ($validated['donor_name'] ?? 'Anonymous Donor'),
            'donor_email' => $validated['donor_email'] ?? null,
            'amount' => $validated['amount'],
            'currency' => 'LKR',
            'payment_method' => $validated['payment_method'],
            'is_anonymous' => $validated['is_anonymous'] ?? false,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'reference' => $donation->reference,
            'amount' => $donation->amount,
            'payment_method' => $donation->payment_method,
            'bank_details' => [
                'bank_name' => 'Commercial Bank of Ceylon',
                'account_name' => 'Trans Equality Trust',
                'account_number' => '8009123456',
                'branch' => 'Colombo Main Branch',
                'swift_code' => 'CCEYLKX',
            ]
        ], 201);
    }
}