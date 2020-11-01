<?php

namespace Parser\Handler;

use Iset\App\HttpHandler;
use Iset\Utils\StaticScope;
use Parser\Model\NewsModel;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequest;

class ShortNewsListPage extends HttpHandler
{
  /**
   * @throws \RuntimeException
   * @throws \InvalidArgumentException
   */
  public function __invoke(ServerRequest $request): ResponseInterface
  {
    StaticScope::set('newsList', NewsModel::getAll());

    ob_start();
    include_once __DIR__."/../../templates/shortlist.phtml";
    $content = ob_get_contents();
    ob_clean();

    $response = $this->response->withHeader('Content-Type', 'text/html');
    $response->getBody()
      ->write($content);

    return $response;
  }

}