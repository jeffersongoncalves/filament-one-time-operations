<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations\Resources;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource\Pages;
use JeffersonGoncalves\Filament\OneTimeOperations\Support\Utils;

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
                        Infolists\Components\IconEntry::make('active')
                            ->label(__('filament-one-time-operations::filament-one-time-operations.column.active'))
                            ->boolean(),
                        Infolists\Components\TextEntry::make('name')
                            ->label(__('filament-one-time-operations::filament-one-time-operations.column.name')),
                        Infolists\Components\TextEntry::make('text')
                            ->label(__('filament-one-time-operations::filament-one-time-operations.column.text')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('active')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('text')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.text'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.image'))
                    ->disk(config('one-time-operations.disk')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament-one-time-operations::filament-one-time-operations.column.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhatsappAgents::route('/'),
            'view' => Pages\ViewWhatsappAgent::route('/{record}'),
        ];
    }

    public static function getCluster(): ?string
    {
        return Utils::getResourceCluster() ?? static::$cluster;
    }

    public static function getModel(): string
    {
        return Utils::getWhatsappAgentModel();
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
