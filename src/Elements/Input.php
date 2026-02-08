<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

use i80586\Form\Element;
use i80586\Form\Traits\NonClosable;

class Input extends Element
{

    use NonClosable;

    public function __construct(?string $name = null, mixed $value = null)
    {
        $this->addAttribute('type', 'text');

        if ($name !== null) {
            $this->addAttribute('name', $name);
            $this->addAttribute('id', $this->makeDefaultId($name));
        }
        if ($value !== null) {
            $this->addAttribute('value', $value);
        }
    }

    protected function tagName(): string
    {
        return 'input';
    }

    protected function initialize(): void
    {
        // TODO: Implement initialize() method.
    }
}