<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class OrderController extends Controller
{
    // Tampilkan semua order user
    public function index()
    {
        $orders = Orders::where('user_id', auth()->id())->get();
        return view('backend.v_dashboard.orderDashboard', compact('orders'));
    }

    // Tampilkan detail order
    public function show($id)
    {
        $order = Orders::with('items.product')->findOrFail($id);

        // pastikan user hanya bisa lihat order sendiri
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    // Opsional: update status order (hanya admin/staff)
    public function updateStatus(Request $request, $id)
    {
        $order = Orders::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Status order berhasil diupdate!');
    }
}
