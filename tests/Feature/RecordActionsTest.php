<?php

use Filament\Facades\Filament;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\ActionsPosition;
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

    expect($table->getActions())->sequence(fn ($action) => $action->toBeInstanceOf(ViewAction::class))
        ->and($table->getActionsPosition())->toBe(ActionsPosition::AfterColumns);
});

it('groups record actions and sets their position from the plugin', function () {
    OneTimeOperationsPlugin::get()
        ->groupRecordActions()
        ->recordActionsPosition(fn () => ActionsPosition::BeforeColumns);

    $table = operationsTable();

    expect($table->getActions())->toHaveCount(1)
        ->and($table->getActions()[0])->toBeInstanceOf(ActionGroup::class)
        ->and($table->getActionsPosition())->toBe(ActionsPosition::BeforeColumns);
});
