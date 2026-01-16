<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoucherController extends Controller
{
    // Menampilkan daftar voucher
    public function index()
    {
        return Inertia::render('Admin/Vouchers/Index', [
            'vouchers' => Voucher::latest()->get()
        ]);
    }

    // Menyimpan voucher baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'amount' => 'required|numeric|min:0',
            'limit' => 'required|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        Voucher::create($validated);

        return back()->with('success', 'Voucher baru berhasil dibuat!');
    }

    // Menghapus voucher
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return back()->with('success', 'Voucher berhasil dihapus.');
    }

    // app/Http/Controllers/Admin/VoucherController.php

public function update(Request $request, Voucher $voucher)
{
    $validated = $request->validate([
        'code' => 'required|string|unique:vouchers,code,' . $voucher->id,
        'amount' => 'required|numeric|min:0',
        'limit' => 'required|integer|min:1',
    ]);

    $validated['code'] = strtoupper($validated['code']);
    $voucher->update($validated);

    return back()->with('success', 'Voucher berhasil diperbarui!');
}
}