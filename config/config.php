<?php

/**
 * настройки проекта
 */
return [

    /**
     * логирование
     */
    'logfile' => __DIR__.'/../logs/access-'.date('Y-m-d').'.log',
    'isLogging' => true,

    /**
     * перехват ошибок
     */
    'isHookError' => true,

    /**
     * описания контроллеров
     */
    'controllers' => [
        'index' => \Parser\Controller::class
    ],

    /**
     * описания роутинга
     */
    'routes' => [
        'index' => [
            'index',
        ],
    ],

    /**
     * настройки базы данных
     */
    'database' => [
      'user' => 'root',
      'pass' => 'root',
      'connect' => 'mysql:host=127.0.0.1;port=8989;dbname=test;charset=utf8'
    ],

    /**
     * настройки базы данных
     */
    'console' => [
      'commands' => [
        \Parser\Command\RbcShortNewsParseCommand::class,
        \Parser\Command\RbcFullNewsParseCommand::class
      ],
    ],


    'application' => [
      'pipelines' => function (\Parser\Application $app): void {
      },
      'class' => \Parser\Application::class,

      'di' => [
        'invokables' => [
        ],
        'factories' => [
          \Parser\Command\RbcShortNewsParseCommand::class => \Parser\Command\Factory\RbcShortNewsParserCommandFactory::class,
          \Parser\Command\RbcFullNewsParseCommand::class => \Parser\Command\Factory\RbcFullNewsParseCommandFactory::class
        ],
      ],
    ],
];




