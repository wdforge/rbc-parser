<?php

namespace Generic\Traits;

/**
 * Trait Events
 * @package Generic\Traits
 */
trait Events
{
    /**
     * @var array
     */
    protected $events = [];

    /**
     * выполнение обработки события
     *
     * @param string $event
     * @param array $arguments
     * @return array
     */
    public function trigger(string $event, array $arguments = [])
    {
        $results = [];
        if (isset($this->events[$event]) && !empty($this->events[$event])) {
            foreach ($this->events[$event] as $callback) {
                $results[] = call_user_func_array($callback, $arguments);
            }
        }
        return $results;
    }


    /**
     * добавление подписки на событие
     *
     * @param string $event
     * @param callable|null $callback
     */
    public function attach(string $event, callable $callback = null)
    {
        if (!isset($this->events[$event])) {
            $this->events[$event] = [];
        }

        $this->events[$event] = $callback;
    }

}