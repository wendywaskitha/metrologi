<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            // Navigasi item untuk notifikasi dengan fallback
            Filament::registerNavigationItems([
                NavigationItem::make('Notifikasi UTTP')
                    ->url(fn() => rescue(
                        fn() => route('filament.admin.resources.uttp-notifications.index'),
                        '/admin'
                    ))
                    ->icon('heroicon-o-bell-alert')
                    ->badge(
                        fn() => auth()->user()?->unreadNotifications()
                            ->where('type', 'App\Notifications\UttpExpirationNotification')
                            ->count() ?: null,
                        'warning'
                    ),
            ]);
        });
    }
}
