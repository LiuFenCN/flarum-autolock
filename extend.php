<?php

/*
 * AutoLock for Flarum 2.0
 * Automatically lock discussions after N days of inactivity.
 */

use Acolasi\Autolock\AutoLocker;
use Flarum\Extend;

return [
    // Admin settings page
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    // Register the auto-lock scheduler
    (new Extend\Schedule())
        ->hourly(AutoLocker::class),

    // Add settings to the Forum API
    (new Extend\ApiResource(\Flarum\Api\Resource\ForumResource::class))
        ->fields(\Acolasi\Autolock\Api\ForumSettingsField::class),
];
