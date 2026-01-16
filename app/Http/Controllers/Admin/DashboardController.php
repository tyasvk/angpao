<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_vouchers' => $vouchers->count(),
                'total_used' => $vouchers->sum('used'),
                'total_amount_idr' => number_format($vouchers->sum(fn($v) => $v->used * $v->amount), 0, ',', '.'),
            ]
        ]);
    }
}