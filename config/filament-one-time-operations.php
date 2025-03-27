<?php

use TimoKoerber\LaravelOneTimeOperations\Models\Operation;

return [
    'operation_resource' => [
        'cluster' => null,
        'model' => Operation::class,
        'should_register_navigation' => true,
        'navigation_badge' => true,
        'navigation_sort' => -1,
        'slug' => 'operations/operation',
    ],
];
