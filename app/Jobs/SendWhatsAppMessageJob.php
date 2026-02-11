<?php

namespace App\Jobs;

use App\Gateways\WhatsAppGatewayInterface;
use App\Models\MessageLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk debugging

class SendWhatsAppMessageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $to,
        public string $message
    ) {}

    public function handle(WhatsAppGatewayInterface $gateway): void
    {
        // 1. Kirim pesan menggunakan nomor asli ($this->to)
        $status = $gateway->sendMessage($this->to, $this->message);
        
        // 2. Logging untuk memantau hasil di terminal/file log
        if ($status) {
            Log::info("WhatsApp Terkirim ke: " . $this->maskPhone($this->to));
        } else {
            Log::error("WhatsApp GAGAL dikirim ke: " . $this->maskPhone($this->to));
        }

        // 3. Update status di database. 
        // Penting: Kita cari berdasarkan nomor yang sudah di-masking karena itu yang tersimpan di DB.
        MessageLog::where('recipient_phone', $this->maskPhone($this->to))
                  ->where('content', $this->message)
                  ->update(['status' => $status ? 'success' : 'failed']);
    }

    /**
     * Helper untuk menyesuaikan pencarian nomor di tabel MessageLog
     */
    private function maskPhone(string $phone)
    {
        if (strlen($phone) < 8) return $phone;
        return substr($phone, 0, 5) . '******' . substr($phone, -2);
    }
}