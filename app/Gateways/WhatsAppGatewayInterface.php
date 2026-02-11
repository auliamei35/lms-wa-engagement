<?php

namespace App\Gateways;

interface WhatsAppGatewayInterface
{
    /**
     * Standar fungsi untuk mengirim pesan WhatsApp
     * @param string $to (Nomor HP tujuan atau ID Grup)
     * @param string $message (Isi Pesan)
     * @param string|null $url (URL File seperti Video atau Gambar - Opsional)
     * @return bool (Berhasil atau Gagal)
     */
    public function sendMessage(string $to, string $message, ?string $url = null): bool;
}