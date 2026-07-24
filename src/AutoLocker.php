<?php

namespace Acolasi\Autolock;

use Flarum\Discussion\Discussion;
use Flarum\Settings\SettingsRepositoryInterface;

/**
 * AutoLock service: locks discussions inactive for N days.
 */
class AutoLocker
{
    public function __construct(
        protected SettingsRepositoryInterface $settings
    ) {
    }

    /**
     * Find and lock all discussions that have been inactive for the configured number of days.
     *
     * @return int Number of discussions locked.
     */
    public function lockInactiveDiscussions(): int
    {
        $enabled = $this->settings->get('autolock_enabled', false);
        $days = (int) $this->settings->get('autolock_days', 90);
        $ignoreSticky = (bool) $this->settings->get('autolock_ignore_sticky', true);
        $ignoreLocked = (bool) $this->settings->get('autolock_ignore_locked', true);

        if (!$enabled || $days <= 0) {
            return 0;
        }

        $cutoff = now()->subDays($days);

        $query = Discussion::query()
            ->whereNull('locked_at')
            ->where('last_posted_at', '<', $cutoff)
            ->where('comment_count', '>', 1); // Skip empty/single-post discussions

        if ($ignoreSticky) {
            $query->where('is_sticky', false);
        }

        if ($ignoreLocked) {
            // Already handled by whereNull('locked_at'), but keep for clarity
        }

        $discussions = $query->get();

        $count = 0;
        foreach ($discussions as $discussion) {
            if ($discussion->locked_at !== null) {
                continue; // Race condition safety
            }

            $discussion->lockAfter(now());
            $discussion->save();
            $count++;
        }

        if ($count > 0) {
            logger()->info("[AutoLock] Locked {$count} discussion(s) inactive for more than {$days} days.");
        }

        return $count;
    }
}
