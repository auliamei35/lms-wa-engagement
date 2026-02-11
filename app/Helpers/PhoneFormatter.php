<?php

namespace App\Helpers;

class PhoneFormatter
{
    /**
     * Menstandarkan format nomor HP ke 62xxxx
     */
    public static function format(string $number): string
    {
        // 1. Hapus semua karakter yang bukan angka (spasi, tanda plus, minus, dll)
        $number = preg_replace('/[^0-9]/', '', $number);

        // 2. Jika nomor diawali dengan '0', ganti menjadi '62'
        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        // 3. Jika nomor diawali dengan '8' (langsung angka provider), tambahkan '62'
        if (str_starts_with($number, '8')) {
            return '62' . $number;
        }

        // 4. Jika nomor sudah diawali '62', langsung kembalikan (jangan ditambah lagi)
        // Ini mencegah terjadinya nomor seperti 6262822...
        return $number;
    }
}