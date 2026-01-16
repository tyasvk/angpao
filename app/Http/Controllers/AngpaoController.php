<?php

namespace App\Http\Controllers;

use App\Models\Angpao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AngpaoController extends Controller
{
    /**
     * Dashboard Admin (Ringkasan)
     */
public function index()
{
    // Mengambil statistik dari database
    $stats = [
        'total' => \App\Models\Angpao::count(),
        'dist' => 'Rp ' . number_format(\App\Models\Angpao::where('status', 'claimed')->sum('amount'), 0, ',', '.'),
        'claimed' => \App\Models\Angpao::where('status', 'claimed')->count(),
        'active' => \App\Models\Angpao::where('status', 'active')->count(),
    ];

    // Mengambil 10 klaim terbaru beserta data user yang klaim
    $recentClaims = \App\Models\Angpao::with('user') // Pastikan ada relasi 'user' di model Angpao
        ->where('status', 'claimed')
        ->orderBy('claimed_at', 'desc')
        ->limit(10)
        ->get();

    return \Inertia\Inertia::render('Admin/Dashboard', [
        'stats' => $stats,
        'recentClaims' => $recentClaims
    ]);
}

    /**
     * Master Angpao (Daftar Seluruh Voucher)
     */
public function index_master(Request $request)
{
    // Casting ke string untuk menghindari null passing ke frontend
    $search = (string) $request->input('search', '');

    $angpaos = Angpao::query()
        ->when($search, function ($query, $search) {
            $query->where('code', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();

    return Inertia::render('Admin/Angpao/Index', [
        'angpaos' => $angpaos,
        'filters' => [
            'search' => $search
        ]
    ]);
}

    /**
     * Form Rilis Angpao Baru
     */
    public function create()
    {
        return Inertia::render('Admin/Angpao/Create');
    }

    /**
     * Riwayat Klaim
     */
public function history()
{
    // Mengambil data klaim yang sudah sukses (status = claimed)
    $history = \App\Models\Angpao::with('user')
        ->where('status', 'claimed')
        ->orderBy('claimed_at', 'desc')
        ->paginate(10); // Menggunakan pagination agar tidak berat

    return \Inertia\Inertia::render('Admin/Angpao/History', [
        'history' => $history
    ]);
}



    /**
     * Proses Simpan Massal (Multi-Reward)
     */
public function store(Request $request)
{
    $request->validate([
        'prefix' => 'required|string',
        'rewards' => 'required|array|min:1',
        'expires_at' => 'nullable|date',
    ]);

    try {
        \DB::beginTransaction();

        $voucherPool = [];

        // 1. Masukkan semua hadiah ke dalam "Keranjang Pool"
        foreach ($request->rewards as $index => $reward) {
            $imagePath = null;
            if ($request->hasFile("rewards.{$index}.image")) {
                $imagePath = $request->file("rewards.{$index}.image")->store('rewards', 'public');
            }

            $quantity = (int) $reward['quantity'];

            for ($i = 0; $i < $quantity; $i++) {
                $voucherPool[] = [
                    'reward_type' => $reward['type'],
                    'reward_name' => $reward['type'] === 'money' 
                                     ? 'Rp ' . number_format($reward['value'], 0, ',', '.') 
                                     : $reward['value'],
                    'amount' => $reward['type'] === 'money' ? $reward['value'] : 0,
                    'image_path' => $imagePath,
                    'status' => 'active',
                    'expires_at' => $request->expires_at,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // 2. KOCOK HADIAH (Randomize)
        // Kita gunakan shuffle agar urutan hadiah tidak berurutan sesuai input
        shuffle($voucherPool);

        // 3. Simpan ke Database dengan Kode Unik
        foreach ($voucherPool as $data) {
            $data['code'] = \Str::upper($request->prefix . \Str::random(6));
            \App\Models\Angpao::create($data);
        }

        \DB::commit();
        return redirect()->route('admin.angpao.index')->with('success', 'Angpao Berhasil Diacak & Dirilis!');

    } catch (\Exception $e) {
        \DB::rollBack();
        return back()->with('error', 'Gagal: ' . $e->getMessage());
    }
}

    // Hapus Satu Voucher
public function destroy(Angpao $angpao)
{
    $angpao->delete();
    return back()->with('success', 'Voucher berhasil dihapus.');
}

public function processClaim(Request $request)
{
    $request->validate([
        'code' => 'required|string|uppercase',
    ]);

    // Cari voucher berdasarkan kode
    $angpao = \App\Models\Angpao::where('code', $request->code)->first();

    // 1. Validasi Keberadaan
    if (!$angpao) {
        return back()->withErrors(['code' => 'Segel tidak valid atau salah ketik.']);
    }

    // 2. Validasi Status
    if ($angpao->status !== 'active') {
        return back()->withErrors(['code' => 'Voucher ini sudah pernah diklaim atau sudah hangus.']);
    }

    // 3. Proses Berhasil (Update Status)
    // Di sini Anda bisa menambahkan logika pemberian saldo ke user atau barang
    $angpao->update([
        'status' => 'claimed',
        'claimed_at' => now(),
        'claimed_by' => auth()->id() ?? null, // Jika user harus login
    ]);

    return back()->with('success', 'Selamat! Anda mendapatkan: ' . $angpao->reward_name);
}

// Hapus Massal
public function destroyBatch(Request $request)
{
    $request->validate(['ids' => 'required|array']);
    Angpao::whereIn('id', $request->ids)->delete();
    return back()->with('success', count($request->ids) . ' Voucher berhasil dihapus.');
}
}