<!DOCTYPE html>
<html>
<head>
    <title>Laporan User</title>
    <style>
        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #000; padding:6px; }
    </style>
</head>
<body onload="window.print()">

<h3 align="center">Laporan Data User</h3>

@if($start && $end)
    <p class="text-center">
        Periode: {{ $start }} s/d {{ $end }}
    </p>
@endif

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
    </tr>
    @foreach ($data as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->email }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
