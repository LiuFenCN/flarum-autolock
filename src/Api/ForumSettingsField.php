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
            Schema\Boolean::make('acolasiAutolock.enabled')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (bool) $this->settings->get('acolasiAutolock.enabled', false)),

            Schema\Number::make('acolasiAutolock.days')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (int) $this->settings->get('acolasiAutolock.days', 90)),

            Schema\Boolean::make('acolasiAutolock.ignoreSticky')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (bool) $this->settings->get('acolasiAutolock.ignoreSticky', true)),

            Schema\Boolean::make('acolasiAutolock.ignoreLocked')
                ->visible(fn (object $model, Context $context) => $context->getActor()->isAdmin())
                ->get(fn () => (bool) $this->settings->get('acolasiAutolock.ignoreLocked', true)),
        ];
    }
}
