<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations\Tests\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
use JeffersonGoncalves\Filament\OneTimeOperations\OneTimeOperationsPlugin;

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('test')
            ->path('test')
            ->plugin(OneTimeOperationsPlugin::make());
    }
}
