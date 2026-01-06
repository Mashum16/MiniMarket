<!DOCTYPE html>
<html>
<head>
    <title>Laporan Order</title>
    <style>
        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #000; padding:6px; }
    </style>
</head>
<body onload="window.print()">

<h3 align="center">Laporan Data Order</h3>

@if($start && $end)
    <p class="text-center">
        Periode: {{ $start }} s/d {{ $end }}
    </p>
@endif

<table>
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Total</th>
        <th>Status</th>
    </tr>
    @foreach ($data as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->user->name ?? '-' }}</td>
        <td>{{ number_format($row->total) }}</td>
        <td>{{ ucfirst($row->status) }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
