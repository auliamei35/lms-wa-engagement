<?php

namespace App\Gateways;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteGateway implements WhatsAppGatewayInterface
{
    /**
     * Mengirim pesan WhatsApp melalui API Fonnte
     * Ditambahkan penanganan nama file untuk akurasi pengiriman media
     */
    public function sendMessage(string $to, string $message, ?string $url = null): bool
    {
        $payload = [
            'target'      => $to,
            'message'     => $message,
            'countryCode' => '62',
        ];

        if ($url) {
            $payload['url'] = $url;
            // Menambahkan filename membantu WhatsApp mengenali jenis file (mp4)
            $payload['filename'] = 'teaser_friday_funday'; 
        }

        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->asForm()->post('https://api.fonnte.com/send', $payload);

        // Pantau hasil di storage/logs/laravel.log
        if (!$response->successful()) {
            Log::error("Fonnte API Error: " . $response->body());
        } else {
            Log::info("Fonnte API Success: " . $response->body());
        }

        return $response->successful();
    }
}