<?php

namespace Parser;

use Iset\Utils\IParams;
use Iset\App\Factory\HttpApplicationFactory;

/**
 * Class AbstractApplicationFactory
 * @package Iset\App
 */
class ApplicationFactory extends HttpApplicationFactory
{
  public function createInstance(IParams $params, $class = null)
  {
    return parent::createInstance($params, $class);
  }

}