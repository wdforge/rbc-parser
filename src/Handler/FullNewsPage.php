<?php

namespace Parser\Handler;

use Iset\Utils\StaticScope;
use Parser\Model\NewsModel;
use Psr\Http\Message\ResponseInterface;
use Iset\App\HttpHandler;
use Zend\Diactoros\ServerRequest;

class FullNewsPage extends HttpHandler
{
  /**
   *
   * @throws \RuntimeException
   * @throws \InvalidArgumentException
   */
  public function __invoke(ServerRequest $request): ResponseInterface
  {
    $params = $request->getAttributes();
    $news = NewsModel::getById($params['id']);
    StaticScope::set('news', $news);

    ob_start();
    include_once __DIR__."/../../templates/fullnews.phtml";
    $content = ob_get_contents();
    ob_clean();

    $response = $this->response->withHeader('Content-Type', 'text/html');
    $response->getBody()
      ->write($content);

    return $response;
  }

}