<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #ee2e24;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 5px 5px;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #ee2e24;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Selamat {{ $name }}!</h2>
    </div>
    
    <div class="content">
        <p>Kepada Yth. <strong>{{ $name }}</strong>,</p>
        
        <p>Dengan hormat,</p>
        
        <p>
            Kami dengan bangga mengabarkan bahwa pengajuan magang Anda di <strong>{{ $divisi }}</strong> PT. Pos Indonesia (Persero) <strong>telah diterima</strong>.
        </p>
        
        <p>
            Terlampir dalam email ini adalah <strong>Surat Penerimaan Magang</strong> yang berisi informasi resmi mengenai penerimaan Anda sebagai peserta magang.
        </p>
        
        <p>
            Surat ini dapat Anda download dan gunakan sesuai kebutuhan.
        </p>
        
        <p>Selamat bergabung dengan keluarga besar PT. Pos Indonesia!</p>
        
        <p>Salam,<br>
        <strong>Tim HR PT. Pos Indonesia (Persero)</strong></p>
    </div>
    
    <div class="footer">
        <p>PT. Pos Indonesia (Persero)</p>
        <p>Kantor Pusat PT Pos Indonesia (Persero)<br>
        Jl. Cilaki No. 73 - Bandung 40115</p>
    </div>
</body>
</html>
