<?php

require __DIR__ . '/libs/composer/autoload.php';

$adapter = new \Nette\DI\Config\Adapters\NeonAdapter();
$config = $adapter->load(__DIR__ . '/app/config/config.local.neon');

return [
    'paths' => [
        'migrations' => 'resources/migrations'
    ],
    'environments' => [
        "default_migration_table" => "_phinx_log",
        "default_database" => "production",
        "production" => array(
            "adapter" => $config['parameters']['db']['driver'],
            "host" => $config['parameters']['db']['host'],
            "name" => $config['parameters']['db']['database'],
            "user" => $config['parameters']['db']['username'],
            "pass" => $config['parameters']['db']['password']
        )
    ]
];
