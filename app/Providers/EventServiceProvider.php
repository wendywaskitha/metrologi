<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\BroadcastNotificationListener;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Illuminate\Notifications\Events\NotificationSent' => [
            BroadcastNotificationListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
