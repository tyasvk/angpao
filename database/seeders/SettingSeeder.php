<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'welcome_title',
                'value' => 'Imperial Fortune',
            ],
            [
                'key' => 'welcome_subtitle',
                'value' => 'Fortune Access • Imlek 2026',
            ],
            [
                'key' => 'show_prize_pool',
                'value' => '1', // '1' untuk tampil, '0' untuk sembunyi
            ],
            [
                'key' => 'show_my_gifts',
                'value' => '1', // '1' untuk tampil, '0' untuk sembunyi
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}