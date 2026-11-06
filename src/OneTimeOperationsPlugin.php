<?php

namespace JeffersonGoncalves\Filament\OneTimeOperations;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Tables\Enums\ActionsPosition;
use JeffersonGoncalves\Filament\OneTimeOperations\Support\Utils;

class OneTimeOperationsPlugin implements Plugin
{
    use EvaluatesClosures;

    protected bool|Closure $groupRecordActions = false;

    protected ActionsPosition|Closure|null $recordActionsPosition = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        $plugin = filament()->getCurrentPanel()?->getPlugins()['filament-one-time-operations'] ?? null;

        return $plugin instanceof static ? $plugin : null;
    }

    public function getId(): string
    {
        return 'filament-one-time-operations';
    }

    public function register(Panel $panel): void
    {
        if (! Utils::isResourcePublished($panel)) {
            $panel->resources([Resources\OperationResource::class]);
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

    public function recordActionsPosition(ActionsPosition|Closure|null $position): static
    {
        $this->recordActionsPosition = $position;

        return $this;
    }

    public function getRecordActionsPosition(): ?ActionsPosition
    {
        return $this->evaluate($this->recordActionsPosition);
    }
}
