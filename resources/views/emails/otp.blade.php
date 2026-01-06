<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Keamanan Login</title>
    <style>
        /* Reset CSS agar tampilan konsisten di semua email client */
        body { margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f3f4f6; padding-bottom: 40px; }
        .main-container { max-width: 600px; background-color: #ffffff; margin: 0 auto; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background-color: #000878; padding: 30px 20px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; font-weight: bold; letter-spacing: 1px; }
        .content { padding: 40px 30px; text-align: center; color: #374151; }
        .greeting { font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #111827; }
        .text { font-size: 15px; line-height: 1.6; margin-bottom: 20px; }
        
        /* Box Kode OTP yang Keren */
        .otp-box {
            background-color: #eff6ff;
            border: 2px dashed #000878;
            color: #000878;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
            display: inline-block;
            min-width: 200px;
        }

        .warning { font-size: 13px; color: #6b7280; margin-top: 20px; font-style: italic; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
        .footer a { color: #000878; text-decoration: none; }
    </style>
</head>
<body>

    <div class="wrapper">
        <br>
        <div class="main-container">
            
            <div class="header">
                <h1>MaGi App</h1>
            </div>

            <div class="content">
                <p class="greeting">Halo, Pengguna!</p>
                <p class="text">
                    Kami mendeteksi upaya masuk ke akun Anda. Gunakan kode verifikasi di bawah ini untuk melanjutkan:
                </p>

                <div class="otp-box">
                    {{ $code }}
                </div>

                <p class="text">
                    Kode ini hanya berlaku selama <strong>5 menit</strong>.
                </p>

                <p class="warning">
                    ⚠️ Jika Anda tidak merasa melakukan login, mohon abaikan email ini dan jangan berikan kode kepada siapa pun.
                </p>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} MaGi - Sistem Monitoring Stunting.<br>Parepare, Sulawesi Selatan.</p>
                <p>Butuh bantuan? <a href="#">Hubungi Admin</a></p>
            </div>
        </div>
    </div>

</body>
</html>