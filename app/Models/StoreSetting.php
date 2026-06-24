<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'store_name',
        'bank_name',
        'account_number',
        'account_holder',
        'qris_image',
        'contact',
        'address',
    ];

    public static function get(): self
    {
        return self::first() ?? self::create([
            'store_name' => 'XYZ Sport',
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => 'XYZ Sport',
            'contact' => '08123456789',
        ]);
    }
}
