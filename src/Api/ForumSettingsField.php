<?php

namespace Acolasi\Autolock\Api;

use Flarum\Api\Context;
use Flarum\Api\Schema;
use Flarum\Settings\SettingsRepositoryInterface;

class ForumSettingsField
{
    public function __construct(
        protected SettingsRepositoryInterface $settings
    ) {
    }

    public function __invoke(): array
    {
        return [
            Schema\Bool::make('acolasiAutolock.enabled')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (bool) $this->settings->get('autolock_enabled', false)),

            Schema\Number::make('acolasiAutolock.days')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (int) $this->settings->get('autolock_days', 90)),

            Schema\Bool::make('acolasiAutolock.ignoreSticky')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (bool) $this->settings->get('autolock_ignore_sticky', true)),

            Schema\Bool::make('acolasiAutolock.ignoreLocked')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (bool) $this->settings->get('autolock_ignore_locked', true)),
        ];
    }
}
