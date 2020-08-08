<?php

use Cycle\Schema\Generator;
use Yiisoft\Yii\Cycle\Schema\Provider\FromConveyorSchemaProvider;
use Yiisoft\Yii\Cycle\Schema\Provider\SimpleCacheSchemaProvider;
use Spiral\Database\Driver\SQLite\SQLiteDriver;

$params = [
    'yiisoft/yii-debug' => [
        'enabled' => false,
    ],
    'supportEmail' => 'support@example.com',
    'aliases' => [
        '@root' => dirname(__DIR__),
        '@views' => '@root/views',
        '@resources' => '@root/resources',
        '@src' => '@root/src',
        '@data' => '@root/data',
        '@tests' => '@root/tests',
    ],
    'yiisoft/yii-cycle' => [
        'dbal' => [
            'default' => 'default',
            'aliases' => [],
            'databases' => [
                'default' => ['connection' => 'sqlite']
            ],
            'connections' => [
                'sqlite' => [
                    'driver' => SQLiteDriver::class,
                    'connection' => 'sqlite:@data/db/database.db',
                    'username' => '',
                    'password' => '',
                ],
            ],
        ],
        'schema-providers' => [
            SimpleCacheSchemaProvider::class => [
                'key' => 'cycle-orm-cache-key'
            ],
            FromConveyorSchemaProvider::class => [
                'generators' => [
                    Generator\SyncTables::class,
                ]
            ],
        ],
        'annotated-entity-paths' => [
            '@src/Entity',
        ],
    ],
];

if (isset($_ENV['ENVIRONMENT']) && $_ENV['ENVIRONMENT'] === 'test') {
    return array_merge($params, require 'params-test.php');
}

return $params;
