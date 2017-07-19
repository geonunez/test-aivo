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
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Facebook
        'facebook' => [
            'app_id' => '643803342496337',
            // A secret persisted in the repository?
            // Yes I know this is a bad practice, but it's only a test =P.
            'app_secret' => '26141daa4290f6f1ae3b5587d414550b'
        ]
    ],
];
