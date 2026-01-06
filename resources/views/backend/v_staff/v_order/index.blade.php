@extends('backend.v_layouts.staff')

@section('title', 'Orders')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Order</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Order ID</th>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'warning text-dark',
                                    'processing' => 'info text-white',
                                    'shipped' => 'primary text-white',
                                    'completed' => 'success text-white',
                                    'cancelled' => 'danger text-white',
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
