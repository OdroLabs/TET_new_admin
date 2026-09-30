<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Services\NotificationMailer;

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

        NotificationMailer::notify(
            'donations',
            "New donation pledge {$donation->reference}: {$donation->currency} " . number_format((float) $donation->amount, 2),
            'New Donation Pledge',
            [
                'Reference' => $donation->reference,
                'Donor' => $donation->donor_name,
                'Email' => $donation->donor_email,
                'Amount' => $donation->currency . ' ' . number_format((float) $donation->amount, 2),
                'Payment method' => $donation->payment_method === 'card' ? 'Card' : 'Bank transfer',
                'Status' => $donation->status,
            ],
        );

        return response()->json([
            'success' => true,
            'reference' => $donation->reference,
            'amount' => $donation->amount,
            'payment_method' => $donation->payment_method,
            // Stored in settings (dn_bank_*)
            'bank_details' => [
                'bank_name' => Setting::text('dn_bank_name'),
                'account_name' => Setting::text('dn_bank_account_name'),
                'account_number' => Setting::text('dn_bank_account_number'),
                'branch' => Setting::text('dn_bank_branch'),
                'swift_code' => Setting::text('dn_bank_swift'),
            ]
        ], 201);
    }
}