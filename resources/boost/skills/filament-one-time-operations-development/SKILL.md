---
name: filament-one-time-operations-development
description: Build and work with Filament One Time Operations plugin features, including the operations resource, list/view pages, configuration options, and integration with timokoerber/laravel-one-time-operations.
---

# Filament One Time Operations Development

## When to use this skill

Use this skill when:
- Adding a one-time operations management interface to a Filament panel
- Configuring the operations resource (navigation, clustering, model)
- Creating or tracking one-time data migrations and maintenance scripts
- Customizing the operations list or view pages
- Extending the resource with additional functionality
- Troubleshooting operations that fail to appear or execute

## Requirements

- PHP 8.2+
- Laravel 11.0+
- Filament 5.0
- `timokoerber/laravel-one-time-operations` ^1.4

## Installation

```bash
composer require jeffersongoncalves/filament-one-time-operations
```

### Publish config

```bash
php artisan vendor:publish --tag=filament-one-time-operations-config
```

## Configuration

### Register the Plugin

```php
use JeffersonGoncalves\Filament\OneTimeOperations\OneTimeOperationsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OneTimeOperationsPlugin::make(),
        ]);
}
```

### Config File (`filament-one-time-operations.php`)

```php
use TimoKoerber\LaravelOneTimeOperations\Models\Operation;

return [
    'operation_resource' => [
        'cluster' => null,                              // Resource cluster class (string|null)
        'model' => Operation::class,                    // Eloquent model for operations
        'should_register_navigation' => true,           // Show in navigation
        'navigation_badge' => true,                     // Show count badge
        'navigation_icon' => 'heroicon-o-queue-list',   // Navigation icon
        'navigation_sort' => -1,                        // Navigation sort order
        'slug' => 'settings/operation',                 // URL slug
    ],
];
```

## Architecture

### Namespace

`JeffersonGoncalves\Filament\OneTimeOperations`

### Key Classes

#### OneTimeOperationsPlugin

```php
namespace JeffersonGoncalves\Filament\OneTimeOperations;

use Filament\Contracts\Plugin;
use Filament\Panel;

class OneTimeOperationsPlugin implements Plugin
{
    public static function make(): static;
    public function getId(): string;              // returns 'filament-one-time-operations'
    public function register(Panel $panel): void; // auto-registers OperationResource if not already present
    public function boot(Panel $panel): void;
}
```

The plugin checks if an `OperationResource` is already registered in the panel via `Utils::isResourcePublished()` before adding its own. This allows you to override the resource entirely.

#### OperationResource

```php
namespace JeffersonGoncalves\Filament\OneTimeOperations\Resources;

use Filament\Resources\Resource;
use TimoKoerber\LaravelOneTimeOperations\Models\Operation;

class OperationResource extends Resource
{
    public static function getModel(): string;           // from config
    public static function getCluster(): ?string;        // from config
    public static function getSlug(): string;            // from config
    public static function getNavigationIcon(): string;  // from config
    public static function getNavigationSort(): ?int;    // from config
    public static function getNavigationBadge(): ?string; // operation count
    public static function shouldRegisterNavigation(): bool;
    public static function getNavigationGroup(): ?string;
}
```

**Table columns:**
- `name` -- Operation name
- `dispatched` -- Badge showing async/sync
- `processed_at` -- DateTime, sortable

**Table filters:**
- `dispatched` -- SelectFilter with async/sync options

**Table actions:**
- `ViewAction`

**Infolist:**
- `name`, `dispatched` (formatted), `processed_at`

#### ListOperations

```php
namespace JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource\Pages;

use Filament\Resources\Pages\ListRecords;

class ListOperations extends ListRecords
{
    // Tabs: all, async (dispatched=async), sync (dispatched=sync)
    public function getTabs(): array;
}
```

#### ViewOperation

```php
namespace JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource\Pages;

use Filament\Resources\Pages\ViewRecord;

class ViewOperation extends ViewRecord
{
    protected static string $resource = OperationResource::class;
}
```

#### Utils

```php
namespace JeffersonGoncalves\Filament\OneTimeOperations\Support;

class Utils
{
    public static function isResourcePublished(Panel $panel): bool;
    public static function getResourceCluster(): ?string;
    public static function getOperationModel(): string;
    public static function isResourceNavigationRegistered(): bool;
    public static function isResourceNavigationGroupEnabled(): bool;
    public static function getResourceNavigationSort(): ?int;
    public static function getResourceNavigationIcon(): string;
    public static function getResourceSlug(): string;
    public static function isResourceNavigationBadgeEnabled(): bool;
}
```

All `Utils` methods read from the `filament-one-time-operations` config file, providing a centralized configuration layer for the resource.

## Creating One-Time Operations

Operations are managed by the underlying `timokoerber/laravel-one-time-operations` package:

```bash
php artisan operations:make MyDataMigration
```

This creates a new operation file. Run pending operations with:

```bash
php artisan operations:process
```

The Filament resource automatically displays all operations from the `operations` database table.

## Extending the Resource

### Custom Operation Resource

To fully customize the resource, create your own `OperationResource` and register it in your panel before the plugin:

```php
namespace App\Filament\Resources;

use JeffersonGoncalves\Filament\OneTimeOperations\Resources\OperationResource as BaseResource;

class OperationResource extends BaseResource
{
    // Override table(), infolist(), getPages(), etc.
}
```

Register it in your panel provider so it takes priority:

```php
$panel->resources([
    \App\Filament\Resources\OperationResource::class,
]);
```

The plugin will detect the existing resource and skip auto-registration.

### Custom Model

To use a custom model, update the config:

```php
'operation_resource' => [
    'model' => \App\Models\CustomOperation::class,
],
```

## Troubleshooting

### Resource not appearing in navigation
**Cause**: `should_register_navigation` is set to `false` in config, or the navigation group is disabled.
**Solution**: Set `should_register_navigation` to `true` in `config/filament-one-time-operations.php`.

### Badge not showing count
**Cause**: `navigation_badge` is set to `false` in config.
**Solution**: Set `navigation_badge` to `true`.

### Operations not listed
**Cause**: Operations have not been processed yet, or the model class is misconfigured.
**Solution**: Run `php artisan operations:process` to create records. Verify the `model` config points to the correct Eloquent model.

### Duplicate resource registration
**Cause**: A custom `OperationResource` exists and the plugin also registers its own.
**Solution**: The plugin automatically detects existing resources. Ensure your custom resource class name contains `OperationResource` in its FQCN for detection to work.
