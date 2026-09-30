<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>{{ $mailSubject }}</title></head>
<body style="margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;color:#1e293b;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;border:1px solid #e2e8f0;">
        <tr>
            <td style="background:#1A365D;color:#ffffff;padding:20px 24px;border-radius:12px 12px 0 0;">
                <div style="font-size:11px;letter-spacing:2px;text-transform:uppercase;opacity:.7;">Trans Equality Trust · Admin</div>
                <div style="font-size:20px;font-weight:bold;margin-top:6px;">{{ $heading }}</div>
            </td>
        </tr>
        <tr>
            <td style="padding:20px 24px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    @foreach($fields as $label => $value)
                        <tr>
                            <td style="padding:8px 0;border-bottom:1px solid #f1f5f9;width:35%;vertical-align:top;font-size:12px;font-weight:bold;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">{{ $label }}</td>
                            <td style="padding:8px 0;border-bottom:1px solid #f1f5f9;font-size:14px;white-space:pre-line;">{{ ($value === null || $value === '') ? '—' : $value }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 24px;font-size:11px;color:#94a3b8;border-top:1px solid #f1f5f9;">
                Sent automatically by the TET admin panel. Recipients are managed under “Email &amp; SMTP”.
            </td>
        </tr>
    </table>
</body>
</html>
