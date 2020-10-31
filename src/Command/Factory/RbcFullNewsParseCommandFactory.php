<?php

namespace Parser\Command\Factory;

use Parser\Command\RbcFullNewsParserCommand;

class RbcFullNewsParseCommandFactory extends \Iset\Di\Factory\AbstractFactory
{
  public function createInstance(\Iset\Utils\IParams $params)
  {
    //....
    return new RbcFullNewsParserCommand('rbc-parser:full-news', $params);

  }
}