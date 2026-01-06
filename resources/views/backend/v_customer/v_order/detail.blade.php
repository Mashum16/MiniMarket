@extends('backend.v_layouts.customer')

@section('title', 'Detail Order')

@section('content')
<!-- Order Info -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Order</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Kode Order:</strong> ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Nama Pembeli:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Status:</strong>
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
                </p>
                <p><strong>Total:</strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Order Items -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Produk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td>Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->price_at_purchase * $item->qty, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
