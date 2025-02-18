<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;

class Formatter {
    public static function currency(string|int $amount): string
    {
        return 'Rp. '. number_format($amount, 0, ',', '.');
    }

    public static function phone(string $phone): string
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
       
        if (substr($phone, 0, 1) == '0') {
            $phone = substr($phone, 1);
        }
       
        if (substr($phone, 0, 3) == '+62') {
            $phone = substr($phone, 3);
        }
       
        if (substr($phone, 0, 2) != '62') {
            $phone = '62'.$phone;
        }

        return $phone;
    }
}