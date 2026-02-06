<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

use i80586\Form\Element;

class Input extends Element
{

    public function __construct(protected ?string $name = null, protected mixed $value = null)
    {
        if ($this->name !== null) {
            $this->addAttribute('name', $this->name);
            $this->addAttribute('id', $this->convertNameToId($this->name));
        }
        if ($this->value !== null) {
            $this->addAttribute('value', $this->value);
        }
    }

    protected function tagName(): string
    {
        return 'input';
    }

    protected function isClosable(): bool
    {
        return false;
    }

    protected function initialize(): void
    {
        // TODO: Implement initialize() method.
    }
}