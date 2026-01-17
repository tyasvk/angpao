<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function editWelcome()
    {
        // Ambil data setting dan jadikan key-value pair
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

    public function updateWelcome(Request $request)
    {
        $data = $request->validate([
            'welcome_title' => 'required|string|max:255',
            'welcome_subtitle' => 'required|string|max:255',
            'show_prize_pool' => 'required|boolean',
            'show_my_gifts' => 'required|boolean',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Konfigurasi Gerbang Utama Berhasil Diperbarui!');
    }
}