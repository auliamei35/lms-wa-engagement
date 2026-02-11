<?php

namespace App\Jobs;

use App\Gateways\WhatsAppGatewayInterface;
use App\Models\MessageLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $to,
        public string $message,
        public ?string $urlFile = null
    ) {}

    public function handle(WhatsAppGatewayInterface $gateway): void
    {
        // 1. Kirim pesan menggunakan nomor asli ($this->to) dan sertakan $urlFile
        $status = $gateway->sendMessage($this->to, $this->message, $this->urlFile);
        
        // 2. Logging untuk memantau hasil di terminal/file log
        if ($status) {
            Log::info("WhatsApp Terkirim ke: " . $this->maskPhone($this->to));
        } else {
            Log::error("WhatsApp GAGAL dikirim ke: " . $this->maskPhone($this->to));
        }

        // 3. Update status di database.
        // Jika targetnya adalah Grup, kita sesuaikan pencariannya.
        $searchPhone = (str_contains($this->to, '@g.us')) ? 'GROUP: Kelompok Maxy' : $this->maskPhone($this->to);

        MessageLog::where('recipient_phone', $searchPhone)
                  ->where('content', 'like', '%' . substr($this->message, 0, 20) . '%')
                  ->update(['status' => $status ? 'success' : 'failed']);
    }

    /**
     * Helper untuk menyesuaikan pencarian nomor di tabel MessageLog
     */
    private function maskPhone(string $phone)
    {
        if (str_contains($phone, '@g.us')) return $phone;
        if (strlen($phone) < 8) return $phone;
        return substr($phone, 0, 5) . '******' . substr($phone, -2);
    }
}