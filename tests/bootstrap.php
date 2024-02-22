<?php

include __DIR__ . '/../vendor/autoload.php';

if (!function_exists('old')) {
    function old($key = null, $default = null)
    {
        return $default;
    }
}

if (!class_exists(\View::class)) {

    class ViewErrorBag
    {
        public function has(): bool
        {
            return false;
        }
    }

    class View
    {
        public static function getShared(): array
        {
            return ['errors' => new ViewErrorBag()];
        }
    }
}