<?php

/**
 * настройки проекта
 */
return [
  /**
   * настройки базы данных
   */
  'console' => [
    'commands' => [
      \Parser\Command\RbcShortNewsParseCommand::class,
      \Parser\Command\RbcFullNewsParseCommand::class
    ],
  ],

];




