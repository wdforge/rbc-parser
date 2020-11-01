<?php

use Parser\Application;
use Iset\Utils\StaticScope as Scope;

/**
 * @var \Iset\Di\Manager $di
 */
$di = require_once __DIR__ . "/../container.php";

// инициализация приложения
$di->createInstance(Application::class, Scope::get('config'), "application")
  ->init()
  ->run();