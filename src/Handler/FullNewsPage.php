<?php


namespace Parser\Handler;

use Psr\Http\Message\ResponseInterface;
use Iset\App\HttpHandler;

class FullNewsPage extends HttpHandler
{
  /**
   *
   *
   * @throws \RuntimeException
   * @throws \InvalidArgumentException
   */
  public function __invoke(): ResponseInterface
  {
    $response = $this->response->withHeader('Content-Type', 'text/html');
    $response->getBody()
      ->write('<html><head></head><body>Full news Page!</body></html>');

    return $response;
  }

}