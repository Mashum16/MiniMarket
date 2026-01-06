<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Orders;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        return view(
            $role === 'admin'
                ? 'backend.v_admin.v_laporan.index'
                : 'backend.v_staff.v_laporan.index'
        );
    }

    public function print(Request $request)
    {
        $request->validate([
            'type' => 'required|in:users,products,orders',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date'
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;
        $role  = auth()->user()->role;

        // tentukan folder view berdasarkan role
        $viewPath = $role === 'admin'
            ? 'backend.v_admin.v_laporan.'
            : 'backend.v_staff.v_laporan.';

        switch ($request->type) {

            case 'users':
                $query = User::query();

                if ($start && $end) {
                    $query->whereBetween('created_at', [$start, $end]);
                }

                $data = $query->get();
                return view($viewPath.'users', compact('data', 'start', 'end'));

            case 'products':
                $query = Product::with('category');

                if ($start && $end) {
                    $query->whereBetween('created_at', [$start, $end]);
                }

                $data = $query->get();
                return view($viewPath.'products', compact('data', 'start', 'end'));

            case 'orders':
                $query = Orders::with('user');

                if ($start && $end) {
                    $query->whereBetween('created_at', [$start, $end]);
                }

                $data = $query->get();
                return view($viewPath.'orders', compact('data', 'start', 'end'));
        }

        abort(404);
    }
}
