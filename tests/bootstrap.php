<?php

include __DIR__ . '/../vendor/autoload.php';

if (!function_exists('old')) {
    function old($key = null, $default = null)
    {
        return ['with_old' => 'test_value'][$key] ?? $default;
    }
}

if (!class_exists(\View::class)) {

    class ViewErrorBag
    {
        private array $errors = [
            'withError' => 'Test label of error',
            'post.text' => 'Post text must be specified',
        ];

        public function has(string $name): bool
        {
            return isset($this->errors[$name]);
        }

        public function first(string $name): ?string
        {
            return $this->errors[$name] ?? null;
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