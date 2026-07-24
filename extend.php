<?php

/*
 * AutoLock for Flarum 2.0
 * Automatically lock discussions after N days of inactivity.
 */

use Acolasi\Autolock\Console\AutoLockCommand;
use Flarum\Extend;

return [
    // Admin settings page
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    // Register console command + schedule it hourly
    (new Extend\Console())
        ->command(AutoLockCommand::class)
        ->schedule(AutoLockCommand::class, fn ($event) => $event->hourly()),

    // Add settings to the Forum API
    (new Extend\ApiResource(\Flarum\Api\Resource\ForumResource::class))
        ->fields(\Acolasi\Autolock\Api\ForumSettingsField::class),
];
