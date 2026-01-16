<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    protected $fillable = ['key', 'value'];

    public function userIndex()
{
    $settings = Setting::pluck('value', 'key');
    
    return Inertia::render('Angpao/Index', [
        'settings' => $settings,
        'availableRewards' => $availableRewards,
        'myGifts' => $myGifts
    ]);
}
}
