<?php

namespace App\Gateways;

use Illuminate\Support\Facades\Log;

class FakeWhatsAppGateway implements WhatsAppGatewayInterface
{
    public function sendMessage(string $to, string $message): bool
    {
        // Hanya mencatat di log Laravel, tidak benar-benar mengirim WA
        Log::info("SIMULASI WA TERKIRIM ke $to: $message");
        
        return true; 
    }
}