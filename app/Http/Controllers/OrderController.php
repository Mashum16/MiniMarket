<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // ===============================
    // Tampilkan daftar order
    // ===============================
    public function index()
    {
        if (in_array(Auth::user()->role, ['admin', 'staff'])) {
            // ADMIN & STAFF → lihat semua order
            $orders = Orders::with('user')
                            ->latest()
                            ->get();
        } else {
            // USER → hanya order sendiri
            $orders = Orders::where('user_id', auth()->id())
                            ->latest()
                            ->get();
        }

        return view('backend.v_dashboard.orderDashboard', compact('orders'));
    }

    // ===============================
    // Tampilkan detail order
    // ===============================
    public function show($id)
    {
        $order = Orders::with('user', 'items.product')->findOrFail($id);

        // USER biasa hanya boleh lihat order sendiri
        if (
            !in_array(Auth::user()->role, ['admin', 'staff']) &&
            $order->user_id !== auth()->id()
        ) {
            abort(403);
        }

        // ================= AUDIT LOG (VIEW ORDER) =================
        AuditLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'VIEW',
            'table_name'  => 'orders',
            'record_id'   => $order->id,
            'description' => in_array(Auth::user()->role, ['admin', 'staff'])
                ? 'Admin/Staff melihat detail order user ID ' . $order->user_id
                : 'User melihat detail order sendiri',
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
        // ===========================================================

        return view('backend.v_dashboard.orderShow', compact('order'));
    }

    // ===============================
    // Update status order (admin / staff)
    // ===============================
    public function updateStatus(Request $request, $id)
    {
        // 🔒 Pastikan hanya admin & staff
        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            abort(403);
        }

        $order = Orders::findOrFail($id);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // ================= AUDIT LOG (UPDATE STATUS) =================
        AuditLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'UPDATE',
            'table_name'  => 'orders',
            'record_id'   => $order->id,
            'description' => 'Mengubah status order dari ' . $oldStatus . ' menjadi ' . $order->status,
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
        ]);
        // =============================================================

        return back()->with('success', 'Status order berhasil diupdate!');
    }
}
