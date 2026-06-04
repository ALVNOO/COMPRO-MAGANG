<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Permohonan PKL - PT. Telkom Indonesia</title>
<style>
  body { font-family: Arial, sans-serif; font-size: 14px; color: #1a1a1a; line-height: 1.6; margin: 0; padding: 0; background: #f5f5f5; }
  .wrapper { max-width: 680px; margin: 0 auto; background: #ffffff; }
  .header { background: #EE2E24; padding: 28px 36px; }
  .header-logo { font-size: 22px; font-weight: 700; color: #fff; letter-spacing: 1px; }
  .header-sub { font-size: 12px; color: rgba(255,255,255,0.8); margin-top: 4px; }
  .body { padding: 36px; }
  .greeting { margin-bottom: 16px; }
  .body p { margin: 0 0 14px; }
  table.participants { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
  table.participants th { background: #EE2E24; color: #fff; padding: 10px 12px; text-align: left; font-weight: 600; }
  table.participants td { padding: 10px 12px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
  table.participants tr:nth-child(even) td { background: #fef2f2; }
  .cell-no { width: 36px; text-align: center; }
  .name-primary { font-weight: 600; color: #1a1a1a; }
  .name-detail { font-size: 12px; color: #555; margin-top: 2px; }
  .period { font-weight: 600; }
  .attachments { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px 20px; margin: 20px 0; }
  .attachments p { font-weight: 600; margin: 0 0 8px; }
  .attachments ul { margin: 0; padding-left: 20px; }
  .attachments ul li { margin-bottom: 4px; }
  .footer-sig { margin-top: 28px; }
  .footer-sig p { margin: 0 0 4px; }
  .footer { background: #f3f4f6; padding: 18px 36px; font-size: 12px; color: #9ca3af; text-align: center; border-top: 1px solid #e5e7eb; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <div class="header-logo">Telkom Witel Sulbagsel</div>
    <div class="header-sub">PT. Telkom Indonesia (Persero) — Finance & Human Capital SSGS</div>
  </div>

  <div class="body">
    <p class="greeting">Dengan hormat,</p>

    <p>
      Menindaklanjuti pengajuan mahasiswa PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel,
      dengan ini kami ajukan permohonan mahasiswa PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel
      berlokasi di Kantor Telkom Witel Sulbagsel, Jl. Balaikota No.4, Kec. Ujung Pandang, Makassar,
      Sulawesi Selatan. Terlampir nama yang kami ajukan sbb:
    </p>

    <table class="participants">
      <thead>
        <tr>
          <th class="cell-no">NO</th>
          <th>PESERTA</th>
          <th>MENTOR</th>
          <th>PERIODE PKL</th>
          <th>LOKASI PKL</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="cell-no">1.</td>
          <td>
            <div class="name-primary">{{ strtoupper($participantName) }} / NIM. {{ $participantNim }}</div>
            <div class="name-detail">{{ $participantFaculty }}, {{ $participantUniv }}</div>
          </td>
          <td>
            <div class="name-primary">{{ strtoupper($mentorName) }}</div>
            @if($mentorNik !== '-')
            <div class="name-detail">NIK: {{ $mentorNik }}</div>
            @endif
          </td>
          <td>
            <span class="period">{{ $startDate }}<br>s.d. {{ $endDate }}</span>
          </td>
          <td>{{ $divisionName }} – Telkom Witel Sulbagsel</td>
        </tr>
      </tbody>
    </table>

    <div class="attachments">
      <p>Berikut kami lampirkan berkas permohonan mahasiswa berupa :</p>
      <ul>
        <li>Surat Permohonan</li>
        <li>Curriculum Vitae</li>
        <li>Surat Berperilaku Baik dari Kampus</li>
        <li>KTP/KTM</li>
      </ul>
    </div>

    <p>
      Demikian Surat Permohonan PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel ini kami sampaikan.
      Mohon untuk dapat ditindaklanjuti (diijinkan/tidak diijinkan) terkait permohonan PKL yang kami ajukan.
      Atas perhatian bapak/ibu kami ucapkan terima kasih.
    </p>

    <div class="footer-sig">
      <p>Salam hormat,</p>
      <p><strong>Finance &amp; Human Capital SSGS - Telkom Witel Sulbagsel</strong></p>
    </div>
  </div>

  <div class="footer">
    Email ini dikirim secara otomatis melalui Sistem Manajemen Magang Telkom Witel Sulbagsel.
  </div>
</div>
</body>
</html>
