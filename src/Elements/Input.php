<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

class Input extends Element
{

    public function __construct(?string $name = null, mixed $value = null)
    {
        $this->addAttribute('type', 'text');

        if ($name !== null) {
            $this->initializeDefault($name);
        }

        $actualValue = $this->getOldValue($name, $value);
        if ($actualValue !== null) {
            $this->addAttribute('value', $actualValue);
        }
    }

    protected function tagName(): string
    {
        return 'input';
    }
}