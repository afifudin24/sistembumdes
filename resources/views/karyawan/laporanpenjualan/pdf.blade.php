<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
        }

        .info {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <h2 class="text-center">Laporan Penjualan</h2>

    <div class="info">
        <strong>Periode:</strong>
        @php
            $tanggalMulai = request('tanggal_mulai');
            $tanggalAkhir = request('tanggal_akhir');
        @endphp

        @if($tanggalMulai && $tanggalAkhir)
            {{ \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}
        @else
            Keseluruhan
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Usaha</th>
                <th>Metode Bayar</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPendapatan = 0; @endphp
            @foreach($laporan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->usaha->nama_usaha }}</td>
                    <td>{{ $item->metode_pembayaran }}</td>
                    <td class="text-right">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                </tr>
                @php $totalPendapatan += $item->total_harga; @endphp
            @endforeach
        </tbody>
    </table>

    <p class="total">Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>

    <p><em>Laporan ini dihasilkan secara otomatis oleh sistem.</em></p>

</body>
</html>
