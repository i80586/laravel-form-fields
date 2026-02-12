<?php

declare(strict_types=1);

namespace i80586\Form\Traits;

/**
 * Provides access to previously submitted form values.
 *
 * Relies on Laravel's `old()` helper function.
 *
 * @author Rasim Ashurov
 * @date 8 February 2026
 */
trait Valuable
{

    /**
     * Indicates whether the element should restore its value
     * from previously submitted (old) input.
     */
    private bool $withOldValue = true;

    /**
     * Disables automatic restoration of old input for the element.
     *
     * When disabled, the element will ignore previously submitted
     * values and rely only on the explicitly provided value.
     */
    public function withoutOld(): static
    {
        $this->withOldValue = false;
        return $this;
    }

    /**
     * Retrieves the previously submitted (old) input value.
     *
     * If the given name is null, the provided default value is returned.
     * Otherwise, the Laravel `old()` helper is used to resolve the value.
     */
    protected function getOldValue(?string $name, mixed $defaultValue = null): mixed
    {
        if ($name === null) {
            return $defaultValue;
        }
        return old($this->prepareName($name), $defaultValue);
    }

    /**
     * Enables automatic restoration of old input for the element.
     */
    protected function enableOldValue(): static
    {
        $this->withOldValue = true;
        return $this;
    }

    /**
     * Determines whether old input restoration is enabled.
     */
    protected function withOldValue(): bool
    {
        return $this->withOldValue;
    }

}