<?php




return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'LA COMANDA LOGGER',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
         // Monolog settings
        'IPlogger' => [
            'name' => 'LA COMANDA LOGGER',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/ip.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // eloquent settings
        'db' => [
           'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'id11739346_la_comanda',
            'username' => 'id11739346_lacomanda',
            'password' => '12345',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

    ],
];
