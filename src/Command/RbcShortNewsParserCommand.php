<?php

namespace Parser\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RbcShortNewsParserCommand extends Command
{

  /**
   * Configures the command
   */
  protected function configure()
  {
    $this
      ->setName('rbc-parser:short-news')
      ->setDescription('Парсинг списка новостей из блока');
  }

  protected function execute(InputInterface $input, OutputInterface $output): ?int
  {
    //...
  }

  public function parse($html)
  {
    if (preg_match_all("/<a[^>]+href=([\"']?)([^\\s\"']+)[^>]+class=\"news-feed__item[^>]+\\1/is", $html, $result, PREG_SET_ORDER)) {
      return $result[2];
    }
    return false;
  }
}