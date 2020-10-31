<?php

namespace Parser\Command\Factory;

use Parser\Command\RbcShortNewsParserCommand;

class RbcShortNewsParserCommandFactory extends \Iset\Di\Factory\AbstractFactory 
{

  public function createInstance(\Iset\Utils\IParams $params)
  {
    //....
    return new RbcShortNewsParserCommand('rbc-parser:short-news', $params);

  }
}