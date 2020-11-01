<?php

namespace Parser\Command;

use Iset\Di\Exception\LoggedException;
use Iset\Utils\Logger;
use Iset\Utils\StaticScope;
use Parser\Model\ListNewsModel;
use Parser\Model\NewsModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

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

  /**
   * Запуск команды
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null
   */
  protected function execute(InputInterface $input, OutputInterface $output): ?int
  {
    $config = StaticScope::get('config');
    $html = $this->connect($config->get('newsUrl'));

    $newsListData = $this->parseNews($html);

    if (!empty($news)) {
      NewsModel::cleanTable();
    }

    foreach ($newsListData as $news) {
      NewsModel::add($news);
    }

    return 0;
  }

  /**
   * Парсинг новостей блока главной страницы
   *
   * @param $html
   * @return false
   */
  protected function parseNews($html)
  {
    $result = [];
    /**
     * Получение списка ссылок на новости
     */
    if (preg_match_all("/<a[^>]+href=([\"']?)([^\\s\"']+)[^>]+class=\"news-feed__item[^>]+\\1/is", $html, $newsUrlList, PREG_SET_ORDER)) {
      foreach (array_column($newsUrlList, '2') as $url) {
        $html = $this->connect($url);
        try {
          $news = $this->parseFullNews($html, $url);
          if (!empty($news)) {
            $result[] = $news;
          }
        } catch (\Exception $e) {
          echo $e->getMessage() . "\r\n";
        }
      }

      return $result;
    }
    return false;
  }

  /**
   * Получение страницы по адресу
   *
   * @param $url
   */
  protected function connect($url)
  {
    $client = new Client();
    $response = $client->get($url);
    return $response->getBody();
  }

  /**
   * Парсинг отдельной новости
   *
   * @param $html
   */
  protected function parseFullNews($html, $url)
  {
    $result = [];

    /**
     * Парсинг заголовка новости
     */
    if (preg_match('/<h1[^>]+>(.*)<\/h1>/si', $html, $title)) {
      $result['title'] = $title[1];
    } else {
      throw new \Exception(sprintf('Неудачный парсинг заголовка новости [%s]', $url));
      return false;
    }

    /**
     * Парсинг картинки новости
     */
    if (preg_match("/<img[^>]+src=([\"']?)([^\\s\"']+)[^>]+class=\"article__main-image__image[^>]+\\1/is", $html, $image)) {
      $result['image'] = $image[2];
    } else {
      throw new \Exception(sprintf('Неудачный парсинг картинки новости [%s]', $url));
    }

    /**
     * Парсинг текста новости
     */
    if (preg_match('/<p>(.*)<\!--\sbody_median/si', $html, $body)) {
      $result['body'] = strip_tags($body[1]);
    } else {
      throw new \Exception(sprintf('Неудачный парсинг текста новости [%s]', $url));
      return false;
    }

    /**
     * Парсинг даты новости
     */
    if (preg_match("/<span[^>]+class=\"article__header__date[^>]+content=\"([A-Za-z0-9-:+]+)[\"]>/is", $html, $date)) {
      $result['date'] = date('Y-m-d', strtotime($date[1]));
    } else {
      throw new \Exception(sprintf('Неудачный парсинг даты новости [%s]', $url));
    }

    return $result;
  }

}