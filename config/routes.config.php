<?php

use FastRoute\RouteCollector;
use Parser\Handler\ShortNewsListPage;
use Parser\Handler\FullNewsPage;

/**
 * настройки проекта
 */
return [
  /**
   * описания роутинга
   */
  'routes' => function (RouteCollector $r) {
    $r->get('/', ShortNewsListPage::class);
    $r->get('/fullNews/{id:\d+}', FullNewsPage::class);
  },

];