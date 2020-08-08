<?php

declare(strict_types=1);

use App\Provider\CacheProvider;
use App\Provider\EventDispatcherProvider;
use App\Provider\LoggerProvider;
use App\Provider\RepositoryProvider;
use Yiisoft\Arrays\Modifier\ReverseBlockMerge;
use App\Provider\AuthProvider;

return [
    CacheProvider::class => CacheProvider::class,
    EventDispatcherProvider::class => EventDispatcherProvider::class,
    LoggerProvider::class => LoggerProvider::class,
    RepositoryProvider::class => RepositoryProvider::class,
    ReverseBlockMerge::class => new ReverseBlockMerge(),
    AuthProvider::class => AuthProvider::class,
];
