<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Tables\Enums\RecordActionsPosition;
use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource;
use JeffersonGoncalves\Filament\OneTimeOperations\Support\Utils;

class OneTimeOperationsPlugin implements Plugin
{
    use EvaluatesClosures;

    protected bool|Closure $groupRecordActions = false;

    protected RecordActionsPosition|Closure|null $recordActionsPosition = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        $plugin = filament()->getCurrentOrDefaultPanel()?->getPlugins()['filament-one-time-operations'] ?? null;

        return $plugin instanceof static ? $plugin : null;
    }

    public function getId(): string
    {
        return 'filament-one-time-operations';
    }

    public function register(Panel $panel): void
    {
        if (! Utils::isResourcePublished($panel)) {
            $panel->resources([OperationResource::class]);
        }
    }

    public function boot(Panel $panel): void {}

    public function groupRecordActions(bool|Closure $condition = true): static
    {
        $this->groupRecordActions = $condition;

        return $this;
    }

    public function shouldGroupRecordActions(): bool
    {
        return (bool) $this->evaluate($this->groupRecordActions);
    }

    public function recordActionsPosition(RecordActionsPosition|Closure|null $position): static
    {
        $this->recordActionsPosition = $position;

        return $this;
    }

    public function getRecordActionsPosition(): ?RecordActionsPosition
    {
        return $this->evaluate($this->recordActionsPosition);
    }
}
