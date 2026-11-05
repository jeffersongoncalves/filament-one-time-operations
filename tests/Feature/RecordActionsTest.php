<?php

use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\OneTimeOperations\OneTimeOperationsPlugin;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource;

function operationsTable(?Table $table = null): Table
{
    Filament::setCurrentPanel(Filament::getPanel('test'));

    return OperationResource::table($table ?? Table::make(Mockery::mock(HasTable::class)));
}

it('keeps loose record actions and the default position by default', function () {
    $table = operationsTable();

    expect($table->getRecordActions())->sequence(fn ($action) => $action->toBeInstanceOf(ViewAction::class))
        ->and($table->getRecordActionsPosition())->toBe(RecordActionsPosition::AfterColumns);
});

it('keeps the table position when the plugin position is null', function () {
    $table = operationsTable(
        Table::make(Mockery::mock(HasTable::class))->recordActionsPosition(RecordActionsPosition::BeforeColumns),
    );

    expect($table->getRecordActionsPosition())->toBe(RecordActionsPosition::BeforeColumns);
});

it('groups record actions and sets their position from the plugin', function () {
    OneTimeOperationsPlugin::get()
        ->groupRecordActions()
        ->recordActionsPosition(fn () => RecordActionsPosition::BeforeColumns);

    $table = operationsTable();

    expect($table->getRecordActions())->toHaveCount(1)
        ->and($group = $table->getRecordActions()[0])->toBeInstanceOf(ActionGroup::class)
        ->and($group->getActions())->sequence(fn ($action) => $action->toBeInstanceOf(ViewAction::class))
        ->and($table->getRecordActionsPosition())->toBe(RecordActionsPosition::BeforeColumns);
});
