<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman edit konfigurasi Welcome
     */
    public function editWelcome()
    {
        // Ambil semua data setting dan ubah menjadi array (key => value)
        $settings = Setting::whereIn('key', [
            'welcome_title', 
            'welcome_subtitle', 
            'show_prize_pool', 
            'show_my_gifts'
        ])->pluck('value', 'key');

        return Inertia::render('Admin/Settings/Welcome', [
            'settings' => $settings
        ]);
    }

    /**
     * Menyimpan perubahan konfigurasi
     */
    public function updateWelcome(Request $request)
    {
        // Validasi input sederhana
        $data = $request->validate([
            'welcome_title' => 'required|string|max:255',
            'welcome_subtitle' => 'required|string|max:255',
            'show_prize_pool' => 'required|boolean',
            'show_my_gifts' => 'required|boolean',
        ]);

        // Simpan atau Update ke database menggunakan loop
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key], // Cari berdasarkan key
                ['value' => $value] // Simpan nilainya
            );
        }

        return back()->with('success', 'Konfigurasi Istana Berhasil Diperbarui!');
    }
}