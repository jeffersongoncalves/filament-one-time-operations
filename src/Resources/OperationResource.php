<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations\Resources;

use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource\Pages\ListOperations;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource\Pages\ViewOperation;
use JeffersonGoncalves\Filament\OneTimeOperations\Support\Utils;
use TimoKoerber\LaravelOneTimeOperations\Models\Operation;

class OperationResource extends Resource
{
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->description()
                    ->columns()
                    ->schema([
                        TextEntry::make('name')
                            ->label(fn () => __('filament-one-time-operations::filament-one-time-operations.column.name')),
                        TextEntry::make('dispatched')
                            ->label(fn () => __('filament-one-time-operations::filament-one-time-operations.column.dispatched'))
                            ->formatStateUsing(fn (Operation $resource) => __('filament-one-time-operations::filament-one-time-operations.values.'.$resource->getAttributeValue('dispatched'))),
                        TextEntry::make('processed_at')
                            ->label(fn () => __('filament-one-time-operations::filament-one-time-operations.column.processed_at')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(fn () => __('filament-one-time-operations::filament-one-time-operations.column.name')),
                TextColumn::make('dispatched')
                    ->label(fn () => __('filament-one-time-operations::filament-one-time-operations.column.dispatched'))
                    ->badge()
                    ->formatStateUsing(fn (Operation $resource) => __('filament-one-time-operations::filament-one-time-operations.values.'.$resource->getAttributeValue('dispatched'))),
                TextColumn::make('processed_at')
                    ->label(fn () => __('filament-one-time-operations::filament-one-time-operations.column.processed_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('dispatched')
                    ->options(fn () => [
                        Operation::DISPATCHED_ASYNC => __('filament-one-time-operations::filament-one-time-operations.values.async'),
                        Operation::DISPATCHED_SYNC => __('filament-one-time-operations::filament-one-time-operations.values.sync'),
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOperations::route('/'),
            'view' => ViewOperation::route('/{record}'),
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
        return Utils::getResourceNavigationIcon();
    }

    public static function getNavigationSort(): ?int
    {
        return Utils::getResourceNavigationSort();
    }

    public static function getSlug(?Panel $panel = null): string
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
