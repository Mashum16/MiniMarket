<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produk</title>
    <style>
        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #000; padding:6px; }
    </style>
</head>
<body onload="window.print()">

<h3 align="center">Laporan Data Produk</h3>

@if($start && $end)
    <p class="text-center">
        Periode: {{ $start }} s/d {{ $end }}
    </p>
@endif

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
    </tr>
    @foreach ($data as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->category->name ?? '-' }}</td>
        <td>{{ number_format($row->price) }}</td>
        <td>{{ $row->stock }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
