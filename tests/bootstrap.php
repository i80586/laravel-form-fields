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
        private array $errors = [
            'withError' => true,
            'post.text' => true
        ];

        public function has(string $name): bool
        {
            return isset($this->errors[$name]);
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