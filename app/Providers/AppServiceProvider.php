<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*
         * Ubah FakeWhatsAppGateway ke FonnteGateway untuk mengirim pesan asli.
         */
        $this->app->bind(
            \App\Gateways\WhatsAppGatewayInterface::class, 
            \App\Gateways\FonnteGateway::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}