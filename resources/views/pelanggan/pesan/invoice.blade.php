<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
</head>
<body>
    <h2>Invoice Transaksi</h2>
    <p>Transaksi ID: {{ $transaksi->transaksi_id }}</p>
    <p>Tanggal: {{ $transaksi->tanggal }}</p>
    <p>Metode Pembayaran: {{ $transaksi->metode_pembayaran }}</p>
    <p>Status: {{ $transaksi->status }}</p>
    <hr>
    <h4>Detail Produk:</h4>
    <ul>
        @foreach($details as $item)
            <li>{{ $item->produk->nama_produk }} - {{ $item->kuantitas }} x Rp{{ number_format($item->harga_satuan) }}</li>
        @endforeach
    </ul>
    <hr>
    <p>Total: Rp{{ number_format($transaksi->total_harga) }}</p>
</body>
</html>
