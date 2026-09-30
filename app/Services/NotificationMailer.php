<?php

namespace App\Services;

use App\Mail\FormSubmissionMail;
use App\Models\MailSetting;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Throwable;

/**
 * Sends admin notification emails using the SMTP settings managed in
 * Admin → Email & SMTP (mail_settings table), not the .env mailer.
 */
class NotificationMailer
{
    /** Build a mailer from the saved SMTP settings. */
    public static function mailer(MailSetting $s): Mailer
    {
        $mailer = Mail::build([
            'transport' => 'smtp',
            'scheme' => $s->encryption === 'ssl' ? 'smtps' : 'smtp',
            'host' => $s->host,
            'port' => $s->port ?: 587,
            'username' => $s->username ?: null,
            'password' => $s->password ?: null,
            'timeout' => 15,
            // "none" = plain connection; "tls" = STARTTLS when the server offers it
            'auto_tls' => $s->encryption !== 'none',
        ]);

        $mailer->alwaysFrom(
            $s->from_address ?: ($s->username ?: config('mail.from.address')),
            $s->from_name ?: config('mail.from.name')
        );

        return $mailer;
    }

    /** Send a raw test message; throws on failure so the admin sees the error. */
    public static function sendTest(MailSetting $s): void
    {
        static::mailer($s)
            ->to($s->to_addresses ?? [])
            ->cc($s->cc_addresses ?? [])
            ->send(new FormSubmissionMail(
                'SMTP test from TET Admin',
                'Test email',
                ['Status' => 'Your SMTP settings are working.', 'Sent at' => now()->toDayDateTimeString()],
            ));
    }

    /**
     * Notify the configured recipients about a form submission.
     * $type: contact | inquiries | donations. Runs after the HTTP response and never throws.
     */
    public static function notify(string $type, string $subject, string $heading, array $fields, ?string $replyTo = null): void
    {
        \Illuminate\Support\defer(function () use ($type, $subject, $heading, $fields, $replyTo) {
            try {
                if (!Schema::hasTable('mail_settings')) return;

                $s = MailSetting::query()->first();
                if (!$s || !$s->is_enabled || !$s->host || empty($s->to_addresses)) return;
                if (!($s->{'notify_' . $type} ?? false)) return;

                $mail = new FormSubmissionMail($subject, $heading, $fields);
                if ($replyTo) $mail->replyTo($replyTo);

                static::mailer($s)
                    ->to($s->to_addresses)
                    ->cc($s->cc_addresses ?? [])
                    ->send($mail);
            } catch (Throwable $e) {
                Log::error("Notification email ({$type}) failed: " . $e->getMessage());
            }
        });
    }
}
