<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations\Resources;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource\Pages;
use JeffersonGoncalves\Filament\OneTimeOperations\Support\Utils;
use TimoKoerber\LaravelOneTimeOperations\Models\Operation;

class OperationResource extends Resource
{
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->description()
                    ->columns()
                    ->schema([
                        Infolists\Components\IconEntry::make('name')
                            ->label(__('filament-one-time-operations::filament-one-time-operations.column.name')),
                        Infolists\Components\TextEntry::make('dispatched')
                            ->label(__('filament-one-time-operations::filament-one-time-operations.column.dispatched'))
                            ->formatStateUsing(fn(Operation $resource) => __('filament-one-time-operations::filament-one-time-operations.value.' . $resource->dispatched)),
                        Infolists\Components\TextEntry::make('processed_at')
                            ->label(__('filament-one-time-operations::filament-one-time-operations.column.processed_at')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('name')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.name'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('dispatched')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.dispatched'))
                    ->formatStateUsing(fn(Operation $resource) => __('filament-one-time-operations::filament-one-time-operations.value.' . $resource->dispatched)),
                Tables\Columns\TextColumn::make('processed_at')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.processed_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOperations::route('/'),
            'view' => Pages\ViewOperation::route('/{record}'),
        ];
    }

    public static function getCluster(): ?string
    {
        return Utils::getResourceCluster() ?? static::$cluster;
    }

    public static function getModel(): string
    {
        return Utils::getOperationModel();
    }

    public static function getModelLabel(): string
    {
        return __('filament-one-time-operations::filament-one-time-operations.resource.label.operation');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-one-time-operations::filament-one-time-operations.resource.label.operations');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Utils::isResourceNavigationRegistered();
    }

    public static function getNavigationGroup(): ?string
    {
        if (Utils::isResourceNavigationGroupEnabled()) {
            return __('filament-one-time-operations::filament-one-time-operations.nav.group');
        }

        return '';
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-one-time-operations::filament-one-time-operations.nav.operation.label');
    }

    public static function getNavigationIcon(): string
    {
        return __('filament-one-time-operations::filament-one-time-operations.nav.operation.icon');
    }

    public static function getNavigationSort(): ?int
    {
        return Utils::getResourceNavigationSort();
    }

    public static function getSlug(): string
    {
        return Utils::getResourceSlug();
    }

    public static function getNavigationBadge(): ?string
    {
        if (Utils::isResourceNavigationBadgeEnabled()) {
            return strval(static::getEloquentQuery()->count());
        }

        return null;
    }
}
