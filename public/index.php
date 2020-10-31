<?php
/**
 * Код для вызова API проекта (вызов задач через Gearman)
 */
$di = require_once __DIR__."/../container.php";

/**
 * вызов обработки приложения
 */
\Parser\Application::init($di);
\Parser\Application::run();