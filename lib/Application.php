<?php

namespace Generic;

use Generic\Exception\LoggedException;
use Generic\Traits\Events;
use Iset\Utils\ErrorHandler;

/**
 * Class Application
 * @package Generic
 */
abstract class Application extends \Iset\Utils\Config
{
    use Events;

    protected static $_errorManager;

    public static function init()
    {
      //код предстартовой обработки
    }

    /**
     * запуск приложения
     */
    public static function run()
    {
        static::init();

        try {
            if (static::getConfig('isHookError')) {
                static::$_errorManager = new ErrorHandler();
                static::$_errorManager->init();
            }

            Router::init();
            $result = Router::route();

        } catch (\Exception $e) {
            throw new $e;
        }

        // здесь поидее должен быть эвент для передачи видовой модели (но не в этой реализации)
        echo json_encode($result);
        exit;
    }

}