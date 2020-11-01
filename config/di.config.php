<?php

use Parser\Application;
use Parser\ApplicationFactory;
use Parser\Command\RbcShortNewsParseCommand;
use Parser\Command\RbcFullNewsParseCommand;
use Parser\Command\Factory\RbcShortNewsParserCommandFactory;
use Parser\Command\Factory\RbcFullNewsParseCommandFactory;
use Parser\Handler\FullNewsPage;
use Parser\Handler\ShortNewsListPage;
use Iset\App\Factory\HandlerFactory;

/**
 * настройки проекта
 */
return [
  'application' => [
    'pipelines' => function (Application $app): void {
    },
    'class' => Application::class,
    'di' => [
      'invokables' => [
      ],
      'factories' => [
        /**
         * Временное решение через фабрику, в будущем будет фабрика по типу и конфиги модуля
         * после чего данная конструкция будет убрана.
         */
        ShortNewsListPage::class => HandlerFactory::class,
        FullNewsPage::class => HandlerFactory::class,
        Application::class => ApplicationFactory::class,
        RbcShortNewsParseCommand::class => RbcShortNewsParserCommandFactory::class,
        RbcFullNewsParseCommand::class => RbcFullNewsParseCommandFactory::class
      ],
    ],
  ],
];




