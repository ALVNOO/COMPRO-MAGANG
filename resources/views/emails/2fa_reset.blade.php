<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset 2FA</title>
<style>
    body { margin: 0; padding: 0; background: #F3F4F6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
    .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
    .header { background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%); padding: 36px 40px; text-align: center; }
    .header-icon { width: 64px; height: 64px; background: rgba(255,255,255,0.15); border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
    .header h1 { margin: 0; color: #fff; font-size: 22px; font-weight: 700; }
    .header p { margin: 6px 0 0; color: rgba(255,255,255,0.85); font-size: 14px; }
    .body { padding: 36px 40px; }
    .greeting { font-size: 16px; color: #111827; font-weight: 600; margin-bottom: 12px; }
    .text { font-size: 14px; color: #4B5563; line-height: 1.7; margin-bottom: 24px; }
    .info-box { background: #FFF7ED; border: 1px solid #FED7AA; border-radius: 10px; padding: 16px 20px; margin-bottom: 28px; }
    .info-box p { margin: 0; font-size: 13px; color: #92400E; line-height: 1.6; }
    .info-box strong { color: #78350F; }
    .btn-wrap { text-align: center; margin-bottom: 28px; }
    .btn { display: inline-block; padding: 14px 36px; background: linear-gradient(135deg, #EE2E24, #C41E1A); color: #fff !important; text-decoration: none; border-radius: 10px; font-size: 15px; font-weight: 700; letter-spacing: 0.3px; }
    .url-box { background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px; word-break: break-all; }
    .url-box p { margin: 0 0 4px; font-size: 11px; color: #9CA3AF; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .url-box span { font-size: 12px; color: #374151; font-family: monospace; }
    .warning-box { background: #FEF2F2; border: 1px solid #FECACA; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px; }
    .warning-box p { margin: 0; font-size: 13px; color: #991B1B; line-height: 1.6; }
    .footer { border-top: 1px solid #E5E7EB; padding: 20px 40px; text-align: center; }
    .footer p { margin: 0; font-size: 12px; color: #9CA3AF; line-height: 1.6; }
</style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="header-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <path d="M9 12l2 2 4-4"/>
            </svg>
        </div>
        <h1>Reset Two-Factor Authentication</h1>
        <p>Sistem Magang PT Telkom Indonesia</p>
    </div>

    <div class="body">
        <p class="greeting">Halo, {{ $user->name ?? $user->email }}!</p>

        <p class="text">
            Kami menerima permintaan untuk mereset Two-Factor Authentication (2FA) pada akun Anda.
            Klik tombol di bawah untuk mereset 2FA dan mengatur ulang aplikasi authenticator Anda.
        </p>

        <div class="info-box">
            <p>
                <strong>Apa yang akan terjadi setelah reset?</strong><br>
                Pengaturan 2FA lama akan dihapus. Anda akan diarahkan ke halaman setup 2FA baru
                untuk melakukan scan QR code dengan aplikasi authenticator Anda.
            </p>
        </div>

        <div class="btn-wrap">
            <a href="{{ $resetUrl }}" class="btn">Reset 2FA Sekarang</a>
        </div>

        <p class="text" style="font-size:13px; color:#6B7280; margin-bottom:12px;">
            Jika tombol di atas tidak berfungsi, salin dan tempelkan URL berikut di browser Anda:
        </p>

        <div class="url-box">
            <p>Link Reset</p>
            <span>{{ $resetUrl }}</span>
        </div>

        <div class="warning-box">
            <p>
                <strong>Perhatian keamanan:</strong><br>
                Link ini hanya berlaku selama <strong>15 menit</strong> dan hanya bisa digunakan sekali.
                Jika Anda tidak meminta reset 2FA, abaikan email ini — akun Anda tetap aman.
            </p>
        </div>
    </div>

    <div class="footer">
        <p>
            Email ini dikirim secara otomatis oleh Sistem Magang PT Telkom Indonesia.<br>
            Jangan balas email ini.
        </p>
    </div>
</div>
</body>
</html>
