<?php

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'migrations',
            'default_environment' => 'development',
            'development' => [
                'adapter' => 'pgsql',
                'host' => 'db',
                'name' => 'postgres',
                'user' => 'postgres',
                'pass' => 'password',
                'port' => '5432',
                'charset' => 'utf8',
            ],
        ],
        'version_order' => 'creation'
    ];
