<?php

use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\OneTimeOperations\OneTimeOperationsPlugin;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource;

function operationsTable(): Table
{
    Filament::setCurrentPanel(Filament::getPanel('test'));

    return OperationResource::table(Table::make(Mockery::mock(HasTable::class)));
}

it('keeps loose record actions and the default position by default', function () {
    $table = operationsTable();

    expect($table->getRecordActions())->sequence(fn ($action) => $action->toBeInstanceOf(ViewAction::class))
        ->and($table->getRecordActionsPosition())->toBe(RecordActionsPosition::AfterColumns);
});

it('groups record actions and sets their position from the plugin', function () {
    OneTimeOperationsPlugin::get()
        ->groupRecordActions()
        ->recordActionsPosition(fn () => RecordActionsPosition::BeforeColumns);

    $table = operationsTable();

    expect($table->getRecordActions())->toHaveCount(1)
        ->and($table->getRecordActions()[0])->toBeInstanceOf(ActionGroup::class)
        ->and($table->getRecordActionsPosition())->toBe(RecordActionsPosition::BeforeColumns);
});
