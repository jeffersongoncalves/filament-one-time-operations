<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations\Support;

use Filament\Panel;
use TimoKoerber\LaravelOneTimeOperations\Models\Operation;

class Utils
{
    public static function isResourcePublished(Panel $panel): bool
    {
        return str(string: collect(value: $panel->getResources())->values()->join(','))
            ->contains('OperationResource');
    }

    public static function getResourceCluster(): ?string
    {
        return config('filament-one-time-operations.operation_resource.cluster', null);
    }

    public static function getOperationModel(): string
    {
        return config('filament-one-time-operations.operation_resource.model', Operation::class);
    }

    public static function isResourceNavigationRegistered(): bool
    {
        return config('filament-one-time-operations.operation_resource.should_register_navigation', true);
    }

    public static function isResourceNavigationGroupEnabled(): bool
    {
        return config('filament-one-time-operations.operation_resource.navigation_group', true);
    }

    public static function getResourceNavigationSort(): ?int
    {
        return config('filament-one-time-operations.operation_resource.navigation_sort');
    }

    public static function getResourceSlug(): string
    {
        return (string)config('filament-one-time-operations.operation_resource.slug');
    }

    public static function isResourceNavigationBadgeEnabled(): bool
    {
        return config('filament-one-time-operations.operation_resource.navigation_badge', true);
    }
}
