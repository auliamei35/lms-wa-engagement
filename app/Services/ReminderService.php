<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\MessageLog;
use App\Helpers\PhoneFormatter;
use App\Jobs\SendWhatsAppMessageJob;
use Carbon\Carbon;

class ReminderService
{
    public function __construct()
    {
        // Constructor kosong
    }

    /**
     * Fitur F1: Notifikasi Reminder Tugas (H+1)
     * Dikirim ke nomor pribadi masing-masing
     */
    public function sendTaskReminders()
    {
        $yesterday = Carbon::yesterday()->toDateString();
        $tasks = Task::whereDate('deadline', $yesterday)->get();

        foreach ($tasks as $task) {
            $users = User::all();

            foreach ($users as $user) {
                if (!$user->phone) continue;

                $formattedPhone = PhoneFormatter::format($user->phone);

                $message = "Hai *{$user->name}*, semangat pagi! ☀️\n\n" .
                           "Kami melihat tugas *\"{$task->title}\"* deadline-nya kemarin ({$task->deadline->format('d M Y')}).\n" .
                           "Yuk segera kumpulkan di sini: {$task->link}\n\n" .
                           "Kamu pasti bisa! 🚀\n" .
                           "- Tim Akademik Maxy";

                SendWhatsAppMessageJob::dispatch($formattedPhone, $message);

                MessageLog::create([
                    'recipient_phone' => $this->maskPhone($formattedPhone),
                    'message_type' => 'Task Reminder',
                    'content' => $message,
                    'status' => 'queued',
                ]);
            }
        }
    }

    /**
     * Fitur F2 & F3: Blast Event (Morning Huddle & Friday Funday)
     * Dikirim ke GRUP WhatsApp
     */
    public function sendEventBlast(string $type)
    {
        // ID Grup
        $groupId = "120363406911634253@g.us"; 
        
        $message = $this->getEventContent($type);

        // Logika Video Teaser (Hanya untuk Friday Funday)
        $urlFile = null;
        if ($type === 'Friday Funday') {
            // Menggunakan Direct Link Google Drive yang sudah kita buat
            $urlFile = "https://res.cloudinary.com/dynyiyi97/video/upload/v1770811951/Video_Teaser_Sharing_Friday_Funday-2-2-2_gs91qh.mp4";
        }

        // Kirim ke GRUP (Ditambahkan parameter $urlFile)
        SendWhatsAppMessageJob::dispatch($groupId, $message, $urlFile);

        // Catat di Log Monitoring
        MessageLog::create([
            'recipient_phone' => 'GROUP: Hackathon Batch 21',
            'message_type' => $type,
            'content' => $message . ($urlFile ? " [With Video Teaser]" : ""),
            'status' => 'queued',
        ]);
    }

    private function maskPhone(string $phone)
    {
        if (strlen($phone) < 8) return $phone;
        return substr($phone, 0, 5) . '******' . substr($phone, -2);
    }

    private function getEventContent(string $type)
    {
        return match ($type) {
            'Morning Huddle' => "Selamat pagi Maxians! 🌅\n\n" .
                                "Hari ini kita akan bahas *\"Consistency is key\"* dan sharing project.\n" .
                                "Quote hari ini: _\"Consistency is key.\"_\n\n" .
                                "Join di sini: https://meet.google.com/xyz\n" .
                                "Jangan sampai ketinggalan! 💪",

            'Friday Funday' => "Hai Maxians, akhir pekan sudah di depan mata! 🎉\n\n" .
                               "Yuk kita tutup pekan dengan fun game & sharing seru.\n" .
                               "Link join: https://meet.google.com/abc\n\n" .
                               "Come with good vibes and happy energy! 🍿✨",

            default => "Halo Maxians, ada informasi terbaru untukmu di LMS.",
        };
    }
}