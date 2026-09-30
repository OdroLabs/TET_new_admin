<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Services\NotificationMailer;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $reference = 'TET-MSG-' . strtoupper(Str::random(6));

        $contact = ContactMessage::create([
            'reference' => $reference,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'General Inquiry',
            'message' => $validated['message'],
            'status' => 'unread',
        ]);

        NotificationMailer::notify(
            'contact',
            "New contact message {$contact->reference}: {$contact->subject}",
            'New Contact Message',
            [
                'Reference' => $contact->reference,
                'Name' => $contact->name,
                'Email' => $contact->email,
                'Phone' => $contact->phone,
                'Subject' => $contact->subject,
                'Message' => $contact->message,
            ],
            $contact->email,
        );

        return response()->json([
            'success' => true,
            'reference' => $contact->reference,
            'message' => 'Your message has been received. A TET officer will review it shortly.',
        ], 201);
    }
}