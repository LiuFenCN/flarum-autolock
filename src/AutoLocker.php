<?php

namespace Acolasi\Autolock;

use Carbon\Carbon;
use Flarum\Discussion\Discussion;
use Flarum\Settings\SettingsRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * AutoLock service: locks discussions inactive for N days.
 */
class AutoLocker
{
    public function __construct(
        protected SettingsRepositoryInterface $settings,
        protected ?LoggerInterface $logger = null
    ) {
    }

    /**
     * Find and lock all discussions that have been inactive for the configured number of days.
     *
     * @return int Number of discussions locked.
     */
    public function lockInactiveDiscussions(): int
    {
        $enabled = (bool) $this->settings->get('acolasiAutolock.enabled', false);
        $days = (int) $this->settings->get('acolasiAutolock.days', 90);
        $ignoreSticky = (bool) $this->settings->get('acolasiAutolock.ignoreSticky', true);

        if (!$enabled || $days <= 0) {
            return 0;
        }

        $cutoff = Carbon::now()->subDays($days);

        $query = Discussion::query()
            ->where('is_locked', false)
            ->where('last_posted_at', '<', $cutoff)
            ->where('comment_count', '>', 1); // Skip empty/single-post discussions

        if ($ignoreSticky) {
            $query->where('is_sticky', false);
        }

        $discussions = $query->get();

        $count = 0;
        foreach ($discussions as $discussion) {
            if ($discussion->is_locked) {
                continue; // Race condition safety
            }

            $discussion->is_locked = true;
            $discussion->save();
            $count++;
        }

        if ($count > 0 && $this->logger) {
            $this->logger->info("[AutoLock] Locked {$count} discussion(s) inactive for more than {$days} days.");
        }

        return $count;
    }
}
