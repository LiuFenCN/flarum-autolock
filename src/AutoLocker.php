<?php

namespace Acolasi\Autolock;

use Flarum\Discussion\Discussion;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Scheduled task that runs hourly to auto-lock old discussions.
 */
class AutoLocker implements ShouldQueue
{
    public function __construct(
        protected SettingsRepositoryInterface $settings
    ) {
    }

    public function handle(): void
    {
        $enabled = $this->settings->get('acolasi-autolock.enabled', false);
        $days = (int) $this->settings->get('acolasi-autolock.days', 30);
        $ignoreSticky = (bool) $this->settings->get('acolasi-autolock.ignore_sticky', true);
        $ignoreLocked = (bool) $this->settings->get('acolasi-autolock.ignore_locked', true);

        if (!$enabled || $days <= 0) {
            return;
        }

        $cutoff = now()->subDays($days);

        $query = Discussion::query()
            ->whereNull('locked_at')
            ->where('last_posted_at', '<', $cutoff)
            ->where('comment_count', '>', 1); // Skip empty/single-post discussions

        if ($ignoreSticky) {
            $query->where('is_sticky', false);
        }

        // Find discussions to lock
        $discussions = $query->get();

        $count = 0;
        foreach ($discussions as $discussion) {
            // Double-check it's not already locked (race condition safety)
            if ($discussion->locked_at !== null) {
                continue;
            }

            $discussion->lockAfter(now());
            $discussion->save();
            $count++;
        }

        if ($count > 0) {
            logger()->info("[AutoLock] Locked {$count} discussion(s) inactive for more than {$days} days.");
        }
    }
}
