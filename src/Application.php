<?php

namespace Parser;

class Application extends \Generic\Application
{
  public static function init() {
    \Iset\Utils\Logger::$logfile = static::getConfig('logfile');
    \Generic\PdoModel::connect(static::getConfig('database'));
  }
}