<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\RegisterMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(UserRegistered $event)
    {
        Mail::to('racagab581@suggets.com')->send(new RegisterMail());
        // Log::info("event terpanggil, lanjutkan!");
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        //
    }
}
