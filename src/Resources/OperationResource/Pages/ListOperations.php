<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource;

class ListOperations extends ListRecords
{
    protected static string $resource = OperationResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(fn () => __('filament-one-time-operations::filament-one-time-operations.tabs.all')),
            'async' => Tab::make(fn () => __('filament-one-time-operations::filament-one-time-operations.tabs.async'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('dispatched', 'async')),
            'sync' => Tab::make(fn () => __('filament-one-time-operations::filament-one-time-operations.tabs.sync'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('dispatched', 'sync')),
        ];
    }
}
