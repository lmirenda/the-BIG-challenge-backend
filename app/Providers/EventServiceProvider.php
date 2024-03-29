<?php

namespace App\Providers;

use App\Events\DoctorHasResponded;
use App\Events\UserHasRegistered;
use App\Listeners\EmailNewRegisteredUser;
use App\Listeners\SendEmailNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserHasRegistered::class => [
            EmailNewRegisteredUser::class,
        ],
        DoctorHasResponded::class => [
            SendEmailNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
