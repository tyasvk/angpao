<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angpao; // Pastikan Model Angpao sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AngpaoController extends Controller
{
    /**
     * Menampilkan halaman form rilis angpao.
     */
    public function create()
    {
        return Inertia::render('Admin/Angpao/Create');
    }

    /**
     * Memproses rilis angpao massal.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'prefix'      => 'required|string|max:15',
            'amount'      => 'required|numeric|min:100', // Minimal Rp 100
            'quantity'    => 'required|integer|min:1|max:100', // Maks 100 sekali rilis
            'expires_at'  => 'nullable|date|after:today',
        ]);

        try {
            DB::beginTransaction();

            $createdCount = 0;
            $vouchers = [];

            // 2. Loop berdasarkan jumlah quantity
            for ($i = 0; $i < $request->quantity; $i++) {
                $code = $this->generateUniqueCode($request->prefix);

                $vouchers[] = [
                    'code'        => $code,
                    'amount'      => $request->amount,
                    'expires_at'  => $request->expires_at,
                    'status'      => 'active',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            // 3. Masukkan ke database secara massal (Bulk Insert)
            Angpao::insert($vouchers);

            DB::commit();

            return redirect()->route('admin.angpao.index')->with('success', $request->quantity . ' Voucher Angpao berhasil diterbitkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Logika untuk menghasilkan kode unik dengan Prefix.
     */
    private function generateUniqueCode($prefix)
    {
        $isUnique = false;
        $code = '';

        while (!$isUnique) {
            // Gabungkan Prefix + 6 karakter acak (huruf besar & angka)
            $randomString = Str::upper(Str::random(6));
            $code = $prefix . $randomString;

            // Cek apakah kode sudah ada di database
            $exists = Angpao::where('code', $code)->exists();
            if (!$exists) {
                $isUnique = true;
            }
        }

        return $code;
    }

    public function history()
{
    $history = Angpao::with('user')
        ->where('status', 'claimed')
        ->orderBy('claimed_at', 'desc')
        ->paginate(10);

    // Statistik Ringkasan
    $stats = [
        'total_claimed' => Angpao::where('status', 'claimed')->count(),
        'total_amount'  => Angpao::where('status', 'claimed')->sum('amount'),
    ];

    return Inertia::render('Admin/Angpao/History', [
        'history' => $history,
        'stats'   => $stats
    ]);
}
}