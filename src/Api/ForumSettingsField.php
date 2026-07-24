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
                ->get(fn () => (bool) $this->settings->get('acolasi-autolock.enabled', false)),

            Schema\Number::make('acolasiAutolock.days')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (int) $this->settings->get('acolasi-autolock.days', 30)),

            Schema\Bool::make('acolasiAutolock.ignoreSticky')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (bool) $this->settings->get('acolasi-autolock.ignore_sticky', true)),

            Schema\Bool::make('acolasiAutolock.ignoreLocked')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (bool) $this->settings->get('acolasi-autolock.ignore_locked', true)),
        ];
    }
}
