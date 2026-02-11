<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
*/

// Perintah bawaan Laravel
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Automation Schedule (Sesuai Proposal Engagement)
|--------------------------------------------------------------------------
*/

// 1. Reminder Tugas: Setiap hari jam 09:00 pagi
Schedule::command('app:send-task-reminder')
    ->dailyAt('09:00')
    ->timezone('Asia/Jakarta');

// 2. Morning Huddle: Senin s/d Kamis jam 08:30 pagi
Schedule::command('app:send-blast "Morning Huddle"')
    ->days([1, 2, 3, 4]) // 1=Senin, 2=Selasa, 3=Rabu, 4=Kamis
    ->at('08:30')
    ->timezone('Asia/Jakarta');

// 3. Friday Funday: Setiap hari Jumat jam 15:00 sore
Schedule::command('app:send-blast "Friday Funday"')
    ->fridays()
    ->at('15:00')
    ->timezone('Asia/Jakarta');