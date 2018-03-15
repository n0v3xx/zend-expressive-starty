<?php

use Monolog\Logger;

return [
    'monolog' => [
        'logger' => [
            'Application\Log' => [
                'channel' => 'App',
                'handlers' => [
                    'stream' => [
                        'class' => \Monolog\Handler\StreamHandler::class,
                        'options' => [
                            'filename'    => 'log/php_http_application.log',
                            'level'       => Logger::DEBUG,
                        ],
                        'formatter' => [
                            'class' => \Monolog\Formatter\LineFormatter::class,
                            'options' => [
                                'format' => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
                            ],
                        ],
                    ],
                    'fire_php' => new \Monolog\Handler\FirePHPHandler(),
                ],
            ],
            'Application\Cli' => [
                'channel' => 'Cli',
                'handlers' => [
                    'stream' => [
                        'class' => \Monolog\Handler\StreamHandler::class,
                        'options' => [
                            'filename'    => 'log/php_cli_application.log',
                            'level'       => Logger::DEBUG,
                        ],
                        'formatter' => [
                            'class' => \Monolog\Formatter\LineFormatter::class,
                            'options' => [
                                'format' => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
                            ],
                        ],
                    ],
                    'fire_php' => new \Monolog\Handler\FirePHPHandler(),
                ],
            ],
            'Application\Error' => [
                'channel' => 'Err',
                'handlers' => [
                    'stream' => [
                        'class' => \Monolog\Handler\StreamHandler::class,
                        'options' => [
                            'filename'    => 'log/php_http_errors.log',
                            'level'       => Logger::WARNING,
                        ],
                    ],
                    'syslog' => [
                        'class' => \Monolog\Handler\SyslogHandler::class,
                        'options' => [
                            'ident'       => 'Application',
                            'facility'    => LOG_USER,
                        ],
                    ],
                    'fire_php' => new \Monolog\Handler\FirePHPHandler(),
                ],
            ],
        ],
    ],
];