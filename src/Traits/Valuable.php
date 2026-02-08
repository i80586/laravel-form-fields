<?php

declare(strict_types=1);

namespace i80586\Form\Traits;

trait Valuable
{

    protected function getOldValue(?string $name, mixed $defaultValue = null): mixed
    {
        if ($name === null) {
            return $defaultValue;
        }
        return old($this->prepareName($name), $defaultValue); // Laravel helper function
    }

}