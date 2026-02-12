<?php

namespace i80586\Form\Traits;

/**
 * Provides a fluent API for managing HTML attributes.
 *
 * Dynamic calls (via __call) are treated as attribute setters:
 * $el->class('btn')->disabled(true)->required();
 *
 * @author Rasim Ashurov
 * @date 7 February 2026
 */
trait Attributable
{

    /**
     * Stores element attributes.
     *
     * @var array<string, mixed>
     */
    protected array $attributes = [];

    /**
     * Handles dynamic attribute setters.
     *
     * The called method name becomes the attribute name. The first argument is used
     * as the attribute value. When multiple scalar arguments are provided, they are
     * concatenated with a space. When an array is provided, it is treated as a class
     * map and converted to a space-separated string.
     *
     * @param string $name       Attribute name.
     * @param array  $arguments  Attribute value arguments.
     */
    public function __call(string $name, array $arguments): static
    {
        $this->addAttribute($name, $this->prepareAttributeValue($arguments));
        return $this;
    }

    /**
     * Sets or replaces an attribute value.
     *
     * @param string $name   Attribute name.
     * @param mixed  $value  Attribute value.
     */
    protected function addAttribute(string $name, mixed $value = null): static
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Checks whether an attribute exists.
     *
     * @param string $name Attribute name.
     */
    protected function hasAttribute(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Removes all attributes.
     */
    protected function resetAttributes(): void
    {
        $this->attributes = [];
    }

    /**
     * Appends a CSS class to the "class" attribute.
     *
     * @param string $className CSS class to append.
     */
    protected function appendClass(string $className): static
    {
        if (isset($this->attributes['class']) && !is_bool($this->attributes['class'])) {
            $this->attributes['class'] .= ' ' . $className;
        } else {
            $this->attributes['class'] = $className;
        }
        return $this;
    }

    /**
     * Checks whether the "class" attribute contains the given class name.
     *
     * @param string $className CSS class to check.
     */
    protected function hasClass(string $className): bool
    {
        return isset($this->attributes['class']) && str_contains($this->attributes['class'], $className);
    }

    /**
     * Converts attributes into an HTML-safe string.
     *
     * - null values render as a boolean attribute: disabled
     * - boolean true renders the attribute name: required
     * - boolean false omits the attribute
     * - other values render as key="value" with double quotes encoded
     */
    protected function buildAttributesString(): string
    {
        $this->sortAttributes();

        $attributesString = join(' ', array_filter(array_map(function ($key) {
            $value = $this->attributes[$key];
            if ($value === null) {
                return $key;
            }
            if (is_bool($value)) {
                return $value ? $key : '';
            }
            return $key . '="' . $this->escapeAttribute((string)$value) . '"';
        }, array_keys($this->attributes))));
        if (!empty($attributesString)) {
            $attributesString = ' ' . $attributesString;
        }
        return $attributesString;
    }

    /**
     * Sorts element attributes by their values.
     *
     * Ensures that attributes with non-null values are placed
     * before attributes with null values while preserving
     * the original keys.
     *
     * This helps produce cleaner and more predictable
     * HTML output during rendering.
     */
    private function sortAttributes(): void
    {
        uasort($this->attributes, fn ($a, $b) => ($a === null) <=> ($b === null));
    }

    /**
     * Normalizes a dynamic attribute value from __call arguments.
     *
     * Supported forms:
     * - no arguments: null
     * - one scalar argument: that value
     * - multiple scalar arguments: joined by spaces
     * - array argument: treated as a class map (['btn' => true, 'd-none' => false])
     *   or a list of class names (['btn', 'btn-primary'])
     *
     * @param array $arguments Raw arguments from __call.
     */
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

    /**
     * Encodes double quotes for safe HTML attribute output.
     *
     * @param string $value Raw value.
     */
    private function escapeAttribute(string $value): string
    {
        return str_replace('"', '&quot;', $value);
    }

}