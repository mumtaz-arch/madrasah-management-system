<?php

namespace App\Helpers;

class Terbilang
{
    private static $words = [
        '', 'satu', 'dua', 'tiga', 'empat', 'lima',
        'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'
    ];

    public static function make($number)
    {
        $number = abs($number);
        
        if ($number < 12) {
            return self::$words[$number];
        } elseif ($number < 20) {
            return self::$words[$number - 10] . ' belas';
        } elseif ($number < 100) {
            return self::$words[floor($number / 10)] . ' puluh ' . self::$words[$number % 10];
        } elseif ($number < 200) {
            return 'seratus ' . self::make($number - 100);
        } elseif ($number < 1000) {
            return self::$words[floor($number / 100)] . ' ratus ' . self::make($number % 100);
        } elseif ($number < 2000) {
            return 'seribu ' . self::make($number - 1000);
        } elseif ($number < 1000000) {
            return self::make(floor($number / 1000)) . ' ribu ' . self::make($number % 1000);
        } elseif ($number < 1000000000) {
            return self::make(floor($number / 1000000)) . ' juta ' . self::make($number % 1000000);
        } elseif ($number < 1000000000000) {
            return self::make(floor($number / 1000000000)) . ' miliar ' . self::make($number % 1000000000);
        } else {
            return self::make(floor($number / 1000000000000)) . ' triliun ' . self::make($number % 1000000000000);
        }
    }
}
