<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReminderService;

class SendTaskReminder extends Command
{
    // Ini adalah perintah yang akan diketik di terminal
    protected $signature = 'app:send-task-reminder';
    protected $description = 'Mengirim reminder tugas yang deadline-nya H-1';

    public function handle(ReminderService $reminderService)
    {
        $this->info('Memulai pengiriman reminder...');
        $reminderService->sendTaskReminders();
        $this->info('Reminder berhasil diproses!');
    }
}