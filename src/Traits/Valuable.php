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

    protected function getOldValue(?string $name, mixed $defaultValue = null): mixed
    {
        if ($name === null) {
            return $defaultValue;
        }
        return old($this->prepareName($name), $defaultValue);
    }

}