<?php

use Doctrine\DBAL\Driver\PDOMySql\Driver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => Driver::class,

                'params' => [
                    'host'     => 'db_test',
                    'port'     => '3306',
                    'user'     => getenv('MYSQL_USER'),
                    'password' => getenv('MYSQL_PASSWORD'),
                    'dbname'   => getenv('MYSQL_DATABASE'),
                ],
            ],
        ],
    ],
];
