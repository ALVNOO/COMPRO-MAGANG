<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peserta Magang</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Laporan Peserta Magang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Universitas/Sekolah</th>
                <th>Jurusan</th>
                <th>NIM</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Divisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $row['no'] }}</td>
                    <td>{{ $row['nama'] }}</td>
                    <td>{{ $row['universitas'] }}</td>
                    <td>{{ $row['jurusan'] }}</td>
                    <td>{{ $row['nim'] }}</td>
                    <td>{{ $row['tanggal_mulai'] }}</td>
                    <td>{{ $row['tanggal_berakhir'] }}</td>
                    <td>{{ $row['divisi'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 