<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\NewCommentAdded;
use App\Listeners\NotifyAdminOfNewComment;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewCommentAdded::class => [
            NotifyAdminOfNewComment::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
