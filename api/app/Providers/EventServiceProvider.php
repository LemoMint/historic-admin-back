<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Author;
use App\Models\Category;
use App\Models\Document;
use App\Models\Publication;
use App\Models\PublishingHouse;
use App\Observers\UserObserver;
use App\Observers\AuthorObserver;
use App\Observers\CategoryObserver;
use App\Observers\DocumentObserver;
use App\Observers\PublicationObserver;
use Illuminate\Auth\Events\Registered;
use App\Observers\DocumentUUIDObserver;
use App\Observers\PublishingHouseObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        PublishingHouse::observe(PublishingHouseObserver::class);
        Author::observe(AuthorObserver::class);
        Publication::observe(PublicationObserver::class);
        Document::observe(DocumentUUIDObserver::class);
        Document::observe(DocumentObserver::class);
        User::observe(UserObserver::class);
        Category::observe(CategoryObserver::class);
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