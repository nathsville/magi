<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <div style="background-color: #000878; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 20px;">Pesan dari Admin</h1>
        </div>

        <div style="padding: 30px; color: #374151; line-height: 1.6;">
            <h2 style="color: #111827; margin-top: 0;">{{ $judul }}</h2>
            
            <div style="margin-top: 20px; white-space: pre-line;">
                {!! nl2br(e($pesan)) !!}
            </div>

            <div style="margin-top: 30px; padding: 15px; background-color: #eff6ff; border-left: 4px solid #000878; border-radius: 4px;">
                <p style="margin: 0; font-size: 14px; color: #1e3a8a;">
                    <strong>Catatan:</strong> Pesan ini dikirim melalui sistem broadcast aplikasi Stunting. Mohon tidak membalas email ini.
                </p>
            </div>
        </div>

        <div style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">&copy; {{ date('Y') }} Aplikasi Pencegahan Stunting. All rights reserved.</p>
        </div>
    </div>
</body>
</html>