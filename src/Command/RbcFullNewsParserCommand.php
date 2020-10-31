<?php
namespace Parser\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RbcFullNewsParserCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('rbc-parser:full-news')
            ->setDescription('')
            ->addArgument(
                'url',
                InputArgument::OPTIONAL,
                'Адрес полной новости'
            );
    }

  protected function execute(InputInterface $input, OutputInterface $output): ?int
  {
    //...
  }

  public function parse($html)
  {
    return false;
  }

  public function getMainImage($html)
  {
    return false;
  }  

  public function getText($html)
  {
   return false;
  }
}