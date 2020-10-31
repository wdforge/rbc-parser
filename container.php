<?php

declare(strict_types=1);

$loader = require_once __DIR__ . '/vendor/autoload.php';

use Iset\Utils\Config;
use Iset\Di\Manager as Di;
use Iset\Utils\FileList as Files;
use Iset\Utils\StaticScope as Scope;

Scope::set('composer', $loader);

// загрузка конфигурационных файлов приложения
$config = (new Config)
  ->loadConfigs(
    Files::fromPath(__DIR__ . '/config')
  );

// инициализация менеджера зависимостей
$di = (new Di)->init($config);
$config->set('application/di/manager', $di);
$di->set('config', $config);

return $di;