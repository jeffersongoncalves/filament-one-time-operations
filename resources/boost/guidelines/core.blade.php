## Filament One Time Operations

Filament plugin that provides an admin interface for managing one-time operations. Built on top of `timokoerber/laravel-one-time-operations`.

### Installation

@verbatim
<code-snippet name="Install the plugin" lang="bash">
composer require jeffersongoncalves/filament-one-time-operations
</code-snippet>
@endverbatim

@verbatim
<code-snippet name="Publish config file" lang="bash">
php artisan vendor:publish --tag=filament-one-time-operations-config
</code-snippet>
@endverbatim

### Register Plugin

@verbatim
<code-snippet name="Register in PanelProvider" lang="php">
use JeffersonGoncalves\Filament\OneTimeOperations\OneTimeOperationsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OneTimeOperationsPlugin::make(),
        ]);
}
</code-snippet>
@endverbatim

### Configuration

@verbatim
<code-snippet name="Config options (filament-one-time-operations.php)" lang="php">
return [
    'operation_resource' => [
        'cluster' => null,
        'model' => \TimoKoerber\LaravelOneTimeOperations\Models\Operation::class,
        'should_register_navigation' => true,
        'navigation_badge' => true,
        'navigation_icon' => 'heroicon-o-queue-list',
        'navigation_sort' => -1,
        'slug' => 'settings/operation',
    ],
];
</code-snippet>
@endverbatim

### Features
- Admin interface for viewing and tracking one-time operations
- List page with tabs for All, Async, and Sync operations
- View page for operation details (name, dispatched type, processed_at)
- Configurable navigation (icon, sort, badge, group, slug)
- Support for custom Operation model
- Support for resource clusters
- Navigation badge showing operation count
- Filters by dispatch type (async/sync)

### Architecture
- **Namespace**: `JeffersonGoncalves\Filament\OneTimeOperations`
- **Plugin class**: `OneTimeOperationsPlugin` implements `Filament\Contracts\Plugin`
- **Resource**: `OperationResource` extends `Filament\Resources\Resource`
- **Pages**: `ListOperations` (with tabs), `ViewOperation`
- **Support**: `Utils` class for config-driven resource customization
- **Model**: `TimoKoerber\LaravelOneTimeOperations\Models\Operation`

### Best Practices
- Publish the config file to customize navigation and resource behavior
- Use the `cluster` config option to group with other settings resources
- The plugin auto-registers the resource unless an `OperationResource` is already registered in the panel
- Use `navigation_badge` to show pending operations count at a glance
