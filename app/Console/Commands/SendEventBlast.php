<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReminderService;

class SendEventBlast extends Command
{
    // Kita buat signature yang bisa menerima argumen (tipe event)
    protected $signature = 'app:send-blast {type}';
    protected $description = 'Kirim blast WA berdasarkan tipe (Morning Huddle / Friday Funday)';

    public function handle(ReminderService $reminderService)
    {
        $type = $this->argument('type');
        $this->info("Memulai blast untuk: $type");
        
        $reminderService->sendEventBlast($type);
        
        $this->info("Blast $type selesai!");
    }
}