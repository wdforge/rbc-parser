<?php

namespace Parser;

/**
 * @method \Iset\Di\Manager
 */
class Application extends \Iset\App\HttpApplication
{

  public function init()
  {
//    \Generic\PdoModel::connect(self::getConfig('database'));
    return parent::init();
  }

}