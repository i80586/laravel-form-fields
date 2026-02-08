<?php

namespace i80586\Form\Traits;

trait Attributable
{

    protected array $attributes = [];

    public function __call(string $name, array $arguments): static
    {
        $this->addAttribute($name, $this->prepareAttributeValue($arguments));
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

    protected function appendClass(string $className): static
    {
        if (isset($this->attributes['class'])) {
            $this->attributes['class'] .= ' ' . $className;
        } else {
            $this->attributes['class'] = $className;
        }
        return $this;
    }

    protected function hasClass(string $className): bool
    {
        return isset($this->attributes['class']) && str_contains($this->attributes['class'], $className);
    }

    private function convertAttributes(array $attributes): string
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

    private function encodeDoubleQuotes(string $value): string
    {
        return str_replace('"', '&quot;', $value);
    }

    private function prepareAttributeValue(array $arguments): mixed
    {
        if (!isset($arguments[0])) {
            return null;
        }

        $value = $arguments[0];

        if (!is_array($value)) {
            return count($arguments) === 1 ? $value : implode(' ', $arguments);
        }

        $classes = [];
        foreach ($value as $className => $isEnabled) {
            if (is_int($className)) {
                $className = $isEnabled;
            }
            if ($isEnabled) {
                $classes[] = $className;
            }
        }

        return implode(' ', $classes);
    }

}