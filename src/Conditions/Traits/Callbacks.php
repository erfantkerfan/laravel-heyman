<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Callbacks
{
    public static function conditions()
    {
        return [
            'thisValueShouldAllow' => function ($value) {
                return (bool) $value;
            },
            'thisMethodShouldAllow' => function ($callback, array $parameters = []) {
                return function (...$payload) use ($callback, $parameters) {
                    return (bool) app()->call($callback, array_merge($parameters, ...$payload));
                };
            },

        ];
    }

    public function thisClosureShouldAllow(callable $callback, array $parameters = [])
    {
        return $this->thisMethodShouldAllow($callback, $parameters);
    }
}
