<?php


namespace Parser\Handler;

use Iset\App\HttpHandler;
use Psr\Http\Message\ResponseInterface;

class ShortNewsListPage extends HttpHandler
{
  /**
   * @throws \RuntimeException
   * @throws \InvalidArgumentException
   */
  public function __invoke(): ResponseInterface
  {
    $response = $this->response->withHeader('Content-Type', 'text/html');
    $response->getBody()
      ->write('<html><head></head><body>Short News List Page!</body></html>');

    return $response;
  }

}