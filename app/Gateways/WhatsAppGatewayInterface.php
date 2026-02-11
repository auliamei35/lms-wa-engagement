<?php

namespace App\Gateways;

interface WhatsAppGatewayInterface
{
    /**
     * Standar fungsi untuk mengirim pesan WhatsApp
     * @param string $to (Nomor HP tujuan)
     * @param string $message (Isi Pesan)
     * @return bool (Berhasil atau Gagal)
     */
    public function sendMessage(string $to, string $message): bool;
}