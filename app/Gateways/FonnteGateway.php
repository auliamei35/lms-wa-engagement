<?php

namespace App\Gateways;

use Illuminate\Support\Facades\Http;

class FonnteGateway implements WhatsAppGatewayInterface
{
    public function sendMessage(string $to, string $message): bool
    {
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $to,
            'message' => $message,
            'countryCode' => '62', // Standar Indonesia
        ]);

        return $response->successful();
    }
}