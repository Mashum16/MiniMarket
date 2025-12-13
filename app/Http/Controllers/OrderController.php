<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

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

        // ================= AUDIT LOG (VIEW ORDER) =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'VIEW',
            'table_name' => 'orders',
            'record_id'  => $order->id,
            'description'=> 'Melihat detail order',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        // ===========================================================

        return view('orders.show', compact('order'));
    }

    // Update status order (admin / staff)
    public function updateStatus(Request $request, $id)
    {
        $order = Orders::findOrFail($id);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // ================= AUDIT LOG (UPDATE STATUS) =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'UPDATE',
            'table_name' => 'orders',
            'record_id'  => $order->id,
            'description'=> 'Mengubah status order dari ' . $oldStatus . ' menjadi ' . $order->status,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // =============================================================

        return back()->with('success', 'Status order berhasil diupdate!');
    }
}
