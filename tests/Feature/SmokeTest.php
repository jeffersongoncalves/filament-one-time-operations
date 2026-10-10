<?php

use JeffersonGoncalves\Filament\OneTimeOperations\OneTimeOperationsPlugin;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource;

it('loads every class it ships', function (string $class) {
    expect(class_exists($class) || interface_exists($class) || trait_exists($class))->toBeTrue();
})->with([
    'JeffersonGoncalves\\Filament\\OneTimeOperations\\OneTimeOperationsPlugin',
    'JeffersonGoncalves\\Filament\\OneTimeOperations\\OneTimeOperationsServiceProvider',
    'JeffersonGoncalves\\Filament\\OneTimeOperations\\Resources\\OperationResource\\Pages\\ListOperations',
    'JeffersonGoncalves\\Filament\\OneTimeOperations\\Resources\\OperationResource\\Pages\\ViewOperation',
    'JeffersonGoncalves\\Filament\\OneTimeOperations\\Resources\\OperationResource',
    'JeffersonGoncalves\\Filament\\OneTimeOperations\\Support\\Utils',
]);

it('registers on a panel', function () {
    $panel = Filament\Facades\Filament::getPanel('test');

    expect($panel->hasPlugin(OneTimeOperationsPlugin::make()->getId()))->toBeTrue()
        ->and($panel->getResources())->toContain(OperationResource::class);
});
