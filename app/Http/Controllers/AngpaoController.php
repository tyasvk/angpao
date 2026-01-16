<?php

namespace App\Http\Controllers;

use App\Models\Angpao;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AngpaoController extends Controller
{
    /**
     * Dashboard Admin (Ringkasan)
     * URL: /admin/dashboard
     */
    public function index()
    {
        // Mengambil statistik
        $stats = [
            'total' => Angpao::count(),
            'dist' => 'Rp ' . number_format(Angpao::where('status', 'claimed')->sum('amount'), 0, ',', '.'),
            'claimed' => Angpao::where('status', 'claimed')->count(),
            'active' => Angpao::where('status', 'active')->count(),
        ];

        // Untuk Dashboard, kita ambil 10 klaim terbaru saja menggunakan get()
        // JANGAN gunakan paginate() di sini jika ingin digabung dengan get()
        $recentClaims = Angpao::with('user')
            ->where('status', 'claimed')
            ->orderBy('claimed_at', 'desc')
            ->limit(10)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentClaims' => $recentClaims
        ]);
    }

    /**
     * Master Angpao (Daftar Seluruh Voucher)
     * URL: /admin/angpao
     */
public function index_master(Request $request)
{
    $search = (string) $request->input('search', '');
    $status = (string) $request->input('status', ''); 

    $angpaos = Angpao::query()
        ->when($search, function ($query, $search) {
            $query->where('code', 'like', "%{$search}%");
        })
        ->when($status, function ($query, $status) {
            $query->where('status', $status);
        })
        ->latest()
        ->paginate(50) // Menampilkan 50 data per halaman
        ->withQueryString();

    return Inertia::render('Admin/Angpao/Index', [
        'angpaos' => $angpaos,
        'filters' => [
            'search' => $search,
            'status' => $status
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
        $history = Angpao::with('user')
            ->where('status', 'claimed')
            ->orderBy('claimed_at', 'desc')
            ->paginate(15); 

        return Inertia::render('Admin/Angpao/History', [
            'history' => $history
        ]);
    }

    /**
     * Proses Simpan Massal
     */
    public function store(Request $request)
    {
        $request->validate([
            'prefix' => 'required|string',
            'rewards' => 'required|array|min:1',
            'expires_at' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();
            $voucherPool = [];

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

            shuffle($voucherPool);

            foreach ($voucherPool as $data) {
                $data['code'] = Str::upper($request->prefix . Str::random(6));
                Angpao::create($data);
            }

            DB::commit();
            return redirect()->route('admin.angpao.index')->with('success', 'Angpao Berhasil Diacak!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function destroy(Angpao $angpao)
    {
        $angpao->delete();
        return back()->with('success', 'Voucher berhasil dihapus.');
    }

    public function processClaim(Request $request)
    {
        $request->validate(['code' => 'required|string|uppercase']);
        $angpao = Angpao::where('code', $request->code)->first();

        if (!$angpao) return back()->withErrors(['code' => 'Segel tidak valid.']);
        if ($angpao->status !== 'active') return back()->withErrors(['code' => 'Voucher sudah diklaim.']);

        $angpao->update([
            'status' => 'claimed',
            'claimed_at' => now(),
            'claimed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Selamat! Anda mendapatkan: ' . $angpao->reward_name);
    }

    public function destroyBatch(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Angpao::whereIn('id', $request->ids)->delete();
        return back()->with('success', count($request->ids) . ' Voucher dihapus.');
    }

    // app/Http/Controllers/AngpaoController.php

public function userIndex()
{
    // 1. Ambil hadiah unik yang statusnya masih 'active' (Prize Pool)
    $availableRewards = \App\Models\Angpao::where('status', 'active')
        ->select('reward_name', 'reward_type')
        ->distinct()
        ->get();

    // 2. Ambil hadiah yang sudah diklaim oleh user yang sedang login (My Gifts)
    $myGifts = \App\Models\Angpao::where('claimed_by', auth()->id())
        ->where('status', 'claimed')
        ->latest('claimed_at')
        ->get();

    return \Inertia\Inertia::render('Angpao/Index', [
        'availableRewards' => $availableRewards,
        'myGifts' => $myGifts
    ]);
}

public function welcome()
{
    // Mengambil daftar hadiah unik yang masih tersedia untuk didapatkan
    $availableRewards = \App\Models\Angpao::where('status', 'active')
        ->select('reward_name', 'reward_type')
        ->distinct()
        ->get();

    return \Inertia\Inertia::render('Welcome', [
        'availableRewards' => $availableRewards
    ]);
}
}