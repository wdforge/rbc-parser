<?php

namespace Generic;

use Generic\Exception\LoggedException;
use Generic\Exception\NotFoundClass;
use Generic\Exception\NotFoundMethod;
use Generic\Exception\NotFoundRoute;

/**
 * Class Router
 */
class Router extends \Iset\Utils\Config
{
    /**
     * @var array
     */
    protected static $_routes = [];

    /**
     * @return array
     */
    public static function getRoutes()
    {
        return static::$_routes;
    }

    /**
     *
     */
    public static function init()
    {
        $routes = static::getConfig('routes');
        $routes = isset($routes) ? $routes : [];
        static::$_routes = static::mergeArray(static::$_routes, $routes);
    }

    /**
     * Запись маршрута
     *
     * @param string $key
     * @param $value
     * @return bool|void
     */
    public static function push($controller, $action)
    {
        if (!isset(static::$_routes[$controller]) || !is_array(static::$_routes[$controller])) {
            static::$_routes[$controller] = [];
        }

        static::$_routes[$controller][] = $action;
        return true;
    }

    /**
     * Получение маршрутов контроллера
     *
     * @param string $key
     * @return mixed|null
     */
    public static function getControllerRoute(string $controller)
    {
        return isset(static::$_routes[$controller]) ? static::$_routes[$controller] : null;
    }

    /**
     * получение экземпляра контроллера
     *
     * @param string $controller
     */
    public static function getController(string $controller)
    {
        $controllers = static::getConfig('controllers');

        if (in_array($controller, array_keys($controllers))) {
            $classController = $controllers[$controller];
            if (class_exists($classController)) {
                return new $classController;
            } else {
                echo 2;
                exit;
                throw new NotFoundClass($classController);
            }
        } else {
            throw new NotFoundRoute($controller);
        }

        return null;
    }

    /**
     * Получение маршрутов контроллера
     *
     * @param string $key
     * @return mixed|null
     */
    public static function has(string $controller = '', string $action = '')
    {
        if (!empty($controller) && !empty(!$action)) {
            return isset(static::$_routes[$controller][$action]);
        }
        if (!empty($controller)) {
            return isset(static::$_routes[$controller]);
        }

        return in_array($action, array_values(static::$_routes));
    }

    /**
     * Определение контроллера и экшена
     * запуск экшена
     *
     */
    public static function route()
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new LoggedException('Route is not running by SAPI');
        }

        $urlParts = explode('/', $_SERVER['REQUEST_URI']);
        $controller = empty($urlParts[1]) ? 'index' : $urlParts[1];
        $action = empty($urlParts[2]) ? 'index' : $urlParts[2];

        $controllerInstance = static::getController($controller);

        if (!method_exists($controllerInstance, $action)) {
            throw new NotFoundMethod(get_class($controllerInstance) . '::' . $action);
        }

        if (static::has($controller, $action)) {
            try {
                return call_user_func_array(
                    [
                        $controllerInstance, $action
                    ], []
                );
            } catch (LoggedException $e) {
                throw $e;
            }
        }

        return null;
    }
}