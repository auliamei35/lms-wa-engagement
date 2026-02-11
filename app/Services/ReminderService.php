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

                $message = "Halo *{$user->name}*,\n\n";
                $message .= "Kami perhatikan kamu belum mengumpulkan tugas: *{$task->title}*.\n";
                $message .= "Batas pengumpulannya adalah kemarin. Yuk, segera submit di LMS agar progres belajarmu tetap terjaga!\n\n";
                $message .= "Link LMS: https://lms.contoh.com\n";
                $message .= "Semangat!";

                // 1. Masukkan ke Antrean Redis (Tetap pakai nomor asli agar terkirim)
                SendWhatsAppMessageJob::dispatch($formattedPhone, $message);

                // 2. Catat di Log dengan NOMOR TER-MASKING
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
     */
    public function sendEventBlast(string $type)
    {
        $users = User::all();
        $contentTemplate = $this->getEventContent($type);

        foreach ($users as $user) {
            if (!$user->phone) continue;

            $formattedPhone = PhoneFormatter::format($user->phone);
            $message = str_replace('[Nama]', $user->name, $contentTemplate);

            // 1. Masukkan ke Antrean Redis
            SendWhatsAppMessageJob::dispatch($formattedPhone, $message);

            // 2. Catat di Log dengan NOMOR TER-MASKING
            MessageLog::create([
                'recipient_phone' => $this->maskPhone($formattedPhone),
                'message_type' => $type,
                'content' => $message,
                'status' => 'queued',
            ]);
        }
    }

    /**
     * Helper: Masking Nomor Telepon
     * Contoh: 62882******86
     */
    private function maskPhone(string $phone)
    {
        if (strlen($phone) < 8) return $phone;
        return substr($phone, 0, 5) . '******' . substr($phone, -2);
    }

    private function getEventContent(string $type)
    {
        return match ($type) {
            'Morning Huddle' => "Selamat pagi *[Nama]*! ☀️\n\nSiap untuk Morning Huddle hari ini? Yuk gabung sekarang untuk bahas agenda harian kita.\n\nLink: https://zoom.us/j/huddle\n\n_Quote: 'Do your best today!'_",
            'Friday Funday' => "Happy Friday *[Nama]*! 🥳\n\nWaktunya santai sejenak di Friday Funday jam 15:00 nanti. Bakal ada games seru lho!\n\nLink join: https://zoom.us/j/fridayfunday",
            default => "Halo *[Nama]*, ada informasi terbaru untukmu di LMS.",
        };
    }
}