<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\Filament\OneTimeOperations\Support\Utils;

class OneTimeOperationsPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-one-time-operations';
    }

    public function register(Panel $panel): void
    {
        if (! Utils::isResourcePublished($panel)) {
            $panel->resources([Resources\OperationResource::class]);
        }
    }

    public function boot(Panel $panel): void {}
}
