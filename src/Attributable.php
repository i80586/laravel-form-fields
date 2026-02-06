<?php

namespace i80586\Form;

trait Attributable
{

    protected array $attributes = [];

    public function __call(string $name, array $arguments): static
    {
        $value = count($arguments) > 1 ? implode(',', $arguments) : $arguments[0];
        $this->addAttribute($name, $value);
        return $this;
    }

    protected function addAttribute(string $name, mixed $value = null): static
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    protected function hasAttribute(string $name): bool
    {
        return array_key_exists($name, $this->attributes);
    }

    protected function resetAttributes(): void
    {
        $this->attributes = [];
    }

    protected function convertAttributes(array $attributes): string
    {
        $attributesString = join(' ', array_filter(array_map(function ($key) use ($attributes) {
            $value = $attributes[$key];
            if ($value === null) {
                return $key;
            }
            if (is_bool($value)) {
                return $value ? $key : '';
            }
            return $key . '="' . $this->encodeDoubleQuotes((string)$value) . '"';
        }, array_keys($attributes))));
        if (!empty($attributesString)) {
            $attributesString = ' ' . $attributesString;
        }
        return $attributesString;
    }

    protected function encodeDoubleQuotes(string $value): string
    {
        return str_replace('"', '&quot;', $value);
    }

}