<?php

use Parser\Command\RbcShortNewsParseCommand;
use Parser\Command\Factory\RbcShortNewsParserCommandFactory;
use Parser\Handler\FullNewsPage;
use Parser\Handler\ShortNewsListPage;
use Iset\App\Factory\HandlerFactory;
use Iset\App\Factory\HttpApplicationFactory;
use Iset\App\HttpApplication;

/**
 * настройки проекта
 */
return [
  'application' => [
    'pipelines' => function (HttpApplication $app): void {
    },
    'class' => HttpApplication::class,
    'di' => [
      'invokables' => [
      ],
      'factories' => [
        /**
         * Временное решение через фабрики, в будущем будет фабрика по типу и конфиги модуля
         * после чего данная конструкция будет убрана.
         */
        ShortNewsListPage::class => HandlerFactory::class,
        FullNewsPage::class => HandlerFactory::class,
        HttpApplication::class => HttpApplicationFactory::class,
        RbcShortNewsParseCommand::class => RbcShortNewsParserCommandFactory::class
      ],
    ],
  ],
];




